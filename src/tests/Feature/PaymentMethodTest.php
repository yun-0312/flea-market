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
        Profile::factory
        ()->create(['user_id' => $buyer->id]);
        $item = Item::factory()->for($seller)->create();
        $this->actingAs($buyer);
        // ②支払い方法をセッションに保存する（コンビニ = 1）
        $this->withSession([
            'shipping_address' => [
                'post_code' => '123-4567',
                'address' => '東京都テスト区1-1',
                'building' => 'テストビル',
            ],
            'payment_method' => 2, 
        ]);
        $response = $this->get(route('purchase.show', ['item' => $item->id]));
        $response->assertStatus(200);
        $response->assertViewHas('sessionPayment', 2);
        $response->assertSee('カード支払い');
    }
}