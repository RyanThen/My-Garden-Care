<?php get_header(); ?>

<!-- Hero -->
<div class="px-4 pt-5 my-5 text-center border-bottom">
  <h1 class="display-4 fw-bold text-body-emphasis">My Garden Care</h1>
  <div class="col-lg-6 mx-auto">
    <p class="lead mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
      <button type="button" class="btn btn-warning btn-lg px-4 me-sm-3">Primary button</button>
      <button type="button" class="btn btn-outline-dark btn-lg px-4">Secondary</button>
    </div>
  </div>
  <div class="overflow-hidden" style="max-height: 35vh;">
    <div class="container-fluid px-5">
      <img src="<?php echo esc_url(site_url('/wp-content/uploads/2024/04/my-garden-care-hero-img-scaled.jpg')); ?>" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="100%" height="600" loading="lazy" style="">
    </div>
  </div>
</div>

<!-- Events and Blog Lists -->
<div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
  <div class="bg-body-tertiary flex-grow-1 me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
    <div class="my-3 p-3">
      <h2 class="display-5">Events near you</h2>
      <p class="lead">Lorem ipsum dolor sit amet.</p>
    </div>
    <div class="mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
  
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
          <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
          <div class="d-flex gap-2 w-100 justify-content-between">
            <div>
              <h6 class="mb-0">List group item heading</h6>
              <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
            </div>
            <small class="opacity-50 text-nowrap">now</small>
          </div>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
          <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
          <div class="d-flex gap-2 w-100 justify-content-between">
            <div>
              <h6 class="mb-0">Another title here</h6>
              <p class="mb-0 opacity-75">Some placeholder content in a paragraph that goes a little longer so it wraps to a new line.</p>
            </div>
            <small class="opacity-50 text-nowrap">3d</small>
          </div>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
          <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
          <div class="d-flex gap-2 w-100 justify-content-between">
            <div>
              <h6 class="mb-0">Third heading</h6>
              <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
            </div>
            <small class="opacity-50 text-nowrap">1w</small>
          </div>
        </a>
      </div>

    </div>
  </div>
  <div class="bg-body-tertiary flex-grow-1 me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
    <div class="my-3 py-3">
      <h2 class="display-5">From our blog</h2>
      <p class="lead">Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
    <div class="mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">

      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
          <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
          <div class="d-flex gap-2 w-100 justify-content-between">
            <div>
              <h6 class="mb-0">List group item heading</h6>
              <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
            </div>
            <small class="opacity-50 text-nowrap">now</small>
          </div>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
          <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
          <div class="d-flex gap-2 w-100 justify-content-between">
            <div>
              <h6 class="mb-0">Another title here</h6>
              <p class="mb-0 opacity-75">Some placeholder content in a paragraph that goes a little longer so it wraps to a new line.</p>
            </div>
            <small class="opacity-50 text-nowrap">3d</small>
          </div>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
          <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
          <div class="d-flex gap-2 w-100 justify-content-between">
            <div>
              <h6 class="mb-0">Third heading</h6>
              <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
            </div>
            <small class="opacity-50 text-nowrap">1w</small>
          </div>
        </a>
      </div>

    </div>
  </div>
</div>


<!-- Carousel -->
<div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active carousel-item-start">
      <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
      <div class="container">
        <div class="carousel-caption text-start">
          <h1>Example headline.</h1>
          <p class="opacity-75">Some representative placeholder content for the first slide of the carousel.</p>
          <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
        </div>
      </div>
    </div>
    <div class="carousel-item carousel-item-next carousel-item-start">
      <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
      <div class="container">
        <div class="carousel-caption">
          <h1>Another example headline.</h1>
          <p>Some representative placeholder content for the second slide of the carousel.</p>
          <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
      <div class="container">
        <div class="carousel-caption text-end">
          <h1>One more for good measure.</h1>
          <p>Some representative placeholder content for the third slide of this carousel.</p>
          <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
        </div>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<?php get_footer(); ?>