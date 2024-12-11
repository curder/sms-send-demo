<?php

use App\Enums\EventTypeEnum;
use App\Livewire\Forms\LoginForm;
use App\Rules\ChinesePhoneNumber;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {

    public string $phone = '';
    public string $verify_code = '';

    public function updatedPhone(): void
    {
        $this->dispatch(EventTypeEnum::PhoneUpdated->value, ['phone' => $this->phone]);
    }

    #[\Livewire\Attributes\On(EventTypeEnum::SmsSendFailed->value)]
    public function smsSendFailed($event): void
    {
        $this->resetValidation('phone');
        $this->addError('phone', $event['message']);
    }

    #[\Livewire\Attributes\On(EventTypeEnum::SmsSendSuccess->value)]
    public function smsSendSuccess(): void
    {
        $this->resetValidation('phone');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        // 校验验证码是否正确
        if (!Sms::checkCode($this->phone, $this->verify_code)) {
            $this->addError('verify_code', __('Verify Code Invalid'));
            return;
        }

        Auth::login(\App\Models\User::wherePhone($this->phone)->first());

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', new ChinesePhoneNumber, 'exists:users,phone'],
            'verify_code' => ['required', 'digits:6'],
        ];
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form wire:submit.prevent="login">
        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone number')"/>
            <x-text-input wire:model.live.debounce="phone" id="phone" class="block mt-1 w-full" type="text"
                          name="phone" required
                          autocomplete="phone"/>
            <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
        </div>

        <!-- Verify Code -->
        <div class="mt-4">
            <x-input-label for="verify_code" :value="__('Verify Code')"/>
            <div class="flex items-center space-x-4">
                <x-text-input wire:model="verify_code" id="verify_code" class="block mt-1 w-[17rem]" type="text"
                              name="verify_code" required
                              autocomplete="verify_code"/>
                <livewire:sms-send :type="\App\Enums\SmsSendTypeEnum::Login"/>
            </div>
            <x-input-error :messages="$errors->get('verify_code')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('register'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('register') }}" wire:navigate>
                    {{ __('Register a new account?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
