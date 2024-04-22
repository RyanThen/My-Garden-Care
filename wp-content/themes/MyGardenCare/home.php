<?php get_header(); ?>

<main class="container mt-4">

  <?php // query for featured post(s)
  $featuredPosts = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'meta_key' => 'featured_blog_post',
    'meta_query'     => array(
      array(
        'key'     => 'featured_blog_post',
        'compare' => 'LIKE',
        'value'   => 'Yes',
        'type'    => 'text',
      )
    ),
    'orderby' => 'meta_value post_date',
  ));
  
  while($featuredPosts->have_posts()) {
    $featuredPosts->the_post(); ?>

      <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
        <div class="col-lg-6 px-0">
          <h1 class="display-4 fst-italic"><?php the_title(); ?></h1>
          <p class="lead my-3"><?php echo wp_trim_words(get_the_content(), 30); ?></p>
          <p class="lead mb-0"><a href="<?php echo get_the_permalink(); ?>" class="text-body-emphasis fw-bold">Continue reading...</a></p>
        </div>
      </div>

  <?php } 
  
  wp_reset_postdata(); 
   
  // // query for latest posts that are not the featured blog post
  // $latestPosts = new WP_Query(array(
  //   'post_type' => 'post',
  //   'posts_per_page' => 2,
  //   'paged'          => get_query_var('paged', 1),
  //   'meta_key' => 'featured_blog_post',
  //   'meta_query'     => array(
  //     array(
  //       'key'     => 'featured_blog_post',
  //       'compare' => 'NOT LIKE',
  //       'value'   => 'Yes',
  //     )
  //   ),
  // )); ?>


  <h3 class="pt-3 pb-2 mb-4 fst-italic">All Posts</h3>

  <div class="row g-5 mb-2">

    <div class="col-md-8">

      <?php 
      $blogCount = 0;
      
      while(have_posts()) {
        the_post(); 
        $blogCount++; ?>

        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          
          <?php // check if post index in loop is even
          if($blogCount % 2 == 0) { ?>
            <div class="col-auto d-none d-lg-block">
              <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            </div>
          <?php } ?>

          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary-emphasis">
              <?php 
              $primary_term_name = yoast_get_primary_term( 'category', get_the_ID() );

              if ( $primary_term_name ) {
                echo $primary_term_name;
              } elseif ( !$primary_term_name ) {
                echo get_the_category()[0]->cat_name;
              } ?>
            </strong>
            <h3 class="mb-0"><?php the_title(); ?></h3>
            <div class="mb-1 text-body-secondary"><?php the_date(); ?></div>
            <p class="card-text mb-auto"><?php echo wp_trim_words(get_the_content(), 24); ?></p>
            <a href="<?php echo get_the_permalink(); ?>" class="icon-link gap-1 icon-link-hover stretched-link">
              Continue reading
              <svg class="bi"><use xlink:href="#chevron-right"></use></svg>
            </a>
          </div>

          <?php // check if post index in loop is odd
          if($blogCount % 2 == 1) { ?>
            <div class="col-auto d-none d-lg-block">
              <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            </div>
          <?php } ?>
          
        </div>
      
      <?php } 

      echo paginate_links();
    
      wp_reset_postdata(); ?>

    </div>


    <div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-body-tertiary rounded">
          <h4 class="fst-italic">About</h4>
          <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
        </div>

        <div>
          
          <?php 
          $catQuery = new WP_Query(array(
            'posts_per_page' => 3,
            // 'cat' => 2,
            'category_name' => 'garden'
            // MAKE CATEGORY MORE FLEXIBLE
          )); ?>

          <h4 class="fst-italic"><?php //var_dump($catQuery); ?>Garden Posts</h4>

          <ul class="list-unstyled">

            <?php
            while($catQuery->have_posts()) { 
              $catQuery->the_post(); ?>
              <li>
                <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="#">
                  <svg class="bd-placeholder-img" width="100%" height="96" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"></rect></svg>
                  <div class="col-lg-8">
                    <h6 class="mb-0"><?php the_title(); ?></h6>
                    <small class="text-body-secondary"><?php the_date(); ?></small>
                  </div>
                </a>
              </li>
            <?php } ?>

          </ul>

        </div>

        <div class="p-4">
          <h4 class="fst-italic">Archives</h4>
          <ol class="list-unstyled mb-0">
            <?php // list archive links
              echo wp_get_archives(array(
                'type'            => 'monthly',
                'limit'           => '',
                'format'          => 'html',
                'before'          => '',
                'after'           => '',
                'show_post_count' => false,
                'echo'            => 1,
                'order'           => 'DESC',
                'post_type'       => 'post',
                'year'            => get_query_var( 'year' ),
                'monthnum'        => get_query_var( 'monthnum' ),
                'day'             => get_query_var( 'day' ),
                'w'               => get_query_var( 'w' ),
              ));
            ?>
            <!-- <li><a href="#">January 2024</a></li> -->
          </ol>
        </div>

        <div class="p-4">
          <h4 class="fst-italic">Elsewhere</h4>
          <ol class="list-unstyled">
            <li><a href="#">GitHub</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Facebook</a></li>
          </ol>
        </div>
      </div>
    </div>

  </div>

</main>

<?php get_footer(); ?>