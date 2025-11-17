<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    //「購入する」ボタンを押下すると購入が完了する
    public function a_user_can_register_a_new_item()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $categories = Category::factory()->count(3)->create();
        $data = [
            'name'        => 'テスト商品',
            'brand'       => 'テストブランド',
            'description' => 'これは説明文です。',
            'price'       => 1200,
            'condition'   => 2,
            'categories'  => $categories->pluck('id')->toArray(),
            'image_url'   => UploadedFile::fake()->image('test.jpg'),
        ];
        $response = $this->actingAs($user)->post(route('item.store'), $data);
        $response->assertRedirect(route('mypage.show'));
        $this->assertDatabaseHas('items', [
            'name'        => 'テスト商品',
            'brand'       => 'テストブランド',
            'description' => 'これは説明文です。',
            'price'       => 1200,
            'condition'   => 2,
            'user_id'     => $user->id,
        ]);
        $item = Item::first();
        foreach ($categories as $category) {
            $this->assertDatabaseHas('category_item', [
                'item_id'     => $item->id,
                'category_id' => $category->id,
            ]);
        }
        Storage::disk('public')->assertExists('images/items/' . $item->image_url);
    }
}
