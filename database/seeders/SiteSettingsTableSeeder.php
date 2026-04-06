<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{
    public function run()
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Elancer Pro',
                'site_tagline' => 'Professional freelance marketplace for serious clients and top talent.',
                'contact_email' => 'hello@elancer.test',
                'support_email' => 'support@elancer.test',
                'contact_phone' => '+970599000111',
                'contact_whatsapp' => '+970599000222',
                'contact_address' => 'Gaza, Palestine',
                'meta_title' => 'Elancer Pro Marketplace',
                'meta_description' => 'Elancer Pro is a polished freelance marketplace demo with realistic projects, proposals, contracts, messaging, payments, and admin operations.',
                'meta_keywords' => 'freelance marketplace, remote projects, proposals, contracts, admin dashboard, elancer',
                'copyright_text' => 'Built for world-class freelance operations.',
                'facebook_url' => 'https://facebook.com/elancerpro',
                'twitter_url' => 'https://twitter.com/elancerpro',
                'linkedin_url' => 'https://linkedin.com/company/elancerpro',
                'instagram_url' => 'https://instagram.com/elancerpro',
            ]
        );

        SiteSetting::clearCached();
    }
}
