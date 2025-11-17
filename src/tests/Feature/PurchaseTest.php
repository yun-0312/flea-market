<?php

namespace Tests\Feature;

use  Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;
use App\Models\ShippingAddress;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    //「購入する」ボタンを押下すると購入が完了する
    public function user_can_create_purchase_records()
    {
        $user = User::factory()->create();
        Profile::factory()->create([
            'user_id' => $user->id,
            'post_code' => '123-4567',
            'address' => '東京都品川区1-1-1',
            'building' => 'テストビル',
        ]);
        $this->actingAs($user);
        $item = Item::factory()->create();
            session([
                'shipping_address' => [
                'post_code' => '111-2222',
                'address' => '大阪府大阪市1-2-3',
                'building' => '大阪ビル',
            ]
        ]);
        $address = ShippingAddress::create([
            'user_id' => $user->id,
            'post_code' => '111-2222',
            'address' => '大阪府大阪市1-2-3',
            'building' => '大阪ビル',
        ]);
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_address_id' => $address->id,
            'payment_method' => 2,
        ]);
        // DB確認
        $this->assertDatabaseHas('shipping_addresses', [
            'user_id' => $user->id,
            'post_code' => '111-2222',
            'address' => '大阪府大阪市1-2-3',
        ]);
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 2,
        ]);
    }

    /** @test */
    //購入した商品は商品一覧画面にて「Sold」と表示される
    public function purchased_item_displays_sold_on_item_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::factory()->create();
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test */
    //「プロフィール/購入した商品一覧」に追加されている
    public function purchased_item_appears_in_profile_buy_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create();
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee($item->name);
    }
}
