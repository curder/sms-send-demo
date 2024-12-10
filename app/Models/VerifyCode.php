<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class VerifyCode extends Model
{
    protected $table ='sms_logs';

    protected function casts(): array
    {
        return [
            'data' => 'json',
            'result' => 'json',
        ];
    }
    public function code(): Attribute
    {
        return Attribute::get(fn () => Arr::get($this, 'data.code'));
    }

    public function platform(): Attribute
    {
        return Attribute::get(fn () => array_keys(Arr::get($this, 'result'))[0]);
    }

    public function expiredAt(): Attribute
    {
        return Attribute::get(fn () => Carbon::parse(Arr::get($this, 'data.expireAt'))->format('Y-m-d H:i:s'));
    }

    public function sentAt(): Attribute
    {
        return Attribute::get(fn () => Carbon::parse(Arr::get($this, 'data.sentAt'))->format('Y-m-d H:i:s'));
    }
}