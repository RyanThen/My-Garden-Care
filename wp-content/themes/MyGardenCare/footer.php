    <div class="container">
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-body-secondary">©2024 My Garden Care</p>

        <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
          MGC
        </a>

        <ul class="nav col-md-4 justify-content-end">
          <li <?php if(is_front_page()) echo 'class="current-menu-item"' ?>><a href="<?php echo esc_url(site_url('/')); ?>" class="nav-link px-2 text-black">Home</a></li>
          <?php if (is_user_logged_in()) {  // must be logged in to access My Garden ?>
            <li><a href="<?php echo esc_url(site_url('/my-garden')); ?>" class="nav-link px-2 text-black">My Garden</a></li>
          <?php } ?>
          <li><a href="<?php echo esc_url(site_url('/learning-center')); ?>" class="nav-link px-2 text-black">Learning Center</a></li>
          <li><a href="#" class="nav-link px-2 text-black">About</a></li>
          <li <?php if(get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?php echo esc_url(site_url('/blog')); ?>" class="nav-link px-2 text-black">Blog</a></li>
        </ul>
      </footer>
    </div>

    <?php wp_footer(); ?>

  </body>
</html>