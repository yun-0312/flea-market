<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profile;

class EditProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_edit_form_displays_initial_values()
    {
        $user = User::factory()->create(['name' => '山田花子']);
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'image_url' => 'hanako.jpg',
            'post_code' => '170-0011',
            'address' => '東京都豊島区池袋1-1-1',
            'building' => '花子ビル',
        ]);
        $this->actingAs($user);
        $response = $this->get(route('profile.edit'));
        $response->assertStatus(200);
        // 初期値の表示確認
        $response->assertSee('hanako.jpg');
        $response->assertSee('value="山田花子"', false);
        $response->assertSee('value="170-0011"', false);
        $response->assertSee('value="東京都豊島区池袋1-1-1"', false);
        $response->assertSee('value="花子ビル"', false);
    }

}
