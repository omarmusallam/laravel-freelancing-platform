<x-app-layout>
    <div class="dashboard-headline">
        <h3>{{ $project->title }}</h3>
        <span>{{ ucfirst($project->status) }} project overview</span>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="dashboard-box margin-top-0">
                <div class="headline">
                    <h3><i class="icon-material-outline-description"></i> Project Details</h3>
                </div>

                <div class="content with-padding">
                    <div class="single-page-section">
                        <h4>Description</h4>
                        <p>{{ $project->desc }}</p>
                    </div>

                    <div class="single-page-section margin-top-30">
                        <h4>Tags</h4>
                        @if ($project->tags->isNotEmpty())
                            <div class="task-tags">
                                @foreach ($project->tags as $tag)
                                    <span>{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <p>No tags added yet.</p>
                        @endif
                    </div>

                    @if (!empty($project->attachments))
                        <div class="single-page-section margin-top-30">
                            <h4>Attachments</h4>
                            <ul class="list-2">
                                @foreach ($project->attachments as $file)
                                    <li><a href="{{ asset('uploads/' . $file) }}" target="_blank" rel="noopener">{{ basename($file) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="sidebar-container">
                <div class="sidebar-widget">
                    <div class="job-overview">
                        <div class="job-overview-headline">Project Summary</div>
                        <div class="job-overview-inner">
                            <ul>
                                <li>
                                    <i class="icon-material-outline-business-center"></i>
                                    <span>Type</span>
                                    <h5>{{ $project->type_name }}</h5>
                                </li>
                                <li>
                                    <i class="icon-material-outline-local-atm"></i>
                                    <span>Budget</span>
                                    <h5>${{ number_format($project->budget ?? 0, 0) }}</h5>
                                </li>
                                <li>
                                    <i class="icon-material-outline-account-tree"></i>
                                    <span>Category</span>
                                    <h5>{{ $project->category->parent->name ?? $project->category->name }}</h5>
                                </li>
                                <li>
                                    <i class="icon-material-outline-access-time"></i>
                                    <span>Created</span>
                                    <h5>{{ $project->created_at->diffForHumans() }}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="sidebar-widget">
                    <a href="{{ route('projects.show', $project) }}" class="button full-width ripple-effect margin-bottom-12">View Public Page</a>
                    <a href="{{ route('client.projects.edit', $project) }}" class="button gray full-width ripple-effect">Edit Project</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
