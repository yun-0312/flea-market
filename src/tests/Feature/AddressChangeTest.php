<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Item;
use App\Models\ShippingAddress;
use Tests\TestCase;
use Stripe\Checkout\Session;
use Mockery;


class AddressChangeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    //送付先住所変更画面にて登録した住所が商品購入画面に反映されている
    public function test_shipping_address_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user);
        // 住所を変更（セッションに保存）
        $response = $this->post(route('purchase.save', ['item' => $item->id]), [
            'post_code' => '160-0022',
            'address' => '東京都新宿区新宿1-1-1',
            'building' => 'テストビル',
            'payment_method' => 1,
        ]);
        $response->assertRedirect(route('purchase.show', ['item' => $item->id]));
        $response = $this->get(route('purchase.show', ['item' => $item->id]));
        $response->assertStatus(200);
        $response->assertSee('〒160-0022');
        $response->assertSee('東京都新宿区新宿1-1-1');
        $response->assertSee('テストビル');
    }

    public function test_shipping_address_is_saved_with_purchase()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user);

         // StripeのSessionクラスをモック
        $mock = Mockery::mock('alias:' . Session::class);
        $mock->shouldReceive('create')
            ->once()
            ->andReturn((object)['url' => 'https://stripe.test/session']);

        $this->post(route('purchase.save', ['item' => $item->id]), [
            'post_code' => '160-0022',
            'address' => '東京都新宿区新宿1-1-1',
            'building' => 'テストビル',
            'payment_method' => 2,
        ]);
        // 商品を購入
        $response = $this->post(route('purchase.store', ['item' => $item->id]), [
            'payment_method' => 2,
        ]);
        $response->assertRedirect('https://stripe.test/session');
        $this->assertDatabaseHas('shipping_addresses', [
            'user_id' => $user->id,
            'post_code' => '160-0022',
            'address' => '東京都新宿区新宿1-1-1',
            'building' => 'テストビル',
        ]);
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 2,
        ]);
    }

}
