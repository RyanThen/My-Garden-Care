<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('title'); ?></title>

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <header class="p-3 bg-danger bg-gradient">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="h4 d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            MYG
            <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg> -->
          </a>

          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li <?php if(is_front_page()) echo 'class="current-menu-item"' ?>><a href="<?php echo esc_url(site_url('/')); ?>" class="nav-link px-2 text-black">Home</a></li>
            <li><a href="<?php echo esc_url(site_url('/my-garden')); ?>" class="nav-link px-2 text-black">My Garden</a></li>
            <li><a href="#" class="nav-link px-2 text-black">Pricing</a></li>
            <li><a href="#" class="nav-link px-2 text-black">FAQs</a></li>
            <li><a href="#" class="nav-link px-2 text-black">About</a></li>
            <li <?php if(get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?php echo esc_url(site_url('/blog')); ?>" class="nav-link px-2 text-black">Blog</a></li>
          </ul>

          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input type="search" class="form-control form-control-white text-bg-white" placeholder="Search..." aria-label="Search">
          </form>

          <div class="text-end">

            <?php // conditional logic for login and log out nav buttons
            if (is_user_logged_in()) { ?>
              <a href="<?php echo wp_logout_url(); ?>">
                <button type="button" class="btn btn-outline-light me-2">Logout</button>
              </a>
            <?php } else { ?>
              <?php // send users to wp login screen ?>
              <a href="<?php echo wp_login_url(); ?>">
                <button type="button" class="btn btn-outline-light me-2">Login</button>
              </a>
              <?php // send users to sign up / registration page for new user sign up ?>
              <a href="<?php echo wp_registration_url(); ?>">
                <button type="button" class="btn btn-warning">Sign-up</button>
              </a>
            <?php } ?>
            
          </div>
        </div>
      </div>
    </header>