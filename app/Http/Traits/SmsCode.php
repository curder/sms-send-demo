<?php

namespace App\Http\Traits;

use App\Enums\SmsSignatureEnum;
use App\Type;
use DB;
use Illuminate\Support\Facades\Config;
use PhpSms;
use Illuminate\Support\Str;
use Toplan\Sms\Facades\SmsManager;
use App\Http\Requests\SmsVerifyRequest;
use Illuminate\Support\Facades\Validator;

/**
 * Trait SmsCode
 *
 * @package App\Http\Traits
 */
trait SmsCode
{
    /**
     * 发送验证码
     *
     * @param \App\Http\Requests\SmsVerifyRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSmsCode(SmsVerifyRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = SmsManager::validateSendable();
        if (!$result['success']) {
            return $this->formatResponseData($result);
        }

        $result = SmsManager::validateFields();
        if (!$result['success']) {
            return $this->formatResponseData($result);
        }

        $result = SmsManager::requestVerifySms();
        if (!$result['success']) {
            return $this->formatResponseData($result);
        }

        return response()->json($result);
    }

    /**
     * @return array
     */
    protected function validateErrorMessages() : array
    {
        return [
            'phone.required' => __('register.phone_required'),
        ];
    }
    /**
     * @param $result
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function formatResponseData($result) : \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $result['message'],
            'errors' => ['phone' => [$result['message']]],
            'type' => $result['type'],
            'status' => $result['success'],
        ], 422);
    }
}
