<?php
namespace Tests\Unit\Integration\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // 发送验证码
    public function it_can_send_sms() : void
    {
        $response = $this->postJson('/api/sms', ['phone' => 13800138000]);
        $this->assertDatabaseHas('laravel_sms', [
            'to' => 13800138000,
        ]);
        $response->assertOk()->assertJson([
                'success' => true, 'type' => 'sms_sent_success',
                'message' => config('laravel-sms.notifies.sms_sent_success'),
            ]);
    }
}
