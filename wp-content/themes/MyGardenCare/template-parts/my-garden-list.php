<div class="garden-list d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary">

  <div class="d-flex justify-content-between align-items-center flex-shrink-0 p-3 link-body-emphasis text-decoration-none border-bottom">
    <a href="#" class="link-body-emphasis text-decoration-none">
      <span class="fs-5 fw-semibold">My Garden</span> 
    </a>
    <button class="new-plant-btn btn btn-outline-danger">Add New Plant</button>
  </div>

  <div class="custom-plant-container d-flex p-3 bg-white border-bottom d-none">
    <div class="custom-plant-fields-container note pb-2">
      <input class="custom-plant-title-field note-title-field w-100" value="" placeholder="Plant Name...">
      <textarea class="custom-plant-body-field note-body-field" placeholder="Plant Details..."></textarea>
      <span class="add-custom-plant-btn btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Add Plant</span>
    </div>
  </div>

  <div class="list-group list-group-flush border-bottom scrollarea">

  <?php 
  $myGarden = new WP_Query(array(
    'post_type' => 'my-garden',
    'posts_per_page' => -1,
    // 'author' => get_current_user_id()
  ));

  while($myGarden->have_posts()) {
    $myGarden->the_post(); ?>
    
    <a href="<?php echo get_the_permalink(); ?>" class="list-group-item list-group-item-action py-3 lh-sm <?php if($post->ID == $args['current_page_id']) echo 'active'; ?>" aria-current="true">
      <div class="d-flex w-100 align-items-center justify-content-between">
        <strong class="mb-1"><?php the_title(); ?></strong>
        <small><?php the_time('D'); ?></small>
      </div>
      <div class="col-10 mb-1 small"><?php echo wp_trim_words(get_the_content(), 10); ?></div>
    </a>

  <?php } 
  
  wp_reset_postdata(); ?>

  </div>
</div> <!-- .garden-list -->