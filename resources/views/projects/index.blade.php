<x-front-layout title="Browse Projects">
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Browse Projects</h2>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Projects</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container margin-top-30 margin-bottom-60">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="sidebar-container">
                    <form method="GET" action="{{ route('projects.browse') }}" class="sidebar-widget">
                        <h3>Filter Projects</h3>

                        <div class="submit-field">
                            <h5>Keyword</h5>
                            <input type="text" class="with-border" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search projects">
                        </div>

                        <div class="submit-field">
                            <h5>Category</h5>
                            <select name="category" class="selectpicker with-border" data-size="7" title="All Categories">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(($filters['category'] ?? null) == $category->id)>{{ $category->parent_id ? $category->parent->name . ' / ' . $category->name : $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="submit-field">
                            <h5>Project Type</h5>
                            <select name="type" class="selectpicker with-border" data-size="7" title="All Types">
                                <option value="">All Types</option>
                                @foreach ($types as $typeValue => $typeLabel)
                                    <option value="{{ $typeValue }}" @selected(($filters['type'] ?? null) === $typeValue)>{{ $typeLabel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="submit-field">
                            <h5>Budget Range</h5>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="with-border" name="budget_min" placeholder="Min" value="{{ $filters['budget_min'] ?? '' }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="with-border" name="budget_max" placeholder="Max" value="{{ $filters['budget_max'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <button class="button ripple-effect margin-top-10">Apply Filters</button>
                    </form>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8">
                <div class="section-headline margin-top-5 margin-bottom-25">
                    <h3>{{ $projects->total() }} Available Projects</h3>
                </div>

                <div class="tasks-list-container compact-list margin-top-35">
                    @forelse ($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="task-listing">
                            <div class="task-listing-details">
                                <div class="task-listing-description">
                                    <h3 class="task-listing-title">{{ $project->title }}</h3>
                                    <ul class="task-icons">
                                        <li><i class="icon-material-outline-business"></i> {{ $project->user->name }}</li>
                                        <li><i class="icon-material-outline-location-on"></i> {{ $project->category->parent->name ?? $project->category->name }}</li>
                                        <li><i class="icon-material-outline-access-time"></i> {{ $project->created_at->diffForHumans() }}</li>
                                    </ul>
                                    <p class="task-listing-text">{{ \Illuminate\Support\Str::limit($project->desc, 150) }}</p>
                                    <div class="task-tags margin-top-15">
                                        @foreach ($project->tags as $tag)
                                            <span>{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="task-listing-bid">
                                <div class="task-listing-bid-inner">
                                    <div class="task-offers">
                                        <strong>${{ number_format($project->budget, 0) }}</strong>
                                        <span>{{ ucfirst($project->type) }}</span>
                                    </div>
                                    <span class="button button-sliding-icon ripple-effect">View Project <i class="icon-material-outline-arrow-right-alt"></i></span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="notification notice closeable">
                            <p>No projects matched your filters yet.</p>
                        </div>
                    @endforelse
                </div>

                <div class="clearfix"></div>
                <div class="margin-top-40">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
