  <x-front-layout title="Home Page">
      <!-- Intro Banner
    ================================================== -->
      <div class="intro-banner dark-overlay" data-background-image="images/home-background-02.jpg">

          <!-- Transparent Header Spacer -->
          <div class="transparent-header-spacer"></div>

          <div class="container">

              <!-- Intro Headline -->
              <div class="row">
                  <div class="col-md-12">
                      <div class="banner-headline">
                          <h3>
                              <strong>Hire experts freelancers for any job, any time.</strong>
                              <br>
                              <span>Huge community of designers, developers and creatives ready for your project.</span>
                          </h3>
                      </div>
                  </div>
              </div>

              <!-- Search Bar -->
              <div class="row">
                  <div class="col-md-12">
                      <form method="GET" action="{{ route('projects.browse') }}" class="intro-banner-search-form margin-top-95">

                          <!-- Search Field -->
                          <div class="intro-search-field with-autocomplete">
                              <label for="autocomplete-input" class="field-title ripple-effect">Where?</label>
                              <div class="input-with-icon">
                                  <input id="autocomplete-input" type="text" value="Remote" disabled>
                                  <i class="icon-material-outline-location-on"></i>
                              </div>
                          </div>

                          <!-- Search Field -->
                          <div class="intro-search-field">
                              <label for="intro-keywords" class="field-title ripple-effect">What you need done?</label>
                              <input id="intro-keywords" name="q" type="text" placeholder="e.g. build me a website">
                          </div>

                          <!-- Search Field -->
                          <div class="intro-search-field">
                              <select name="category" class="selectpicker default" data-size="7" title="All Categories">
                                  <option value="">All Categories</option>
                                  @foreach ($categories as $category)
                                      <option value="{{ $category->id }}">{{ $category->parent_id ? $category->parent->name . ' / ' . $category->name : $category->name }}</option>
                                  @endforeach
                              </select>
                          </div>

                          <!-- Button -->
                          <div class="intro-search-button">
                              <button class="button ripple-effect" type="submit">Search</button>
                          </div>
                      </form>
                  </div>
              </div>

              <!-- Stats -->
              <div class="row">
                  <div class="col-md-12">
                      <ul class="intro-stats margin-top-45 hide-under-992px">
                          <li>
                              <strong>{{ $stats['projects'] }}</strong>
                              <span>Jobs Posted</span>
                          </li>
                          <li>
                              <strong>{{ $stats['open_projects'] }}</strong>
                              <span>Tasks Posted</span>
                          </li>
                          <li>
                              <strong>{{ $stats['freelancers'] }}</strong>
                              <span>Freelancers</span>
                          </li>
                      </ul>
                  </div>
              </div>

          </div>
      </div>


      <!-- Content
    ================================================== -->

      <!-- Popular Job Categories -->
      <div class="section margin-top-65 margin-bottom-30">
          <div class="container">
              <div class="row">

                  <!-- Section Headline -->
                  <div class="col-xl-12">
                      <div class="section-headline centered margin-top-0 margin-bottom-45">
                          <h3>All Categories</h3>
                      </div>
                  </div>
                  @foreach ($categories as $category)
                      <div class="col-xl-3 col-md-6">
                          <a href="{{ route('projects.browse', ['category' => $category->id]) }}" class="photo-box small" data-background-image="images/job-category-01.jpg">
                              <div class="photo-box-content">
                                  <h3>{{ $category->name }}</h3>
                                  <span>{{ $category->parent_id ? $category->parent->name : 'Main Category' }} • {{ $category->projects_count }} projects</span>
                              </div>
                          </a>
                      </div>
                  @endforeach
              </div>
          </div>
      </div>
      <!-- Features Cities / End -->



      <!-- Features Jobs -->
      <div class="section gray margin-top-45 padding-top-65 padding-bottom-75">
          <div class="container">
              <div class="row">
                  <div class="col-xl-12">

                      <!-- Section Headline -->
                      <div class="section-headline margin-top-0 margin-bottom-35">
                          <h3>Recent Tasks</h3>
                          <a href="{{ route('projects.browse') }}" class="headline-link">Browse All Tasks</a>
                      </div>

                      <!-- Jobs Container -->
                      <div class="tasks-list-container compact-list margin-top-35">
                          @foreach ($recent_projects as $project)
                              <!-- Task -->
                              <a href="{{ route('projects.show', $project) }}" class="task-listing">

                                  <!-- Job Listing Details -->
                                  <div class="task-listing-details">

                                      <!-- Details -->
                                      <div class="task-listing-description">
                                          <h3 class="task-listing-title">{{ $project->title }}</h3>
                                          <ul class="task-icons">
                                              <li><i class="icon-material-outline-location-on"></i>
                                                  {{ $project->category->parent->name ?? $project->category->name }}</li>
                                              <li><i class="icon-material-outline-access-time"></i>
                                                  {{ $project->created_at->diffForHumans() }}</li>
                                          </ul>
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
                                              <strong>$ {{ $project->budget }}</strong>
                                              <span>{{ ucfirst($project->type) }}</span>
                                          </div>
                                          <span class="button button-sliding-icon ripple-effect">Bid Now <i
                                                  class="icon-material-outline-arrow-right-alt"></i></span>
                                      </div>
                                  </div>
                              </a>
                          @endforeach

                      </div>
                      <!-- Jobs Container / End -->

                  </div>
              </div>
          </div>
      </div> <!-- Featured Jobs / End -->

      <!-- Icon Boxes -->
      <div class="section padding-top-65 padding-bottom-65">
          <div class="container">
              <div class="row">

                  <div class="col-xl-12">
                      <!-- Section Headline -->
                      <div class="section-headline centered margin-top-0 margin-bottom-5">
                          <h3>How It Works?</h3>
                      </div>
                  </div>

                  <div class="col-xl-4 col-md-4">
                      <!-- Icon Box -->
                      <div class="icon-box with-line">
                          <!-- Icon -->
                          <div class="icon-box-circle">
                              <div class="icon-box-circle-inner">
                                  <i class="icon-line-awesome-lock"></i>
                                  <div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
                              </div>
                          </div>
                          <h3>Create an Account</h3>
                          <p>Bring to the table win-win survival strategies to ensure proactive domination going
                              forward.</p>
                      </div>
                  </div>

                  <div class="col-xl-4 col-md-4">
                      <!-- Icon Box -->
                      <div class="icon-box with-line">
                          <!-- Icon -->
                          <div class="icon-box-circle">
                              <div class="icon-box-circle-inner">
                                  <i class="icon-line-awesome-legal"></i>
                                  <div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
                              </div>
                          </div>
                          <h3>Post a Task</h3>
                          <p>Efficiently unleash cross-media information without. Quickly maximize return on investment.
                          </p>
                      </div>
                  </div>

                  <div class="col-xl-4 col-md-4">
                      <!-- Icon Box -->
                      <div class="icon-box">
                          <!-- Icon -->
                          <div class="icon-box-circle">
                              <div class="icon-box-circle-inner">
                                  <i class=" icon-line-awesome-trophy"></i>
                                  <div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
                              </div>
                          </div>
                          <h3>Choose an Expert</h3>
                          <p>Nanotechnology immersion along the information highway will close the loop on focusing
                              solely.</p>
                      </div>
                  </div>

              </div>
          </div>
      </div>
      <!-- Icon Boxes / End -->


      <!-- Testimonials -->
      <div class="section gray padding-top-65 padding-bottom-55">

          <div class="container">
              <div class="row">
                  <div class="col-xl-12">
                      <!-- Section Headline -->
                      <div class="section-headline centered margin-top-0 margin-bottom-5">
                          <h3>Testimonials</h3>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Categories Carousel -->
          <div class="fullwidth-carousel-container margin-top-20">
              <div class="testimonial-carousel testimonials">

                  <!-- Item -->
                  <div class="fw-carousel-review">
                      <div class="testimonial-box">
                          <div class="testimonial-avatar">
                              <img src="images/user-avatar-small-02.jpg" alt="">
                          </div>
                          <div class="testimonial-author">
                              <h4>Sindy Forest</h4>
                              <span>Freelancer</span>
                          </div>
                          <div class="testimonial">Efficiently unleash cross-media information without cross-media
                              value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain
                              clicks-and-mortar solutions without functional solutions.</div>
                      </div>
                  </div>

                  <!-- Item -->
                  <div class="fw-carousel-review">
                      <div class="testimonial-box">
                          <div class="testimonial-avatar">
                              <img src="images/user-avatar-small-01.jpg" alt="">
                          </div>
                          <div class="testimonial-author">
                              <h4>Tom Smith</h4>
                              <span>Freelancer</span>
                          </div>
                          <div class="testimonial">Completely synergize resource taxing relationships via premier niche
                              markets. Professionally cultivate one-to-one customer service with robust ideas.
                              Dynamically innovate resource-leveling customer service for state of the art.</div>
                      </div>
                  </div>

                  <!-- Item -->
                  <div class="fw-carousel-review">
                      <div class="testimonial-box">
                          <div class="testimonial-avatar">
                              <img src="images/user-avatar-placeholder.png" alt="">
                          </div>
                          <div class="testimonial-author">
                              <h4>Sebastiano Piccio</h4>
                              <span>Employer</span>
                          </div>
                          <div class="testimonial">Completely synergize resource taxing relationships via premier niche
                              markets. Professionally cultivate one-to-one customer service with robust ideas.
                              Dynamically innovate resource-leveling customer service for state of the art.</div>
                      </div>
                  </div>

                  <!-- Item -->
                  <div class="fw-carousel-review">
                      <div class="testimonial-box">
                          <div class="testimonial-avatar">
                              <img src="images/user-avatar-small-03.jpg" alt="">
                          </div>
                          <div class="testimonial-author">
                              <h4>David Peterson</h4>
                              <span>Freelancer</span>
                          </div>
                          <div class="testimonial">Collaboratively administrate turnkey channels whereas virtual
                              e-tailers. Objectively seize scalable metrics whereas proactive e-services. Seamlessly
                              empower fully researched growth strategies and interoperable sources.</div>
                      </div>
                  </div>

                  <!-- Item -->
                  <div class="fw-carousel-review">
                      <div class="testimonial-box">
                          <div class="testimonial-avatar">
                              <img src="images/user-avatar-placeholder.png" alt="">
                          </div>
                          <div class="testimonial-author">
                              <h4>Marcin Kowalski</h4>
                              <span>Freelancer</span>
                          </div>
                          <div class="testimonial">Efficiently unleash cross-media information without cross-media
                              value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain
                              clicks-and-mortar solutions without functional solutions.</div>
                      </div>
                  </div>

              </div>
          </div>
          <!-- Categories Carousel / End -->

      </div>
      <!-- Testimonials / End -->


      <!-- Counters -->
      <div class="section padding-top-70 padding-bottom-75">
          <div class="container">
              <div class="row">

                  <div class="col-xl-12">
                      <div class="counters-container">

                          <!-- Counter -->
                          <div class="single-counter">
                              <i class="icon-line-awesome-suitcase"></i>
                              <div class="counter-inner">
                                  <h3><span>{{ $stats['projects'] }}</span></h3>
                                  <span class="counter-title">Jobs Posted</span>
                              </div>
                          </div>

                          <!-- Counter -->
                          <div class="single-counter">
                              <i class="icon-line-awesome-legal"></i>
                              <div class="counter-inner">
                                  <h3><span>{{ $stats['open_projects'] }}</span></h3>
                                  <span class="counter-title">Tasks Posted</span>
                              </div>
                          </div>

                          <!-- Counter -->
                          <div class="single-counter">
                              <i class="icon-line-awesome-user"></i>
                              <div class="counter-inner">
                                  <h3><span>{{ $stats['freelancers'] }}</span></h3>
                                  <span class="counter-title">Active Members</span>
                              </div>
                          </div>

                          <!-- Counter -->
                          <div class="single-counter">
                              <i class="icon-line-awesome-trophy"></i>
                              <div class="counter-inner">
                                  <h3><span>99</span>%</h3>
                                  <span class="counter-title">Satisfaction Rate</span>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Counters / End -->
  </x-front-layout>
