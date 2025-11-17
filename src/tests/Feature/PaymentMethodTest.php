<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    //小計画面で変更が反映される
    public function selected_payment_method_is_reflected_on_purchase_page()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        Profile::factory()->create(['user_id' => $buyer->id]);
        $item = Item::factory()->for($seller)->create();
        $response = $this->actingAs($buyer)->get(route('purchase.show', $item->id));
        $response->assertStatus(200);
        $response->assertViewHas('sessionPayment', null);

        // ②支払い方法をセッションに保存する（コンビニ = 1）
        $this->actingAs($buyer)->post(route('purchase.save', $item->id), [
            'post_code' => '123-4567',
            'address'   => '東京都テスト区1-1',
            'building'  => 'テストビル',
            'payment_method' => 1,
        ])->assertRedirect(route('purchase.show', $item->id));

        // セッションに保存されたか確認
        $this->assertEquals(1, session('payment_method'));

        // ③再度購入画面にアクセスし、反映されていることを確認
        $response = $this->actingAs($buyer)->followingRedirects()->post(route('purchase.store', $item->id), [
            'post_code' => '123-4567',
            'address'   => '東京都テスト区1-1',
            'building'  => 'テストビル',
            'payment_method' => 1,
        ]);
        $response->assertStatus(200);
        $response->assertViewHas('sessionPayment', 1);

        // 画面内に支払い方法が反映されているか（例：hidden の value）
        $response->assertSee('value="1"', false);
    }
}
