<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
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
    public function logged_in_user_can_list_item()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
