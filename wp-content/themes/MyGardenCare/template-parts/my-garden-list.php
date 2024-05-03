<a href="<?php echo get_the_permalink(); ?>" class="list-group-item list-group-item-action py-3 lh-sm <?php if($post->ID == $args['current_page_id']) echo 'active'; ?>" aria-current="true">
  <div class="d-flex w-100 align-items-center justify-content-between">
    <strong class="mb-1"><?php the_title(); ?></strong>
    <small><?php the_time('D'); ?></small>
  </div>
  <div class="col-10 mb-1 small"><?php echo wp_trim_words(get_the_content(), 10); ?></div>
</a>