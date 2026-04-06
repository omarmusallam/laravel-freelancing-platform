<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_tagline',
        'contact_email',
        'support_email',
        'contact_phone',
        'contact_whatsapp',
        'contact_address',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'copyright_text',
        'logo_path',
        'footer_logo_path',
        'favicon_path',
        'og_image_path',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
    ];

    public static function current(): self
    {
        return Cache::rememberForever('site_settings.current', function () {
            return static::query()->firstOrCreate(
                ['id' => 1],
                static::defaults()
            );
        });
    }

    public static function defaults(): array
    {
        return [
            'site_name' => config('app.name', 'Elancer'),
            'site_tagline' => 'Professional freelance marketplace',
            'contact_email' => config('mail.from.address', 'info@example.com'),
            'support_email' => config('mail.from.address', 'support@example.com'),
            'contact_phone' => '+970000000000',
            'contact_whatsapp' => '+970000000000',
            'contact_address' => 'Palestine',
            'meta_title' => config('app.name', 'Elancer'),
            'meta_description' => 'A professional freelance marketplace for clients and freelancers.',
            'meta_keywords' => 'freelance, jobs, projects, proposals, marketplace',
            'copyright_text' => 'All Rights Reserved.',
            'logo_path' => null,
            'footer_logo_path' => null,
            'favicon_path' => null,
            'og_image_path' => null,
            'facebook_url' => null,
            'twitter_url' => null,
            'linkedin_url' => null,
            'instagram_url' => null,
        ];
    }

    public static function clearCached(): void
    {
        Cache::forget('site_settings.current');
    }

    public function logoUrl(): string
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : asset('assets/front/images/logo.png');
    }

    public function footerLogoUrl(): string
    {
        return $this->footer_logo_path ? asset('storage/' . $this->footer_logo_path) : asset('assets/front/images/logo2.png');
    }

    public function faviconUrl(): ?string
    {
        return $this->favicon_path ? asset('storage/' . $this->favicon_path) : null;
    }

    public function ogImageUrl(): ?string
    {
        return $this->og_image_path ? asset('storage/' . $this->og_image_path) : null;
    }
}
