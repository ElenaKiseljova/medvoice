<?php 
  global $video_children, $video, $place;

  $place = 'list';
  
  // Кол-во дочерних страниц
  if ( !isset($video_children) || empty($video_children) ) {
    return;
  }
?>

<div class="catalog__cards">
  <?php foreach ($video_children as $key => $video_child) : ?>
    <?php 
      $video = $video_child;
      
      get_template_part( 'templates/card' );
    ?>
  <?php endforeach; ?>  
</div>
