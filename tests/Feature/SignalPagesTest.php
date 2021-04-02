<?php

namespace Tests\Feature;

use Tests\TestCase;

class SignalPagesTest extends TestCase
{
    /** @test */
    public function it_can_show_index_page()
    {
        $this->get('/')->assertOk();
    }
    /** @test */
    public function it_can_show_sms_page(): void
    {
        $this->get('/sms')->assertOk();
    }
}
