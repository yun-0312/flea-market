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
    //userの名前入力のバリデーションチェック
    public function username_is_required()
    {
        $this->withSession([]);
        $response = $this->post('/register', [
            '_token' => csrf_token(),
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }

    /** @test */
    //userのメールアドレス入力のバリデーションチェック
    public function email_is_required()
    {
        $this->withSession([]);
        $response = $this->post('/register', [
            '_token' => csrf_token(),
            'name' => 'test',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    /** @test */
    //userのパスワード入力のバリデーションチェック
    public function password_is_required()
    {
        $this->withSession([]);
        $response = $this->post('/register', [
            '_token' => csrf_token(),
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password123'
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    /** @test */
    //userのパスワード入力(8文字以上）のバリデーションチェック
    public function password_must_be_at_least_8_characters()
    {
        $this->withSession([]);
        $response = $this->post('/register', [
            '_token' => csrf_token(),
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください'
        ]);
    }

    /** @test */
    //userの確認用パスワード入力のバリデーションチェック
    public function password_confirmation_must_match()
    {
        $this->withSession([]);
        $response = $this->post('/register', [
            '_token' => csrf_token(),
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password1234'
        ]);
        $response->assertSessionHasErrors([
            'password_confirmation' => 'パスワードと一致しません'
        ]);
    }

    /** @test */
    // 全ての項目が入力されている場合、会員情報が登録されログイン画面に遷移される
    public function user_can_register_with_valid_input()
    {
        $this->withSession([]);
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/mypage/profile');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}
