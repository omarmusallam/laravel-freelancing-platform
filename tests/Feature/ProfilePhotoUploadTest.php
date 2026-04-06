<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilePhotoUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_freelancer_can_save_profile_photo_path()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $freelancerRole = Role::create([
            'name' => 'freelancer',
            'abilities' => ['profile.update'],
        ]);
        $user->roles()->attach($freelancerRole);
        $user->freelancer()->create([
            'first_name' => 'Omar',
            'last_name' => 'Dev',
        ]);

        $this->actingAs($user)
            ->put('/freelancer/profile', [
                'first_name' => 'Omar',
                'last_name' => 'Dev',
                'title' => 'Backend Developer',
                'country' => 'PS',
                'hourly_rate' => 25,
                'desc' => 'Profile test',
                'profile_photo' => UploadedFile::fake()->image('avatar.png', 300, 300),
            ])
            ->assertRedirect(route('freelancer.profile.edit'));

        $user->refresh();

        $this->assertNotNull($user->freelancer->profile_photo_path);
        Storage::disk('public')->assertExists($user->freelancer->profile_photo_path);
    }
}
