<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminOtpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Path 1:
     * User admin tidak ditemukan
     */
    public function test_user_not_found()
    {
        $response = $this->post('/admin/verify-otp', [
            'email' => 'fake@admin.com',
            'otp' => '123456'
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('admin.verify-otp');
    }

    /**
     * Path 2:
     * OTP salah
     */
    public function test_wrong_otp()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'role' => 'admin',
            'otp_code' => '999999',
            'otp_expired_at' => now()->addMinutes(5),
        ]);

        $response = $this->post('/admin/verify-otp', [
            'email' => $user->email,
            'otp' => '111111'
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('admin.verify-otp');
    }

    /**
     * Path 3:
     * OTP kadaluarsa
     */
    public function test_expired_otp()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'role' => 'admin',
            'otp_code' => '123456',
            'otp_expired_at' => now()->subMinutes(10),
        ]);

        $response = $this->post('/admin/verify-otp', [
            'email' => $user->email,
            'otp' => '123456'
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('admin.verify-otp');
    }

    /**
     * Path 4:
     * OTP benar
     */
    public function test_success_otp()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'role' => 'admin',
            'otp_code' => '123456',
            'otp_expired_at' => now()->addMinutes(5),
        ]);

        $response = $this->post('/admin/verify-otp', [
            'email' => $user->email,
            'otp' => '123456'
        ]);

        $response->assertRedirect('/admin/dashboard');
    }
}