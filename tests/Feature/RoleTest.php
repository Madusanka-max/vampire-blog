<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RoleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertStatus(200);
    }

    public function test_editor_cannot_delete_users()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');
        $this->actingAs($editor)
            ->delete('/admin/users/1')
            ->assertForbidden();
    }
}
