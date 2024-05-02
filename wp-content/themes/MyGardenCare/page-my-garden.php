<?php
// if user is not logged in redirect to homepage
if (!is_user_logged_in()) { 
  wp_redirect(esc_url(site_url('/'))); 
  exit;
}

get_header(); 

while(have_posts()) {
  the_post(); ?>

<!-- Jumbotron -->
  <div id="my-garden-wrap" class="container py-4">

    <div class="p-5 mb-5 bg-body-tertiary rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold"><?php the_title(); ?></h1>
        <p class="col-md-8 fs-4">Welcome to your digital garden! This is where you can add plants, care notes or other helpful information for your plant caregivers.</p>
        <a class="btn btn-primary btn-lg" href="#plant-list">Browse plant list</a>
      </div>
    </div>

    
    <div class="page-inner-container d-flex">

      <div class="garden-body d-flex flex-column align-items-stretch">

        <div class="container ps-0 pe-5 py-5">
          <h2 class="pb-2 font-italic">Search for plants</h2>
          <form id="plant-search-form" class="d-flex col-12 col-lg-auto mb-3 mb-lg-0 me-lg-4" role="search">
            <input id="plant-search-field" class="form-control form-control-white text-bg-white" name="plant-search" type="search" placeholder="Search for plants..." aria-label="Search">
            <input class="btn btn-primary mx-2" type="submit" value="Submit!">
          </form>
        </div>
        
        <div class="container ps-0 pe-5 py-4" id="icon-grid">
          <h2 class="pb-2 text-decoration-underline">Plant List:</h2>
          <div id="plant-list" class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 g-4 py-5">
            <!-- Plant List Data -->
          </div>
          <div class="btn-group">
            <button class="btn btn-primary btn-load-more">Get More Results</button>
          </div>
        </div>

      </div> <!-- .garden-body -->
         
      <div class="garden-list d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary">
        <a href="/" class="d-flex align-items-center flex-shrink-0 p-3 link-body-emphasis text-decoration-none border-bottom">
          <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-5 fw-semibold">My Garden</span>
        </a>
        <div class="list-group list-group-flush border-bottom scrollarea">

        <?php 
        $myGarden = new WP_Query(array(
          'post_type' => 'my-garden',
          'posts_per_page' => -1,
          // 'author' => get_current_user_id()
        ));

        while($myGarden->have_posts()) {
          $myGarden->the_post(); ?>

          <a href="<?php echo get_the_permalink(); ?>" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
              <strong class="mb-1"><?php the_title(); ?></strong>
              <small><?php the_time('D'); ?></small>
            </div>
            <div class="col-10 mb-1 small"><?php echo wp_trim_words(get_the_content(), 10); ?></div>
          </a>

        <?php
        } 
        
        wp_reset_postdata(); ?>

        </div>
      </div> <!-- .garden-list -->

    </div> <!-- .page-inner-container -->

  </div>

<?php }

get_footer(); ?>