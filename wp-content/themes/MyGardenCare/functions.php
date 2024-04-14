<?php

add_action('wp_enqueue_scripts', 'mgc_theme_files');

function mgc_theme_files() {
  wp_enqueue_script('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '1.0', true);

  wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
  wp_enqueue_style('mgc_styles', get_theme_file_uri('/css/style-main.css'));
  wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

  // // Adds a script to bottom of html code (near the footer) with a variable you can reference in your JS. It puts the script directly above the file you name in the first parameter
  // wp_localize_script('chewy_theme_main_js', 'chewyThemeData', array(
  //   'root_url' => site_url(),
  //   'nonce' => wp_create_nonce('wp_rest'),
  // ));

}


add_action('after_setup_theme', 'mgc_theme_features');  

function mgc_theme_features() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
}


add_action('pre_get_posts', 'chewy_query_adjustments');

function chewy_query_adjustments($query) {
  if (!is_admin() && is_home() && $query->is_main_query()) {
    $query->set('posts_per_page', 5);
    $query->set('meta_query', array(
      array(
        'key'     => 'featured_blog_post',
        'compare' => 'NOT LIKE',
        'value'   => 'Yes',
      )
    ));
  }
}