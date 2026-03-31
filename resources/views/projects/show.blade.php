<x-front-layout :title="$project->title">

    <!-- Titlebar
================================================== -->
    <div class="single-page-header" data-background-image="images/single-job.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image"><a href="{{ route('projects.browse', ['category' => $project->category_id]) }}"><img src="{{ asset('assets/front/images/company-logo-03a.png') }}" alt=""></a></div>
                            <div class="header-details">
                                <h3>{{ $project->title }}</h3>
                                <h5>{{ $project->user->name }}</h5>
                                <ul>
                                    <li><a href="{{ route('projects.browse', ['category' => $project->category_id]) }}"><i class="icon-material-outline-business"></i> {{ $project->category->parent->name ?? $project->category->name }}</a></li>
                                    <li>
                                        <div class="star-rating" data-rating="4.9"></div>
                                    </li>
                                    <li><img class="flag" src="{{ asset('assets/front/images/flags/ps.svg') }}" alt=""> Remote</li>
                                    <li>
                                        <div class="verified-badge-with-title">{{ ucfirst($project->status) }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-side">
                            <div class="salary-box">
                                <div class="salary-type">Budget</div>
                                <div class="salary-amount">{{ $project->budget }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Page Content
================================================== -->
    <div class="container">
        <div class="row">

            <!-- Content -->
            <div class="col-xl-8 col-lg-8 content-right-offset">

                <div class="single-page-section">
                    <h3 class="margin-bottom-25">Job Description</h3>
                    <p>{{ $project->desc }}</p>
                </div>

                <div class="single-page-section">
                    <h3 class="margin-bottom-30">Location</h3>
                    <div id="single-job-map-container">
                        <div id="singleListingMap" data-latitude="51.507717" data-longitude="-0.131095" data-map-icon="im im-icon-Hamburger"></div>
                        <a href="{{ route('projects.browse') }}" id="streetView">Browse More Projects</a>
                    </div>
                </div>

                <div class="single-page-section">
                    <h3 class="margin-bottom-25">Similar Jobs</h3>

                    <!-- Listings Container -->
                    <div class="listings-container grid-layout">

                        @forelse ($similarProjects as $similarProject)
                            <a href="{{ route('projects.show', $similarProject) }}" class="job-listing">
                                <div class="job-listing-details">
                                    <div class="job-listing-company-logo">
                                        <img src="{{ asset('assets/front/images/company-logo-02.png') }}" alt="">
                                    </div>

                                    <div class="job-listing-description">
                                        <h4 class="job-listing-company">{{ $similarProject->user->name }}</h4>
                                        <h3 class="job-listing-title">{{ $similarProject->title }}</h3>
                                    </div>
                                </div>

                                <div class="job-listing-footer">
                                    <ul>
                                        <li><i class="icon-material-outline-location-on"></i> {{ $similarProject->category->name }}</li>
                                        <li><i class="icon-material-outline-business-center"></i> {{ ucfirst($similarProject->type) }}</li>
                                        <li><i class="icon-material-outline-account-balance-wallet"></i> ${{ number_format($similarProject->budget, 0) }}</li>
                                        <li><i class="icon-material-outline-access-time"></i> {{ $similarProject->created_at->diffForHumans() }}</li>
                                    </ul>
                                </div>
                            </a>
                        @empty
                            <div class="notification notice closeable">
                                <p>No similar projects available right now.</p>
                            </div>
                        @endforelse
                    </div>
                    <!-- Listings Container / End -->

                </div>
            </div>


            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">

                    @auth
                        <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim">Apply Now <i class="icon-material-outline-arrow-right-alt"></i></a>
                    @else
                        <a href="{{ route('login') }}" class="apply-now-button">Login to Apply <i class="icon-material-outline-arrow-right-alt"></i></a>
                    @endauth

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <div class="job-overview">
                            <div class="job-overview-headline">Job Summary</div>
                            <div class="job-overview-inner">
                                <ul>
                                    <li>
                                        <i class="icon-material-outline-location-on"></i>
                                        <span>Location</span>
                                        <h5>Remote / Online</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-business-center"></i>
                                        <span>Job Type</span>
                                        <h5>{{ $project->type }}</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-local-atm"></i>
                                        <span>Budget</span>
                                        <h5>{{ $project->budget }}</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-access-time"></i>
                                        <span>Date Posted</span>
                                        <h5>{{ $project->created_at->diffForHumans() }}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <h3>Bookmark or Share</h3>

                        <!-- Bookmark Button -->
                        <button class="bookmark-button margin-bottom-25">
                            <span class="bookmark-icon"></span>
                            <span class="bookmark-text">Bookmark</span>
                            <span class="bookmarked-text">Bookmarked</span>
                        </button>

                        <!-- Copy URL -->
                        <div class="copy-url">
                            <input id="copy-url" type="text" value="{{ $shareUrl }}" class="with-border">
                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Copy to Clipboard" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons margin-top-25">
                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                            <div class="share-buttons-content">
                                <span>Interesting? <strong>Share It!</strong></span>
                                <ul class="share-buttons-icons">
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top" target="_blank" rel="noopener"><i class="icon-brand-facebook-f"></i></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($project->title) }}" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top" target="_blank" rel="noopener"><i class="icon-brand-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top" target="_blank" rel="noopener"><i class="icon-brand-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Apply for a job popup
================================================== -->
    @auth
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a href="#tab">Apply Now</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>Attach File With CV</h3>
                    </div>

                    <!-- Form -->
                    <form method="post" action="{{ route('freelancer.proposals.store', $project->id) }}" id="apply-now-form">
                        @csrf
                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-account-circle"></i>
                            <x-form.textarea class="input-text with-border" name="description" id="description" placeholder="Proposal summary" required="required" />
                        </div>

                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <x-form.input type="number" class="input-text with-border" name="cost" id="cost" placeholder="Cost" required="required" />
                        </div>

                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <x-form.input type="number" class="input-text with-border" name="duration" id="duration" placeholder="Duration" required="required" />
                            <x-form.select class="input-text with-border" name="duration_unit" id="duration_unit" required="required" :options="$units" />
                        </div>


                    </form>

                    <!-- Button -->
                    <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit" form="apply-now-form">Apply Now <i class="icon-material-outline-arrow-right-alt"></i></button>

                </div>

            </div>
        </div>
    </div>
    <!-- Apply for a job popup / End -->
    @endauth
</x-front-layout>
