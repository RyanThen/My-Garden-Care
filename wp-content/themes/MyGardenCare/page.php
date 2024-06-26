<?php get_header(); 

while(have_posts()) {
  the_post(); ?>

<!-- Jumbotron -->
  <div class="container py-4">

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold"><?php the_title(); ?></h1>
        <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
        <button class="btn btn-primary btn-lg" type="button">Example button</button>
      </div>
    </div>

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>

<?php }

get_footer(); ?>