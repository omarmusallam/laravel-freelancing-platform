<x-app-layout>
    <x-flash-message />
    @if ($errors->any())
        <div class="notification error closeable">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        .freelancer-profile-shell {
            display: grid;
            gap: 24px;
        }

        .freelancer-profile-hero {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 18px;
            padding: 28px;
            border-radius: 28px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 70%, #0f766e 100%);
            color: #fff;
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.18);
        }

        .freelancer-profile-hero h1 {
            margin: 0 0 10px;
            color: #fff;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .freelancer-profile-hero p {
            margin: 0;
            max-width: 760px;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.85;
        }

        .freelancer-profile-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 24px;
            align-items: start;
        }

        .freelancer-profile-box {
            border-radius: 28px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.07);
            overflow: hidden;
        }

        .freelancer-profile-head {
            padding: 22px 24px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
        }

        .freelancer-profile-head h2 {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 1.4rem;
        }

        .freelancer-profile-head p {
            margin: 0;
            color: #64748b;
        }

        .freelancer-profile-content {
            padding: 24px;
        }

        .freelancer-profile-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .freelancer-field {
            display: grid;
            gap: 8px;
        }

        .freelancer-field.is-full {
            grid-column: 1 / -1;
        }

        .freelancer-field h5 {
            margin: 0;
            color: #334155;
            font-size: 0.92rem;
            font-weight: 700;
        }

        .freelancer-field .with-border,
        .freelancer-field textarea,
        .freelancer-field .bootstrap-select>.dropdown-toggle,
        .freelancer-field .bidding-widget {
            border-radius: 16px;
        }

        .freelancer-field .with-border,
        .freelancer-field .bootstrap-select>.dropdown-toggle {
            height: 52px;
            border: 1px solid rgba(148, 163, 184, 0.22);
            box-shadow: none;
        }

        .freelancer-field textarea {
            border: 1px solid rgba(148, 163, 184, 0.22);
            box-shadow: none;
        }

        .freelancer-avatar-card {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 18px;
            border-radius: 22px;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .freelancer-avatar-card img {
            width: 88px;
            height: 88px;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.12);
        }

        .freelancer-avatar-card strong {
            display: block;
            color: #0f172a;
            font-size: 1.1rem;
            margin-bottom: 6px;
        }

        .freelancer-avatar-card span {
            color: #64748b;
            line-height: 1.7;
        }

        .freelancer-upload-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 18px;
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.05);
            color: #0f172a;
            font-weight: 700;
            cursor: pointer;
            margin-top: 12px;
        }

        .freelancer-upload-label input {
            display: none;
        }

        .freelancer-save-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .freelancer-save-row .button,
        .freelancer-save-row .button.gray {
            min-height: 50px;
            border-radius: 16px;
            padding: 0 22px;
        }

        .freelancer-profile-side {
            position: sticky;
            top: 104px;
            display: grid;
            gap: 20px;
        }

        .freelancer-side-card {
            padding: 24px;
        }

        .freelancer-side-card h3 {
            margin: 0 0 12px;
            color: #0f172a;
            font-size: 1.25rem;
        }

        .freelancer-side-card p {
            margin: 0 0 16px;
            color: #64748b;
            line-height: 1.8;
        }

        .freelancer-side-list {
            display: grid;
            gap: 12px;
        }

        .freelancer-side-item {
            padding: 14px 16px;
            border-radius: 18px;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .freelancer-side-item span {
            display: block;
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .freelancer-side-item strong {
            color: #0f172a;
            font-size: 1rem;
        }

        @media (max-width: 1199px) {
            .freelancer-profile-layout {
                grid-template-columns: 1fr;
            }

            .freelancer-profile-side {
                position: static;
            }
        }

        @media (max-width: 767px) {
            .freelancer-profile-grid {
                grid-template-columns: 1fr;
            }

            .freelancer-profile-hero {
                align-items: start;
            }
        }
    </style>

    <form action="{{ route('freelancer.profile.edit') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="freelancer-profile-shell">
            <section class="freelancer-profile-hero">
                <div>
                    <h1>Freelancer Profile Workspace</h1>
                    <p>Manage how clients see you across the marketplace: your name, positioning, rate, location, biography, and profile image.</p>
                </div>
            </section>

            <div class="freelancer-profile-layout">
                <div class="freelancer-profile-box">
                    <div class="freelancer-profile-head">
                        <h2>Profile Identity</h2>
                        <p>Keep your core information accurate and clear so your profile feels professional to clients.</p>
                    </div>

                    <div class="freelancer-profile-content">
                        <div class="freelancer-avatar-card">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <span>{{ $profile->title ?: 'Freelancer profile not fully positioned yet.' }}</span>
                                <label class="freelancer-upload-label">
                                    Change profile photo
                                    <input name="profile_photo" type="file" accept="image/*">
                                </label>
                            </div>
                        </div>

                        <div class="freelancer-profile-grid" style="margin-top: 20px;">
                            <div class="freelancer-field">
                                <h5>First Name</h5>
                                <input type="text" class="with-border" name="first_name" value="{{ $profile->first_name }}">
                            </div>

                            <div class="freelancer-field">
                                <h5>Last Name</h5>
                                <input type="text" class="with-border" name="last_name" value="{{ $profile->last_name }}">
                            </div>

                            <div class="freelancer-field">
                                <h5>Email</h5>
                                <input type="text" class="with-border" value="{{ $user->email }}" readonly>
                            </div>

                            <div class="freelancer-field">
                                <h5>Tagline</h5>
                                <input type="text" class="with-border" name="title" value="{{ $profile->title }}">
                            </div>

                            <div class="freelancer-field">
                                <h5>Country</h5>
                                <x-country-select :selected="$profile->country" />
                            </div>

                            <div class="freelancer-field">
                                <h5>Minimal Hourly Rate</h5>
                                <div class="bidding-widget">
                                    <span class="bidding-detail">Set your <strong>minimal hourly rate</strong></span>
                                    <div class="bidding-value margin-bottom-10">$<span id="biddingVal"></span></div>
                                    <input class="bidding-slider" type="text" name="hourly_rate" value="{{ $profile->hourly_rate }}" data-slider-handle="custom" data-slider-currency="$" data-slider-min="5" data-slider-max="150" data-slider-value="{{ $profile->hourly_rate }}" data-slider-step="1" data-slider-tooltip="hide" />
                                </div>
                            </div>

                            <div class="freelancer-field is-full">
                                <h5>Introduce Yourself</h5>
                                <textarea cols="30" rows="7" class="with-border" name="desc">{{ $profile->desc }}</textarea>
                            </div>
                        </div>

                        <div class="freelancer-save-row">
                            <button type="submit" class="button ripple-effect" style="background:linear-gradient(135deg,#f97316,#2563eb);">
                                Save Profile Changes
                            </button>
                            <a href="{{ route('freelancer.contracts.index') }}" class="button gray ripple-effect">Delivery Workspace</a>
                            <a href="{{ route('freelancer.proposals.index') }}" class="button gray ripple-effect">Back to Proposals</a>
                        </div>
                    </div>
                </div>

                <aside class="freelancer-profile-side">
                    <div class="freelancer-profile-box freelancer-side-card">
                        <h3>Positioning Tips</h3>
                        <p>A stronger freelancer profile usually has a clear role, realistic rate, and a short summary that explains how you work and what outcomes you deliver.</p>

                        <div class="freelancer-side-list">
                            <div class="freelancer-side-item">
                                <span>Tagline</span>
                                <strong>Describe what you do in one clear line.</strong>
                            </div>
                            <div class="freelancer-side-item">
                                <span>Rate</span>
                                <strong>Set a rate that matches your market and specialization.</strong>
                            </div>
                            <div class="freelancer-side-item">
                                <span>Summary</span>
                                <strong>Explain strengths, communication style, and delivery quality.</strong>
                            </div>
                        </div>
                    </div>

                    <div class="freelancer-profile-box freelancer-side-card">
                        <h3>Current Snapshot</h3>
                        <div class="freelancer-side-list">
                            <div class="freelancer-side-item">
                                <span>Name</span>
                                <strong>{{ $user->name }}</strong>
                            </div>
                            <div class="freelancer-side-item">
                                <span>Tagline</span>
                                <strong>{{ $profile->title ?: 'Not set yet' }}</strong>
                            </div>
                            <div class="freelancer-side-item">
                                <span>Hourly Rate</span>
                                <strong>{{ $profile->hourly_rate ? '$' . number_format((float) $profile->hourly_rate, 0) . '/hr' : 'Not set yet' }}</strong>
                            </div>
                            <div class="freelancer-side-item">
                                <span>Country</span>
                                <strong>{{ $profile->country ?: 'Not set yet' }}</strong>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </form>
</x-app-layout>
