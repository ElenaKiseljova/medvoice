<?php 
  global $video_arr, $video, $place;

  $place = 'list';
  
  // Кол-во дочерних страниц
  if ( !isset($video_arr) || empty($video_arr) ) {
    return;
  }
?>

<div class="catalog__cards">
  <?php foreach ($video_arr as $key => $video_item) : ?>
    <?php 
      $video = $video_item;
      
      get_template_part( 'templates/card' );
    ?>
  <?php endforeach; ?>  
</div>
