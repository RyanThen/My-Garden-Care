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

    <div class="p-5 mb-5 bg-body-tertiary rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold"><?php the_title(); ?></h1>
        <p class="col-md-8 fs-4">Welcome to your digital garden! This is where you can add plants, care notes or other helpful information for your plant caregivers.</p>
        <button class="btn btn-primary btn-lg" type="button">Example button</button>
      </div>
    </div>

    
    <div class="page-inner-container d-flex">

      <div class="garden-body d-flex flex-column align-items-stretch">

        <div class="container">
          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-4" role="search">
            <input type="search" class="form-control form-control-white text-bg-white" placeholder="Search for plants..." aria-label="Search">
          </form>
        </div>
        
        <div class="container ps-0 pe-5 py-5" id="icon-grid">
          <h2 class="pb-2 border-bottom">Plant Search Results</h2>
          <div class="plant-list row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4 py-5">

            <div class="col d-flex align-items-start">
              <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#bootstrap"></use></svg>
              <div>
                <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Plant Name</h3>
                <p>Paragraph of text beneath the heading to explain the heading.</p>
              </div>
            </div>
            <div class="col d-flex align-items-start">
              <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#bootstrap"></use></svg>
              <div>
                <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Plant Name</h3>
                <p>Paragraph of text beneath the heading to explain the heading.</p>
              </div>
            </div>
            <div class="col d-flex align-items-start">
              <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#bootstrap"></use></svg>
              <div>
                <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Plant Name</h3>
                <p>Paragraph of text beneath the heading to explain the heading.</p>
              </div>
            </div>
            
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

          <a href="#" class="list-group-item list-group-item-action py-3 lh-sm <?php if($myGarden->post == $myGarden->posts[0]) echo 'active'; ?>" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
              <strong class="mb-1"><?php the_title(); ?></strong>
              <small>Wed</small>
            </div>
            <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
          </a>

          <!-- <li data-id="<?php echo get_the_ID(); ?>">
            <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); // str_replace() three parameters: what string do you want to replace, what to replace it with, from which text are you searching through. Whenever using user generated info from database as html attribute wrap it in esc_attr() ?>">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); // wp_strip_all_tags() removes html tags and comments which are stored in the database along with content ?></textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
          </li> -->
        <?php
        } ?>

        </div>
      </div> <!-- .garden-list -->



    </div> <!-- .page-inner-container -->

    <div style="padding-block: 150px;"><p>Spacer</p></div>

  </div>

<?php }

get_footer(); ?>