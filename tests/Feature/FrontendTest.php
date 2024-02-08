<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access_home_without_login()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function testAccessHomeAfterLogin()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
