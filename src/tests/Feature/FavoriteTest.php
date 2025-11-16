<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    //いいねアイコンを押すと、言い値した商品として登録できる
    public function user_can_add_favorite()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->post(route('favorite.toggle', $item));
        // favorites テーブルに追加されている
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    //言いねした商品のアイコンは色が変化する
    public function favorite_icon_changes_when_item_is_favorited()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->actingAs($user);
        $response = $this->get(route('item.show', $item));
        // 赤色アイコン（お気に入り済）を表示しているか確認
        $response->assertSee('星アイコン赤.png');
        $response->assertSee('1');
    }

    /** @test */
    //再度いいねボタンを押したら、いいねを解除できる
    public function user_can_remove_favorite()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->actingAs($user);
        // 解除前は存在する
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        // いいね解除（toggle）
        $this->post(route('favorite.toggle', $item));
        // favorites テーブルから削除される
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
