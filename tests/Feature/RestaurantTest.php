<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_restaurant_index()
    {
        $response = $this->get(route('restaurants.index'));
        $response->assertStatus(200);
    }
    public function test_user_can_access_restaurant_index()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('restaurants.index'));
        $response->assertStatus(200);
    }
    public function test_admin_cannot_access_restaurant_index()
    {
        $adminUser = User::factory()->create();
        $response = $this->actingAs($adminUser, 'admin')->get(route('restaurants.index'));
        $response->assertRedirect(route('admin.home'));
    }
}
