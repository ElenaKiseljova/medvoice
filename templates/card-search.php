<?php 
  global $video_id;

  if ( !isset($video_id) ) {
    return;
  }

  $title = get_the_title( $video_id );

  // Формат видео
  $video_format = medvoice_get_single_format_video_arr( $video_id, ['name'] );

  $video_format_name = '';
  if ( $video_format && is_array($video_format) && !is_wp_error( $video_format ) ) {
    $video_format_name = $video_format['name'] ?? '';
  }
?>
<li class="results__item">
  <a href="<?= get_permalink( $video_id ); ?>" class="results__link">
    <div class="results__img-box">
      <?php if ( has_post_thumbnail( $video_id )) : ?>
        <img class="results__img" src="<?= get_the_post_thumbnail_url( $video_id, 'video_side' ); ?>" alt="<?= strip_tags( $title ); ?>">
      <?php endif; ?>
    </div>
    <div class="results__text-box">
      <p class="results__text">
        <?= $video_format_name; ?>
      </p>
      <h4 class="results__name">
        <?= $title; ?>
      </h4>
    </div>
  </a>
</li>