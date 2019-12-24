<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use JWTAuth;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
//    public function authenticate(){
//        $user = User::create([
//            'name' => 'test',
//            'email' => 'test@gmail.com',
//            'password' => bcrypt('secret1234'),
//        ]);
//        $token = JWTAuth::fromUser($user);
//        return $token;
//    }

    public function create_product()
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
            'description' => 'Parboil rice, get pepper and mix, and some spice and serve!',
            'quantity' => 4,
            'price' => 450,
            'files' => [
                Storage::url('public/uploads/1577171134abstract-2468874_640.jpg')
            ]
        ]);
        $response->assertStatus(200);
    }
}
