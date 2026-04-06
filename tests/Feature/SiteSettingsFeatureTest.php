<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiteSettingsFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_site_settings_and_frontend_uses_them()
    {
        Storage::fake('public');

        $admin = Admin::factory()->create([
            'super_admin' => true,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.settings.edit'))
            ->assertOk()
            ->assertSee('Global Site Control');

        $this->actingAs($admin, 'admin')
            ->put(route('dashboard.settings.update'), [
                'site_name' => 'Elancer Pro',
                'site_tagline' => 'Launch premium freelance operations.',
                'contact_email' => 'hello@elancer.test',
                'support_email' => 'support@elancer.test',
                'contact_phone' => '+970599000111',
                'contact_whatsapp' => '+970599000222',
                'contact_address' => 'Gaza, Palestine',
                'meta_title' => 'Elancer Pro Marketplace',
                'meta_description' => 'Professional freelance marketplace for clients, talent, and operations teams.',
                'meta_keywords' => 'elancer, freelance, projects, remote work',
                'copyright_text' => 'Built for world-class freelance operations.',
                'facebook_url' => 'https://facebook.com/elancerpro',
                'twitter_url' => 'https://twitter.com/elancerpro',
                'linkedin_url' => 'https://linkedin.com/company/elancerpro',
                'instagram_url' => 'https://instagram.com/elancerpro',
                'logo' => UploadedFile::fake()->image('logo.png'),
                'footer_logo' => UploadedFile::fake()->image('footer-logo.png'),
                'favicon' => UploadedFile::fake()->image('favicon.png', 32, 32),
                'og_image' => UploadedFile::fake()->image('og-image.png', 1200, 630),
            ])
            ->assertRedirect(route('dashboard.settings.edit'));

        $settings = SiteSetting::current();

        $this->assertSame('Elancer Pro', $settings->site_name);
        $this->assertSame('hello@elancer.test', $settings->contact_email);
        $this->assertSame('Elancer Pro Marketplace', $settings->meta_title);
        $this->assertNotNull($settings->logo_path);
        $this->assertNotNull($settings->favicon_path);

        Storage::disk('public')->assertExists($settings->logo_path);
        Storage::disk('public')->assertExists($settings->footer_logo_path);
        Storage::disk('public')->assertExists($settings->favicon_path);
        Storage::disk('public')->assertExists($settings->og_image_path);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Elancer Pro Marketplace', false)
            ->assertSee('Professional freelance marketplace for clients, talent, and operations teams.', false)
            ->assertSee('hello@elancer.test')
            ->assertSee('+970599000111');
    }
}
