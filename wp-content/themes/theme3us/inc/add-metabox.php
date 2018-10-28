<?php
function add_theme_meta_box(){
  add_meta_box(
    'video-process-metabox',
    'Tải video lên Youtube',
    'video_process_metabox',
    'post'
  );
}

add_action('add_meta_boxes', 'add_theme_meta_box');

function video_process_metabox($post){
  $title = get_the_title();
  $source = get_field( 'link_upload' );
  $id = get_the_ID();

  // Database configuration
  $username = 'mina24h_admin';
  $password = 'egmZ@!px8=!O';
  $dsn = 'mysql:host=localhost;dbname=mina24h_db';
  $db = new PDO($dsn, $username, $password);
  $sql = "SELECT * FROM videos WHERE video_path = '" . $source . "'";
  $result = $db->query($sql);
  $youtubeID = '';
  foreach ($result as $key => $value) {
    $youtubeID = $value['youtube_video_id'];
  }
  if( $youtubeID ) {
    $youtubeUrl = 'https://www.youtube.com/watch?v=' . $youtubeID;
    update_post_meta($post->ID, 'video_link', $youtubeUrl);
    update_post_meta($post->ID, 'video_source', 'youtube');
    $href = '#';
    $text = 'Đã upload lên Youtube';
  } else {
    $href = get_template_directory_uri() . '/video-upload/?title=' . $title . '&source=' . $source . '&id=' . $id;
    $text = 'Xử lý Upload';
  }
?>
    <p>
      <a href="<?php echo $href; ?>" class="button"><?php echo $text; ?></a>
    </p>
    <?php
}

add_action('save_post', 'theme_post_type_save');

function theme_post_type_save(){
  global $post; 
  //Slider
  // update_post_meta($post->ID, 'process', $_POST['process']);
}

?>