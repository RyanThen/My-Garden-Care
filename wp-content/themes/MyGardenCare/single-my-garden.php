<?php get_header(); 

while(have_posts()) {
  the_post(); ?>

<!-- Jumbotron -->
  <div class="page-container container py-4" data-plantid="<?php echo get_the_ID(); ?>">

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
      <div class="container-fluid d-flex justify-content-between py-5">
        <div class="hero-content-container">
          <h1 class="display-5 fw-bold"><?php the_title(); ?></h1>
          <h3 class="plant-hero-common-name col-md-8 fs-4 my-3">Common Names: </h3>
          <div class="plant-hero-content"><?php the_content(); ?></div>
          <a class="btn btn-primary btn-lg" href="#care-notes-list">See Saved Notes</a>
        </div>
        <div class="plant-hero-img-container">
          <img class="plant-hero-img" src="#">
        </div>
      </div>
    </div>

    <div class="page-inner-container d-flex">

      <div class="plant-body d-flex flex-column align-items-stretch">
        <div class="plant-info-container generic-content p-5 mb-4 rounded-3">
          <!-- Plant Info -->
        </div>

        <div class="notes-wrap">

          <h2 class="headline pt-5 pb-3 border-top">Create a new note</h2>

          <ul class="create-care-note note-list border">

            <li class="note" data-id="<?php echo get_the_ID(); ?>">
              <input class="note-title-field" value="" placeholder="Note Title...">
              <!-- <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
              <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span> -->
              <textarea class="note-body-field" placeholder="Note Content..."></textarea>
              <span class="create-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Create Note</span>
            </li>

          </ul>

          <h2 class="headline pt-5 pb-3 border-top">Saved notes</h2>

          <ul id="care-notes-list" class="care-notes-list note-list">
            <?php 
              $currentPostID = get_the_ID();

              $careNotes = new WP_Query(array(
                'post_type' => 'care-note',
                'posts_per_page' => -1,
                // 'author' => get_current_user_id()
              ));

              while($careNotes->have_posts()) {
                $careNotes->the_post(); 
                
                if ($currentPostID == get_field('plant_id')) { ?>

                  <li class="note" data-id="<?php echo get_the_ID(); ?>">
                    <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); // str_replace() three parameters: what string do you want to replace, what to replace it with, from which text are you searching through. ?>">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); // wp_strip_all_tags() removes html tags and comments which are stored in the database along with content ?></textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                  </li>

                <?php 
                }
              } ?>
          </ul>

        </div> <!-- .notes-wrap -->

      </div>

      <div class="garden-list d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary">
        <a href="/" class="d-flex align-items-center flex-shrink-0 p-3 link-body-emphasis text-decoration-none border-bottom">
          <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-5 fw-semibold">My Garden</span>
        </a>
        <div class="list-group list-group-flush border-bottom scrollarea">

        <?php 
        $current_page_url_http = "http://" . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $current_page_url_https = "https://" . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $myGarden = new WP_Query(array(
          'post_type' => 'my-garden',
          'posts_per_page' => -1,
          // 'author' => get_current_user_id()
        ));

        while($myGarden->have_posts()) {
          $myGarden->the_post(); ?>

          <a href="<?php echo get_the_permalink(); ?>" class="list-group-item list-group-item-action py-3 lh-sm <?php if($myGarden->post->guid == $current_page_url_http && $current_page_url_https) echo 'active'; ?>" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
              <strong class="mb-1"><?php the_title(); ?></strong>
              <small><?php the_time('D'); ?></small>
            </div>
            <div class="col-10 mb-1 small"><?php echo wp_trim_words(get_the_content(), 10); ?></div>
          </a>

        <?php
        } ?>

        </div>
      </div> <!-- .garden-list -->

    </div>

  </div>

<?php }

get_footer(); ?>