<?php
add_action('rest_api_init', 'mgcNotesRoutes');

function mgcNotesRoutes() {
  // POST
    register_rest_route('mgc/v1', 'manageNote', array(
      'methods' => 'POST',
      // callback needs to return something
      'callback' => 'createNote'
    ));
}

function createNote($data) {
  $plant_id = $data['plant_id'];

  return wp_insert_post(array(
    'post_type' => 'care-note',
    'post_status' => 'publish',
    'post_title' => $data['title'],
    'post_content' => $data['content'],
    // meta_input will populate a backend field in the wp admin with a value
    'meta_input' => array(
      // ACF will match the key (liked_professor_id) with the custom field label for the post
      'plant_id' => $plant_id
    )
  ));

}