<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use JWTAuth;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234'),
        ]);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','api/product/create_product',[
            'name' => 'Jollof Rice',
            'description' => 'Parboil rice, get pepper and mixture, and some spice and serve!',
            'quantity' => 4,
            'price' => 450,
            'files' => [
                Storage::url('public/uploads/1577171134abstract-2468874_640.jpg')
            ]
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('DELETE','api/product/delete_product/' . 1);
        $response->assertStatus(200);
    }
}
