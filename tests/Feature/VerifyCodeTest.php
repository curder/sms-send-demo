<?php

use App\Models\VerifyCode;

test('verify-codes page is displayed', function () {
    $code = VerifyCode::factory()->withDataColumn()->withResultColumn()->create();

    $response = $this->get('/verify-codes');

    $response->assertOk()
        ->assertSee($code->mobile)
        ->assertSee($code->platform)
        ->assertSee($code->code)
        ->assertSee($code->expired_at)
        ->assertSee($code->sent_at)
    ;
});