<?php get_header(); ?>

<div class="container container--narrow page-section">
<?php
if(have_posts()) {
  while(have_posts()) {
    the_post(); ?>

    <div class="container py-4 px-0">
      <div class="p-5 bg-body-tertiary rounded-3 border">
        <div class="meta-info d-flex justify-content-end">
          <p class="mb-0">Post Type: <?php echo get_post_type(); ?></p>
        </div>
        <div class="container-fluid py-5">
          <h2 class="display-5 fw-bold"><?php the_title(); ?></h2>
        </div>
        <div class="generic-content">
          <?php if(get_the_excerpt()) { echo get_the_excerpt(); } else { echo wp_trim_words(get_the_content(), 25); } ?>
        </div>
      </div>
    </div>

  <?php 
  }

  echo paginate_links();
} else {
  echo '<h2 class="my-5">No results.  Try searching something else.</h2>';
} ?>

  <div class="my-5" style="max-width: 600px;"><?php get_search_form(); ?></div>
  
</div>

<?php get_footer(); ?>