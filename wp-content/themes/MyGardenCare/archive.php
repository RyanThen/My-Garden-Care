<?php get_header(); ?>

  <div class="container py-3">

    <h1><?php echo get_the_archive_title(); ?></h1>

    <?php while(have_posts()) {
      the_post(); ?>

      <div class="container py-4 px-0">
        <div class="p-5 bg-body-tertiary rounded-3 border">
          <div class="container-fluid py-5">
            <h2 class="display-5 fw-bold"><?php the_title(); ?></h2>
          </div>
          <div class="generic-content">
            <?php if(get_the_excerpt()) { echo get_the_excerpt(); } else { echo wp_trim_words(get_the_content(), 25); } ?>
          </div>
        </div>
      </div>
    
    <?php } 

    echo paginate_links(); ?>

  </div>

<?php get_footer(); ?>