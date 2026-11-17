<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_public_pages_open_on_an_empty_shop(): void
    {
        \App\Models\Setting::forceCreate(['website_name' => 'Jonopriyo Bazar']);

        foreach (['/', '/login', '/register', '/faq'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_customer_pages_need_a_login(): void
    {
        $this->get(route('user.point.index'))->assertRedirect();
        $this->get(route('user.wallet.index'))->assertRedirect();
    }
}
