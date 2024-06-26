<?php

require get_theme_file_path('/inc/care-notes-route.php');

// // Register custom REST API fields
// add_action('rest_api_init', 'mgc_rest_api');

// function mgc_rest_api() {
//   register_rest_field('my-garden', 'plantCareDetails', array(
//     'get_callback' => function() { return 'TEsting 1234'; }
//   ));
// } 


add_action('wp_enqueue_scripts', 'mgc_theme_files');

function mgc_theme_files() {
  wp_enqueue_script('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '1.0', true);
  wp_enqueue_script('mgcJS', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

  wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
  wp_enqueue_style('mgc_styles', get_theme_file_uri('/css/style-main.css'));
  wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

  wp_localize_script('mgcJS', 'mgcThemeData', array(
    'root_url' => site_url(),
    'nonce' => wp_create_nonce('wp_rest'),
  ));

}


add_action('after_setup_theme', 'mgc_theme_features');  

function mgc_theme_features() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
}


add_action('pre_get_posts', 'chewy_query_adjustments');

function chewy_query_adjustments($query) {
  // filter out featured blog post so it doesn't display twice
  if (!is_admin() && is_home() && $query->is_main_query()) {
    $query->set('meta_query', array(
      array(
        'key'     => 'featured_blog_post',
        'compare' => 'NOT LIKE',
        'value'   => 'Yes',
      )
    ));
  }

  // include custom post types in search results
  if ($query->is_search) {
    $query->set('post_type', array('post', 'page', 'my-garden'));
  }

  return $query;
}


// redirect subscriber accounts away from admin and onto frontend
add_action('admin_init', 'redirect_subs_to_frontend');

function redirect_subs_to_frontend() {
  $current_user = wp_get_current_user();

  if(count($current_user->roles) == 1 && $current_user->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
  }
}


// remove admin bar for subscriber roles
add_action('wp_loaded', 'no_subs_admin_bar');

function no_subs_admin_bar() {
  $current_user = wp_get_current_user();

  if(count($current_user->roles) == 1 && $current_user->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}


// force notes to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr) {
  if($data['post_type'] == 'care-note') {
    $data['post_title'] = sanitize_text_field($data['post_title']);
    $data['post_content'] = sanitize_textarea_field($data['post_content']);

    // limit number of notes
    if(count_user_posts(get_current_user_id(), 'care-note') > 20 && !$postarr['ID']) {
      die('You have reached your note limit');
    }
  }

  // force note posts to be 'private'
  if($data['post_type'] == 'care-note' && $data['post_status'] != 'trash') {
    $data['post_status'] = 'private';
  }

  return $data;
}