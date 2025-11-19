<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    //会員登録後、認証メールが送信される
    public function user_receives_email_verification_notification_after_register()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/mypage/profile');

        $user = User::where('email', 'test@example.com')->first();

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }

    /** @test */
    //メール認証誘導画面で「認証はこちらから」ボタンを押すとメール認証サイトに遷移する
    public function email_verify_page_is_displayed()
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user);

        $response = $this->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('認証はこちらから');
    }

    /** @test */
    //メール認証画面で「認証はこちらから」ボタンを押すとメール認証サイトに遷移する
    public function user_can_request_verification_link()
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user);

        $response = $this->post('/email/verification-notification');

        $response->assertRedirect();
    }

    /** @test */
    //メール認証サイトのメール認証を完了すると、プロフィール設定画面に遷移する
    public function user_is_redirected_to_profile_after_verification()
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/mypage/profile');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
