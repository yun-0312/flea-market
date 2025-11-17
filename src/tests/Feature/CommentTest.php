<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    //ログイン済みのユーザーはコメントを送信できる
    public function logged_in_user_can_post_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'comment' => 'とても良い商品ですね！'
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'とても良い商品ですね！'
        ]);
    }

    /** @test */
    //ログイン前のユーザーはコメントを送信できない
    public function guest_user_cannot_post_comment()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => '買いたいです'
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    //コメントを入力せず送信ボタンを押したらエラーメッセージが表示される
    public function comment_is_required()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post("/item/{$item->id}/comment", [
                'comment' => '',
            ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください'
        ]);

        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    //コメントが255文字以上の場合エラーメッセージが表示される
    public function comment_must_be_less_than_255_characters()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $longComment = str_repeat('あ', 256);
        $response = $this->actingAs($user)
            ->post("/item/{$item->id}/comment", [
                'comment' => $longComment
            ]);
        $response->assertSessionHasErrors([
            'comment' => 'コメントは255文字以内で入力してください'
        ]);
        $this->assertDatabaseCount('comments', 0);
    }
}
