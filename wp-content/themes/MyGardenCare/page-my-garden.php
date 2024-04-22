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
  <div class="container py-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold"><?php the_title(); ?></h1>
        <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
        <button class="btn btn-primary btn-lg" type="button">Example button</button>
      </div>
    </div>

    <?php 
    $myGarden = new WP_Query(array(
      'post_type' => 'my-garden',
      'posts_per_page' => -1,
      // 'author' => get_current_user_id()
    ));

    while($myGarden->have_posts()) {
      $myGarden->the_post(); ?>

      <li data-id="<?php echo get_the_ID(); ?>">
        <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); // str_replace() three parameters: what string do you want to replace, what to replace it with, from which text are you searching through. Whenever using user generated info from database as html attribute wrap it in esc_attr() ?>">
        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
        <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); // wp_strip_all_tags() removes html tags and comments which are stored in the database along with content ?></textarea>
        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
      </li>
    <?php
    } ?>

  </div>

<?php }

get_footer(); ?>