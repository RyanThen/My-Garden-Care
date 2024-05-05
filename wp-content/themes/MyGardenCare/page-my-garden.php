<?php
$currentPageID = get_the_ID();

// if user is not logged in redirect to homepage
if (!is_user_logged_in()) { 
  wp_redirect(esc_url(site_url('/'))); 
  exit;
}

get_header(); 

while(have_posts()) {
  the_post(); ?>

<!-- Jumbotron -->
  <div class="my-garden container py-4">

    <div class="hero-bg-img p-5 mb-5 bg-body-tertiary rounded-3" style="background-image: url(<?php echo site_url('/wp-content/uploads/2024/04/markus-spiske-vrbZVyX2k4I-unsplash-scaled.jpg'); ?>);">
      <div class="container-fluid py-5">
        <div class="hero-text-overlay">
          <h1 class="display-5 fw-bold text-white"><?php the_title(); ?></h1>
          <p class="fs-4 py-2 text-white">Your digital garden. Where you can add plants, care notes, print QR codes and more!</p>
          <a class="btn btn-outline-light btn-lg" href="#plant-list">Browse plant list</a>
        </div>
      </div>
    </div>

    
    <div class="page-inner-container d-flex">

      <div class="garden-body d-flex flex-column align-items-stretch">

        <div class="container ps-0 pe-5 py-5">
          <h2 class="pb-2 font-italic">Search for plants</h2>
          <form id="plant-search-form" class="d-flex col-12 col-lg-auto mb-3 mb-lg-0 me-lg-4" role="search">
            <input id="plant-search-field" class="form-control form-control-white text-bg-white" name="plant-search" type="search" placeholder="Search for plants..." aria-label="Search">
            <input class="btn btn-danger mx-2" type="submit" value="Submit">
          </form>
        </div>
        
        <div class="container ps-0 pe-5 py-4" id="icon-grid">
          <h2 class="pb-2 text-decoration-underline">Plant List:</h2>
          <div id="plant-list" class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 g-4 py-5">
            <!-- Plant List Data -->
          </div>
          <div class="btn-group">
            <button class="btn btn-outline-dark btn-load-more">Get More Results</button>
          </div>
        </div>

      </div> <!-- .garden-body -->

      <?php // My Garden List
      get_template_part('/template-parts/my-garden-list', null, $args = array('current_page_id' => $currentPageID)); ?>

    </div> <!-- .page-inner-container -->

  </div>

<?php }

get_footer(); ?>