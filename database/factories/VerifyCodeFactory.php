<?php

namespace Database\Factories;

use App\Models\VerifyCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VerifyCodeFactory extends Factory
{
    protected $model = VerifyCode::class;

    public function definition(): array
    {
        return [
            'mobile' => Str::trim(fake()->e164PhoneNumber(), '+'),
            'data' => fake()->words(),
            'is_sent' => true,
            'result' => fake()->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function withDataColumn(): self
    {
        return $this->state(fn(array $attributes) => [
            'data' => [
                'to' => Str::start($attributes['mobile'], 86),
                'code' => fake()->randomNumber(),
                'sent' => fake()->boolean,
                'attempts' => 0,
                'expireAt' => Carbon::now()->addMinutes(10),
                'sentAt' => Carbon::now(),
            ],
        ]);
    }

    public function withResultColumn(): self
    {
        return $this->state(fn(array $attributes) => [
            'result' => [
                'errorlog' => [
                    'gateway' => 'errorlog',
                    'status' => 'success',
                    'template' => null,
                    'result' => [
                        'status' => true,
                        'file' => storage_path('logs/laravel-sms.log'),
                    ]
                ]
            ],
        ]);
    }
}
