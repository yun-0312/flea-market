<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    //必要な情報が表示される（商品画像、商品名、ブランド名、価格、いいね数、商品説明、商品情報（カテゴリ、商品の状態）、コメント数、コメントしたユーザー情報、コメント内容）
    public function item_detail_displays_all_information()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 9999,
            'description' => '商品の説明テキスト',
            'image_url' => 'test.jpg',
            'condition' => 1,
        ]);
        $category1 = Category::factory()->create(['name' => 'カテゴリA']);
        $category2 = Category::factory()->create(['name' => 'カテゴリB']);
        $item->categories()->attach([$category1->id, $category2->id]);
        $favUser1 = User::factory()->create();
        $favUser2 = User::factory()->create();
        $item->favoritedBy()->attach([$favUser1->id, $favUser2->id]);
        Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $favUser1->id,
            'comment' => 'コメント1',
        ]);
        Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $favUser2->id,
            'comment' => 'コメント2',
        ]);
        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        // 商品基本情報
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('￥');
        $response->assertSee('9,999');
        $response->assertSee('商品の説明テキスト');

        // 商品画像（パスが一致するか）
        $response->assertSee('storage/images/items/' . $item->image_url);

        // お気に入り数（2）
        $response->assertSee('2');

        // コメント数（2）
        $response->assertSee('(2)');

        // コメント内容とユーザー名
        $response->assertSee($favUser1->name);
        $response->assertSee('コメント1');
        $response->assertSee($favUser2->name);
        $response->assertSee('コメント2');

        // カテゴリ 2つ
        $response->assertSee('カテゴリA');
        $response->assertSee('カテゴリB');

        // 商品状態（アクセサ）
        $response->assertSee($item->condition_label);
    }

    /** @test */
    //複数カテゴリが正しく表示されるか
    public function test_multiple_categories_are_displayed() {
        $item = Item::factory()->create();

        $category1 = Category::factory()->create(['name' => 'トップス']);
        $category2 = Category::factory()->create(['name' => 'レディース']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get(route('item.show', $item));

        $response->assertSee('トップス');
        $response->assertSee('レディース');
    }
}
