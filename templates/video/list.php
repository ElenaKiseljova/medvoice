<?php 
  global $video_side, $video_id;

  if ( !isset($video_side) || empty($video_side) || is_wp_error( $video_side ) || !is_array( $video_side) ) {
    return;
  }
?>

<div class="side__block">
  <ul class="side__list">
    <?php foreach ($video_side as $key => $video_side_item) : ?>
      <?php 
        $video_id =  $video_side_item->ID;  

        get_template_part( 'templates/video/side', 'card' );
      ?>    
    <?php endforeach; ?>  
  </ul>
</div>
