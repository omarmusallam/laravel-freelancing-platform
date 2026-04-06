@extends('layouts.dashboard')

@section('title', 'Site Settings')

@section('content')
    <x-flash-message />

    <div class="card mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">Global Site Control</h5>
                <p class="text-muted mb-0">Manage the platform identity, contact channels, SEO metadata, and visual assets from one place.</p>
            </div>
            <div class="admin-shell-chip mt-2 mt-lg-0">
                <i class="fas fa-sliders-h"></i>
                <span>Unified Configuration</span>
            </div>
        </div>
    </div>

    <form action="{{ route('dashboard.settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Brand Identity</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="site_name">Site name</label>
                                <input type="text" class="form-control" id="site_name" name="site_name" value="{{ old('site_name', $settings->site_name) }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="site_tagline">Tagline</label>
                                <input type="text" class="form-control" id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $settings->site_tagline) }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="logo">Primary logo</label>
                                <input type="file" class="form-control-file" id="logo" name="logo" accept="image/*">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="footer_logo">Footer logo</label>
                                <input type="file" class="form-control-file" id="footer_logo" name="footer_logo" accept="image/*">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="favicon">Favicon / tab icon</label>
                                <input type="file" class="form-control-file" id="favicon" name="favicon" accept="image/*">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="og_image">Social share image</label>
                                <input type="file" class="form-control-file" id="og_image" name="og_image" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Contact & Business Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="contact_email">Public email</label>
                                <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="support_email">Support email</label>
                                <input type="email" class="form-control" id="support_email" name="support_email" value="{{ old('support_email', $settings->support_email) }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="contact_phone">Phone</label>
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="contact_whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="contact_whatsapp" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings->contact_whatsapp) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="contact_address">Address</label>
                                <input type="text" class="form-control" id="contact_address" name="contact_address" value="{{ old('contact_address', $settings->contact_address) }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="facebook_url">Facebook URL</label>
                                <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="twitter_url">Twitter URL</label>
                                <input type="url" class="form-control" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="linkedin_url">LinkedIn URL</label>
                                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="instagram_url">Instagram URL</label>
                                <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">SEO & Metadata</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="meta_title">Meta title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $settings->meta_title) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="4" required>{{ old('meta_description', $settings->meta_description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="meta_keywords">Meta keywords / tags</label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3">{{ old('meta_keywords', $settings->meta_keywords) }}</textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label for="copyright_text">Footer copyright text</label>
                            <input type="text" class="form-control" id="copyright_text" name="copyright_text" value="{{ old('copyright_text', $settings->copyright_text) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Current Assets</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Primary logo</strong></p>
                        <img src="{{ $siteSettings->logoUrl() }}" alt="Primary logo" class="img-fluid mb-3" style="max-height: 70px;">
                        <p><strong>Footer logo</strong></p>
                        <img src="{{ $siteSettings->footerLogoUrl() }}" alt="Footer logo" class="img-fluid mb-3" style="max-height: 70px;">
                        <p><strong>Favicon</strong></p>
                        @if ($siteSettings->faviconUrl())
                            <img src="{{ $siteSettings->faviconUrl() }}" alt="Favicon" class="img-fluid mb-3" style="max-height: 48px;">
                        @else
                            <p class="text-muted">No custom favicon uploaded yet.</p>
                        @endif
                        <p><strong>OG image</strong></p>
                        @if ($siteSettings->ogImageUrl())
                            <img src="{{ $siteSettings->ogImageUrl() }}" alt="OG image" class="img-fluid rounded">
                        @else
                            <p class="text-muted mb-0">No social share image uploaded yet.</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Publishing Notes</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Site title:</strong> {{ $settings->site_name }}</p>
                        <p class="mb-2"><strong>Contact:</strong> {{ $settings->contact_email }}</p>
                        <p class="mb-2"><strong>Phone:</strong> {{ $settings->contact_phone ?: 'Not set' }}</p>
                        <p class="mb-3"><strong>Meta title:</strong> {{ $settings->meta_title }}</p>
                        <button class="btn btn-primary btn-block">Save Settings</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
