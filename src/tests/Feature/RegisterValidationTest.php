<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterValidationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function it_requires_name_when_registering()
    {
        //Fortifyの登録パスにPOSTリクエストを送る
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        //バリデーションエラーがnameに対して返ることを確認
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }
}
