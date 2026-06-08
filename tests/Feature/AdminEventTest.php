<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_if_not_logged_in()
    {
        $response = $this->post('/admin/event', []);

        $response->assertRedirect('/admin/login');
    }

    public function test_event_date_in_past()
    {
        $response = $this->withSession([
            'admin_logged_in' => true
        ])->post('/admin/event', [
            'registration_link' => 'https://google.com',
            'event_date' => now()->subDay(),
            'title' => 'Test Event'
        ]);

        $response->assertStatus(302);

        $response->assertSessionHas(
            'error',
            'Tanggal event tidak boleh di masa lalu!'
        );
    }

    public function test_success_create_event()
    {
        $response = $this->withSession([
            'admin_logged_in' => true
        ])->post('/admin/event', [

            'title' => 'Test Event',
            'description' => 'desc',
            'category' => 'tech',
            'prodi' => 'TI',

            'event_type' => 'offline',

            'event_date' => now()->addDay(),

            'location' => 'Kampus Telkom',

            'price' => 'FREE',

            'target_participants' => 100,

            'registration_link' => 'https://google.com',

            'organizer_name' => 'BEM',

            'contact_person' => '08123456'
        ]);

        $response->assertRedirect(
            route('admin.events')
        );

        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'status' => 'approved',
            'submitted_by' => 'admin'
        ]);
    }
}