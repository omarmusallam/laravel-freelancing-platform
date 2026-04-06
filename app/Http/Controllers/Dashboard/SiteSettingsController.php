<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    public function edit()
    {
        return view('dashboard.settings.edit', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::current();

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_whatsapp' => ['nullable', 'string', 'max:255'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'copyright_text' => ['nullable', 'string', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'footer_logo' => ['nullable', 'image', 'max:4096'],
            'favicon' => ['nullable', 'image', 'max:2048'],
            'og_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $payload = collect($data)->except(['logo', 'footer_logo', 'favicon', 'og_image'])->all();

        $uploads = [
            'logo' => 'logo_path',
            'footer_logo' => 'footer_logo_path',
            'favicon' => 'favicon_path',
            'og_image' => 'og_image_path',
        ];

        foreach ($uploads as $requestKey => $column) {
            if ($request->hasFile($requestKey)) {
                if ($settings->{$column}) {
                    Storage::disk('public')->delete($settings->{$column});
                }

                $payload[$column] = $request->file($requestKey)->store('site-settings', 'public');
            }
        }

        $settings->update($payload);
        SiteSetting::clearCached();

        return redirect()
            ->route('dashboard.settings.edit')
            ->with('success', 'Site settings updated successfully.');
    }
}
