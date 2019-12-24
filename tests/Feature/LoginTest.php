<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_login()
    {
        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
        ];

        $response = $this->json('POST','/api/auth/register',$data);

        $data = [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ];

        $response = $this->json('POST','/api/auth/login',$data);

        $response->assertStatus(200);
//        $this->assertArrayHasKey('Authorization',$response->json());
    }
}
