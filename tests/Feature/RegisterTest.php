<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_register()
    {
        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
        ];

        $response = $this->json('POST','/api/auth/register',$data);

        $response->assertStatus(200);
    }
}
