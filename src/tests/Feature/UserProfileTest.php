<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Purchase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    //必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
    public function test_user_profile_information_is_displayed_correctly()
    {
        $user = User::factory()->create(['name' => '山田太郎']);
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'image_url' => 'test_profile.jpg',
        ]);
        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
            'image_url' => 'sell_item.jpg',
        ]);
        $buyItem = Item::factory()->create([
            'name' => '購入商品B',
            'image_url' => 'buy_item.jpg',
        ]);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
        ]);
        $this->actingAs($user);
        // 出品商品ページを確認
        $responseSell = $this->get('/mypage?page=sell');
        $responseSell->assertStatus(200);
        $responseSell->assertSee('山田太郎');
        $responseSell->assertSee('出品商品A');
        $responseSell->assertSee('test_profile.jpg');
        // 購入商品ページを確認
        $responseBuy = $this->get('/mypage?page=buy');
        $responseBuy->assertStatus(200);
        $responseBuy->assertSee('購入商品B');
    }
}
