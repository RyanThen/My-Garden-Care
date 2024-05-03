<?php
add_action('rest_api_init', 'mgcNotesRoutes');

function mgcNotesRoutes() {
  // POST
  register_rest_route('mgc/v1', 'manageNote', array(
    'methods' => 'POST',
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
    'meta_input' => array(
      'plant_id' => $plant_id
    )
  ));

}