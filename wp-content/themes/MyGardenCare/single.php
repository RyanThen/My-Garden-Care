<?php get_header(); 

while(have_posts()) {
  the_post(); ?>

<!-- Jumbotron -->
  <div class="container py-4">

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
      <div class="hero-container container-fluid py-5">
        <div class="hero-content">
          <h1 class="display-5 fw-bold"><?php the_title(); ?></h1>
          <p><?php if(get_the_excerpt()) { echo get_the_excerpt(); } else { echo wp_trim_words(get_the_content(), 25); } ?></p>
        </div>
        <div class="hero-img-container">
          <img class="hero-img" src="<?php echo get_the_post_thumbnail_url( get_the_ID()); ?>">
        </div>
      </div>
    </div>

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>

<?php }

get_footer(); ?>