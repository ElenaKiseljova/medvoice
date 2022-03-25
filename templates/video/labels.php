<?php 
  global $video_id;

  if ( !isset($video_id) ) {
    return;
  }

  $video_tags_terms = wp_get_post_terms( $video_id, 'labels' ) ?? [];

  if ( empty($video_tags_terms) || is_wp_error( $video_tags_terms ) ) {
    return;
  }
?>
<ul class="course__tag-list">
  <?php foreach ($video_tags_terms as $key => $video_tags_term) : ?>
    <li class="course__tag">
      <a class="button button--tag" href="#">
        <?= $video_tags_term->name; ?>
      </a>
    </li>
  <?php endforeach; ?>  
</ul>