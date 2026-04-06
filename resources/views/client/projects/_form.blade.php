@php
    $isEdit = ($pageMode ?? 'create') === 'edit';
    $heading = $isEdit ? 'Edit Client Project' : 'Create New Client Project';
    $subheading = $isEdit
        ? 'Refine the public brief, budget, category, and supporting assets for this project.'
        : 'Publish a structured project brief with the information freelancers need to send strong proposals.';
    $submitLabel = $isEdit ? 'Save Project Changes' : 'Publish Project';
@endphp

<style>
    .client-form-shell {
        display: grid;
        gap: 24px;
    }

    .client-form-hero {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 18px;
        padding: 28px;
        border-radius: 28px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 70%, #2563eb 100%);
        color: #fff;
        box-shadow: 0 28px 60px rgba(15, 23, 42, 0.18);
    }

    .client-form-hero h1 {
        margin: 0 0 10px;
        color: #fff;
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 1;
        letter-spacing: -0.04em;
    }

    .client-form-hero p {
        margin: 0;
        max-width: 760px;
        color: rgba(255, 255, 255, 0.78);
        line-height: 1.85;
    }

    .client-form-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 24px;
        align-items: start;
    }

    .client-form-box {
        border-radius: 28px;
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.07);
        overflow: hidden;
    }

    .client-form-head {
        padding: 22px 24px;
        border-bottom: 1px solid rgba(226, 232, 240, 0.9);
    }

    .client-form-head h2 {
        margin: 0 0 6px;
        color: #0f172a;
        font-size: 1.4rem;
    }

    .client-form-head p {
        margin: 0;
        color: #64748b;
    }

    .client-form-content {
        padding: 24px;
    }

    .client-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .client-field {
        display: grid;
        gap: 8px;
    }

    .client-field.is-full {
        grid-column: 1 / -1;
    }

    .client-field h5 {
        margin: 0;
        color: #334155;
        font-size: 0.92rem;
        font-weight: 700;
    }

    .client-field .with-border,
    .client-field .bootstrap-select>.dropdown-toggle,
    .client-field textarea {
        border-radius: 16px;
        border: 1px solid rgba(148, 163, 184, 0.22);
        box-shadow: none;
    }

    .client-field .with-border,
    .client-field .bootstrap-select>.dropdown-toggle {
        height: 52px;
    }

    .client-upload-wrap {
        margin-top: 10px;
        padding: 16px;
        border-radius: 18px;
        background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
        border: 1px dashed rgba(148, 163, 184, 0.26);
    }

    .client-upload-list {
        margin-top: 14px;
        display: grid;
        gap: 8px;
    }

    .client-upload-list a {
        color: #2563eb;
        font-weight: 600;
    }

    .client-form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .client-form-actions .button,
    .client-form-actions .button.gray {
        min-height: 50px;
        border-radius: 16px;
        padding: 0 22px;
    }

    .client-form-side {
        position: sticky;
        top: 104px;
        display: grid;
        gap: 20px;
    }

    .client-side-card {
        padding: 24px;
    }

    .client-side-card h3 {
        margin: 0 0 12px;
        color: #0f172a;
        font-size: 1.25rem;
    }

    .client-side-card p {
        margin: 0 0 16px;
        color: #64748b;
        line-height: 1.8;
    }

    .client-side-list {
        display: grid;
        gap: 12px;
    }

    .client-side-item {
        padding: 14px 16px;
        border-radius: 18px;
        background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
        border: 1px solid rgba(148, 163, 184, 0.14);
    }

    .client-side-item span {
        display: block;
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 0.74rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .client-side-item strong {
        color: #0f172a;
        font-size: 1rem;
    }

    @media (max-width: 1199px) {
        .client-form-layout {
            grid-template-columns: 1fr;
        }

        .client-form-side {
            position: static;
        }
    }

    @media (max-width: 767px) {
        .client-form-grid {
            grid-template-columns: 1fr;
        }

        .client-form-hero {
            align-items: start;
        }
    }
</style>

<div class="client-form-shell">
    <section class="client-form-hero">
        <div>
            <h1>{{ $heading }}</h1>
            <p>{{ $subheading }}</p>
        </div>
    </section>

    <div class="client-form-layout">
        <section class="client-form-box">
            <div class="client-form-head">
                <h2>Project Brief</h2>
                <p>Complete the key details below to make the project easier to understand and easier to respond to.</p>
            </div>

            <div class="client-form-content">
                <div class="client-form-grid">
                    <div class="client-field">
                        <h5>Project Title</h5>
                        <x-form.input name="title" id="title" class="with-border" :value="$project->title" />
                    </div>

                    <div class="client-field">
                        <h5>Project Type</h5>
                        <x-form.select name="type" id="type" :options="$types" :selected="$project->type" class="selectpicker with-border" data-size="7" title="Select Project Type" />
                    </div>

                    <div class="client-field">
                        <h5>Category</h5>
                        <x-form.select name="category_id" id="category_id" :options="$categories" :selected="$project->category_id" class="selectpicker with-border" data-size="7" title="Select Category" />
                    </div>

                    <div class="client-field">
                        <h5>Budget</h5>
                        <x-form.input name="budget" id="budget" :value="$project->budget" class="with-border" type="text" placeholder="Budget in USD" />
                    </div>

                    <div class="client-field is-full">
                        <h5>Tags</h5>
                        <x-form.input name="tags" id="tags" :value="implode(', ', $tags)" type="text" class="with-border" placeholder="e.g. laravel, dashboard, api, mobile" />
                    </div>

                    <div class="client-field is-full">
                        <h5>Project Description</h5>
                        <x-form.textarea name="desc" id="desc" :value="$project->desc" cols="30" rows="8" class="with-border" />

                        <div class="client-upload-wrap">
                            <div class="uploadButton">
                                <input class="uploadButton-input" type="file" name="attachments[]" accept="image/*, application/pdf" id="upload" multiple>
                                <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                <span class="uploadButton-file-name">Upload images or documents that support the brief.</span>
                            </div>

                            @if (is_array($project->attachments) && count($project->attachments))
                                <div class="client-upload-list">
                                    @foreach ($project->attachments as $file)
                                        <a href="{{ asset('uploads/' . $file) }}" target="_blank" rel="noopener">{{ basename($file) }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="client-form-actions">
                    <button type="submit" class="button ripple-effect" style="background:linear-gradient(135deg,#f97316,#2563eb);">
                        <i class="icon-feather-save"></i> {{ $submitLabel }}
                    </button>
                    <a href="{{ route('client.projects.index') }}" class="button gray ripple-effect">Back to Projects</a>
                </div>
            </div>
        </section>

        <aside class="client-form-side">
            <div class="client-form-box client-side-card">
                <h3>Publishing Guide</h3>
                <p>A stronger project brief usually gets stronger proposals. Keep the scope specific, the budget realistic, and the category aligned with the actual work.</p>

                <div class="client-side-list">
                    <div class="client-side-item">
                        <span>Title</span>
                        <strong>Use a clear, outcome-based title.</strong>
                    </div>
                    <div class="client-side-item">
                        <span>Description</span>
                        <strong>Explain scope, deliverables, and expectations.</strong>
                    </div>
                    <div class="client-side-item">
                        <span>Tags</span>
                        <strong>Add keywords freelancers will actually search for.</strong>
                    </div>
                    <div class="client-side-item">
                        <span>Files</span>
                        <strong>Attach references, wireframes, or briefs when useful.</strong>
                    </div>
                </div>
            </div>

            <div class="client-form-box client-side-card">
                <h3>Current Snapshot</h3>
                <div class="client-side-list">
                    <div class="client-side-item">
                        <span>Mode</span>
                        <strong>{{ $isEdit ? 'Editing existing project' : 'Creating new project' }}</strong>
                    </div>
                    <div class="client-side-item">
                        <span>Type</span>
                        <strong>{{ $project->type_name ?? 'Not selected yet' }}</strong>
                    </div>
                    <div class="client-side-item">
                        <span>Budget</span>
                        <strong>{{ $project->budget ? '$' . number_format((float) $project->budget, 0) : 'Not set yet' }}</strong>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
