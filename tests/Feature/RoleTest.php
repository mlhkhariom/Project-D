<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_access_super_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        $response = $this->actingAs($user)->get('/superadmin/dashboard');

        $response->assertStatus(200);
    }

    public function test_client_admin_can_access_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_customer_cannot_access_super_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($user)->get('/superadmin/dashboard');

        $response->assertStatus(403);
    }

    public function test_client_admin_cannot_access_super_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/superadmin/dashboard');

        $response->assertStatus(403);
    }

    public function test_super_admin_cannot_access_admin_dashboard()
    {
        // Depending on logic, super admin MIGHT access admin dashboard.
        // But currently middleware 'role:admin' requires exact match?
        // Let's check CheckRole logic: in_array(Auth::user()->role, $roles)
        // So yes, strictly checks if role is in list.

        $user = User::factory()->create(['role' => 'super_admin']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }
}
