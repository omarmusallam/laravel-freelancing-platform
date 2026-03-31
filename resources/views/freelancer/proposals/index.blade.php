<x-app-layout>
    <!-- Row -->
    <div class="row">

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-business-center"></i> My Proposals</h3>
                </div>

                <div class="content">
                    <ul class="dashboard-box-list">
                        @foreach ($proposals as $proposal)
                        <li>
                            <!-- Job Listing -->
                            <div class="job-listing">

                                <!-- Job Listing Details -->
                                <div class="job-listing-details">

                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title"><a href="{{ route('projects.show', $proposal->project) }}">{{ $proposal->project->title }}</a> <span class="dashboard-status-button yellow">{{ $proposal->status }}</span></h3>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-date-range"></i> Posted on {{ $proposal->created_at }}</li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="buttons-to-right always-visible">
                                    <a href="{{ route('projects.show', $proposal->project) }}" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> View Project</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- Row / End -->
</x-app-layout>
