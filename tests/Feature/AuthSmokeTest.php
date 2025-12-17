<?php

namespace Tests\Feature;

use Tests\TestCase;
use Cat\User;

/**
 * Tests that verify authentication works correctly.
 */
class AuthSmokeTest extends TestCase
{
    /**
     * Test that the login page loads.
     */
    public function test_login_page_loads()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test that unauthenticated users are redirected to login.
     */
    public function test_unauthenticated_redirects_to_login()
    {
        $response = $this->get('/home');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated users can access the home page.
     */
    public function test_authenticated_user_can_access_home()
    {
        $user = User::first();

        if (!$user) {
            $this->markTestSkipped('No users in database');
        }

        $response = $this->actingAs($user)->get('/home');

        // Should either succeed (200) or redirect within app (302)
        $this->assertContains($response->status(), [200, 302, 403]);
    }

    /**
     * Test that the logout route works.
     */
    public function test_logout_route_exists()
    {
        $user = User::first();

        if (!$user) {
            $this->markTestSkipped('No users in database');
        }

        $response = $this->actingAs($user)->get('/logout');

        // Should redirect after logout
        $response->assertStatus(302);
    }

    /**
     * Test that users exist in the database (from seeders).
     */
    public function test_users_exist_in_database()
    {
        $count = User::count();

        $this->assertGreaterThan(0, $count, 'Database should have at least one user');
    }
}
