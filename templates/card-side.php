<?php 
  global $video_id;

  if ( !isset($video_id) ) {
    return;
  }

  $title = get_the_title( $video_id );
  $short_title = mb_substr($title, 0, 30) . '...';

  $author_id = get_post_field( 'post_author', $video_id );

  $author_firstname = get_the_author_meta( 'user_firstname', $author_id ) ?? '';
  $author_lastname = get_the_author_meta( 'user_lastname', $author_id ) ?? '';

  $author_name = ( !empty($author_firstname) && !empty($author_lastname) ) ? 
              ($author_firstname . ' ' . $author_lastname) :
              get_the_author_meta( 'nickname', $author_id );

  $video_duration = '';

  $vimeo_id = get_field( 'vimeo_id', $video_id ) ?? '';  
  if ( !empty($vimeo_id) ) {
    $video_duration = medvoice_vimeo_duration( $vimeo_id );

    $video_duration = $video_duration ? medvoice_seconds_to_hour( $video_duration ) : '';
  }
?>
<li class="side__item">
  <a href="<?= get_permalink( $video_id ); ?>" class="side__link">
    <div class="side__video">
      <?php if ( has_post_thumbnail( $video_id )) : ?>
        <img class="side__img" src="<?= get_the_post_thumbnail_url( $video_id, 'video_side' ); ?>" alt="<?= strip_tags( $title ); ?>">
      <?php endif; ?>

      <div class="side__btn">
        <svg width="14" height="18">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#play"></use>
        </svg>
      </div>
    </div>
    <div class="side__info">
      <h3 class="side__name">
        <?= $short_title; ?>
      </h3>

      <div class="side__about">
          <p class="side__author">
            <?= $author_name; ?>
          </p>

          <p class="side__duration">
            <?= $video_duration; ?>
          </p>
      </div>
    </div>
  </a>
</li>