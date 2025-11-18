<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Purchase;
use Tests\TestCase;

class MyListTest extends TestCase
{
    /** @test */
    //いいねした商品だけが表示される
    public function only_favorited_items_are_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $likedItem = Item::factory()->create(['name' => 'お気に入り商品']);
        $otherItem = Item::factory()->create(['name' => '非お気に入り商品']);
        // いいね登録
        $user->favorites()->attach($likedItem->id);
        // マイリストページへアクセス
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('お気に入り商品');
        $response->assertDontSee('非お気に入り商品');
    }
    /** @test */
    //購入済み商品は「Sold」と表示される
    public function sold_label_is_displayed_for_purchased_items_in_mylist()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create([
            'name' => '出品者',
        ]);
        $purchaser = User::factory()->create([
            'name' => '購入者',
        ]);
        $this->actingAs($user);
        $soldItem = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
        ]);
        Purchase::factory()->create([
            'item_id' => $soldItem->id,
            'user_id' => $purchaser->id,
        ]);
        $user->favorites()->attach($soldItem->id);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
        $response->assertSee('Sold');
    }

    /** @test */
    //未認証の場合は何も表示されない
    public function mylist_displays_nothing_for_guest_user()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('');
    }

}
