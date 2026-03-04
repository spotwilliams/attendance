<?php

use Cat\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the login page', function (): void {
    $this->get('/login')->assertSuccessful();
});

it('redirects authenticated users away from login', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/login')
        ->assertRedirect();
});

it('logs in with valid credentials', function (): void {
    $user = User::factory()->create([
        'password' => bcrypt('secret123'),
    ]);

    $this->post('/login', [
        'email'    => $user->email,
        'password' => 'secret123',
    ])->assertRedirect('/home');

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid password', function (): void {
    $user = User::factory()->create([
        'password' => bcrypt('correct-password'),
    ]);

    $this->post('/login', [
        'email'    => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors();

    $this->assertGuest();
});

it('rejects unknown email', function (): void {
    $this->post('/login', [
        'email'    => 'nobody@example.com',
        'password' => 'whatever',
    ])->assertSessionHasErrors();

    $this->assertGuest();
});

it('requires email field', function (): void {
    $this->post('/login', ['password' => 'secret'])
        ->assertSessionHasErrors('email');
});

it('requires password field', function (): void {
    $this->post('/login', ['email' => 'user@example.com'])
        ->assertSessionHasErrors('password');
});

it('logs out an authenticated user', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/logout')
        ->assertRedirect();

    $this->assertGuest();
});

it('redirects unauthenticated users to login from protected routes', function (): void {
    $this->get('/home')->assertRedirect('/login');
});
