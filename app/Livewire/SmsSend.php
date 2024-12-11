<?php

namespace App\Livewire;

use App\Enums\EventTypeEnum;
use App\Enums\SmsSendTypeEnum;
use App\Rules\ChinesePhoneNumber;
use iBrand\Sms\Facade as Sms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Overtrue\EasySms\Support\Config;

class SmsSend extends Component
{
    public string $phone = '';

    public SmsSendTypeEnum $type;
    public int $initialSecond = 60; // countdown time
    public int $second = 60; // seconds left on countdown
    public bool $is_sent = false;

    public function mount(SmsSendTypeEnum $type): void
    {
        $this->type = $type;
        $this->decrease();
    }


    public function send(): void
    {
        Sleep::sleep(0.85);
        $validator = Validator::make(['phone' => $this->phone], $this->validateRules());

        if ($validator->fails()) {
            $this->dispatch(EventTypeEnum::SmsSendFailed->value, ['message' => $validator->errors()->first('phone')]);
            return;
        }

        // 0. 判断当前是否为发送状态
        $this->decrease();

        if (!config('app.debug') && !Sms::verifyMobile($this->phone)) {
            $this->dispatch(EventTypeEnum::SmsSendFailed->value, ['message' => __('Invalid Phone')]);
            $this->is_sent = false;
            return;
        }

        if (!Sms::canSend($this->phone)) {
            $this->dispatch(EventTypeEnum::SmsSendFailed->value, ['message' => __('Limit Per Minute')]);
            $this->is_sent = false;
            return;
        }

        if (!Sms::send(Str::start($this->phone, 86), $this->type->data(), $this->type->gateways())) {
            $this->dispatch(EventTypeEnum::SmsSendFailed->value, ['message' => __('Sent Phone Failed')]);
            $this->is_sent = false;
            return;
        }

        // 1. 初始化缓存并设置缓存有效时间
        $this->initialCache();

        // 2. 设置发送状态
        $this->is_sent = true;
        $this->dispatch(EventTypeEnum::SmsSendSuccess->value, ['message' => __('Sent Success')]);
    }

    /**
     * 倒计时
     */
    public function decrease(): void
    {
        // 3. 查询缓存失效时间
        $ttl = $this->getCacheTTL();
        if ($ttl > 0) { // 如果有效，则将倒计时设置为缓存过期时间
            $this->second = $ttl;
            $this->is_sent = true;
        } else { // 如果无效则表示可以重新发送验证码
            $this->second = $this->initialSecond;
            $this->is_sent = false;
        }
    }

    #[On('phone-updated')]
    public function phoneUpdated($data): void
    {
        $this->phone = $data['phone'];
    }

    /**
     * 查询缓存失效时间
     */
    protected function getCacheTTL()
    {
        if (config('app.env') === 'testing') {
            return 60;
        }

        return Redis::command('TTL', [$this->getCacheKey()]);
    }

    /**
     * 初始化缓存并设置缓存有效时间
     */
    protected function initialCache(): void
    {
        if (config('app.env') === 'testing') {
            Cache::put($this->getCacheKey(), true, $this->initialSecond);
            return;
        }

        Redis::set($this->getCacheKey(), true, 'EX', $this->initialSecond);
    }

    /**
     * 缓存key
     * @return string
     */
    protected function getCacheKey(): string
    {
        return sprintf('sms-sent-countdown:%s:%d', $this->type->value, $this->phone);
    }

    protected function validateRules(): array
    {
        return match ($this->type) {
            SmsSendTypeEnum::Register => [
                'phone' => [
                    'required',
                    "unique:users,phone,{$this->phone}",
                    new ChinesePhoneNumber,
                ],
            ],
            SmsSendTypeEnum::Login => [
                'phone' => [
                    'required',
                    new ChinesePhoneNumber,
                    'exists:users,phone',
                ],
            ],
            default => throw new \LogicException('Invalid Sms Type'),
        };
    }

    public function render(): View
    {
        return view('livewire.sms-send');
    }
}
