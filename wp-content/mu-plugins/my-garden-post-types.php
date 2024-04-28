<?php

function my_garden_custom_post_types() {
  // My Garden Post Type
  register_post_type('my-garden', array(
    'labels' => array(
      'name'          => __('My Garden', 'textdomain'),
      'singular_name' => __('My Garden', 'textdomain'),
      'add_new'       => __( 'Add New Plant', 'textdomain' ),
      'add_new_item'  => __( 'Add New Plant', 'textdomain' ),
      'edit_item'     => __( 'Edit Plant', 'textdomain' ),
      'all_items'     => __( 'All Plants', 'textdomain' ),
    ),
    // user's garden items remain private
    'public'        => false,
    'publicly_queryable' => true,
    'show_ui'       => true,
    'menu_icon'     => 'dashicons-palmtree',
    'menu_position' => 20, 
    'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
    'show_in_rest'  => true,
    // allow subscribers to create garden items from front end.  This removes 'my-garden' CPT from Admins until explicitly grant permissions (below)
    // 'capability_type' => 'garden',
    // 'map_meta_cap' => true
  ));


  // Care Note Post Type
  register_post_type('care-note', array(
    'labels' => array(
      'name'          => __('Care Note', 'textdomain'),
      'singular_name' => __('Care Note', 'textdomain'),
      'add_new'       => __( 'Add New Note', 'textdomain' ),
      'add_new_item'  => __( 'Add New Note', 'textdomain' ),
      'edit_item'     => __( 'Edit Note', 'textdomain' ),
      'all_items'     => __( 'All Care Notes', 'textdomain' ),
    ),
    'public'        => false,
    'publicly_queryable' => true,
    'show_ui'       => true,
    'menu_icon'     => 'dashicons-edit-page',
    'menu_position' => 30, 
    'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
    'show_in_rest'  => true,
  ));

}

add_action('init', 'my_garden_custom_post_types');

?>