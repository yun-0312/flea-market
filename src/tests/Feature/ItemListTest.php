<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    //未認証の場合、全商品が表示される
    public function all_items_are_displayed()
    {
        $items = Item::factory()->count(3)->create();
        $response = $this->get('/');
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }

        $response->assertStatus(200);
    }

    /** @test */
    //購入済み商品は「Sold」と表示される
    public function sold_items_show_sold_label()
    {
        $item = Item::factory()->create();
        Purchase::factory()->create([
            'item_id' => $item->id,
        ]);
        $response = $this->get('/');
        $response->assertSee('Sold');
        $response->assertSee($item->name);
    }

    /** @test */
    //自分が出品した商品は表示されない
    public function own_items_are_not_display()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'MY_PRODUCT'
        ]);
        Item::factory()->create([
            'name' => 'OTHER_PRODUCT',
        ]);
        $response = $this->get('/');
        $response->assertDontSee('MY_PRODUCT');
        $response->assertSee('OTHER_PRODUCT');
    }
}
