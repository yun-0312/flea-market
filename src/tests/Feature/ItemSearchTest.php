<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    //商品名で部分一致ができる
    public function it_can_search_items_by_partial_match()
    {
        Item::factory()->create(['name' => 'iPhoneケース']);
        Item::factory()->create(['name' => 'iPhone16 Pro']);
        Item::factory()->create(['name' => 'Androidカバー']);
        $response = $this->get('/?keyword=iPhone');
        $response->assertSee('iPhoneケース');
        $response->assertSee('iPhone16 Pro');
        $response->assertDontSee('Androidカバー');
    }

    /** @test */
    //検索名がマイリストでも保持されている
    public function
    search_keyword_is_kept_when_switching_tabs_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item1 = Item::factory()->create(['name' => 'iPhone11']);
        $item2 = Item::factory()->create(['name' => 'Galaxy']);
        $user->favorites()->attach($item1->id);

        // 商品一覧で検索
        $response = $this->get('/?keyword=phone&tab=recommend');
        $response->assertSee('iPhone11');
        $response->assertDontSee('Galaxy');

        // タブを mylist に切り替え
        $response = $this->get('/?keyword=phone&tab=mylist');
        $response->assertViewHas('keyword', 'phone');

        // マイリスト内の検索結果確認
        $response->assertSee('iPhone11');
        $response->assertDontSee('Galaxy');
    }
}
