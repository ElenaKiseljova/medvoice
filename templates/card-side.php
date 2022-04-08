<?php 
  global $video;

  $video_id = null;

  // Если не пост
  if ( !is_a( $video, 'WP_Post' ) ) {
    return;
  }    
  $video_id = $video->ID ?? null;

  // Если ИД нет
  if ( is_null($video_id) ) {
    return;
  }  

  $video_block = true;  
  
  // Проверка подписки пользователя    
  if ( medvoice_user_have_subscribe_trial() || medvoice_user_have_subscribe() ) {
    $video_block = false;
  }

  // Проверка на бесплатность видео
  if ( medvoice_is_free_video( $video_id ) ) {
    $video_block = false;
  }

  $author_name = '';

  $authors = wp_get_post_terms( $video_id, 'authors' ) ?? [];

  if ( !empty($authors) ) {
    $author = $authors[0];

    if ( is_a( $author, 'WP_Term' ) ) {
      $author_name = $author->name;
    }
  }

  $title = get_the_title( $video_id );
  $short_title = mb_substr($title, 0, 30) . '...';

  $video_duration = medvoice_get_vimeo_duration( $video_id ) ?? '';
?>
<li class="side__item">
  <a href="<?= get_permalink( $video_id ); ?>" class="side__link <?= $video_block ? 'side__link--block' : ''; ?>">
    <div class="side__video">
      <?php if ( has_post_thumbnail( $video_id )) : ?>
        <img class="side__img" src="<?= get_the_post_thumbnail_url( $video_id, 'video_side' ); ?>" alt="<?= strip_tags( $title ); ?>">
      <?php endif; ?>

      <div class="side__btn <?= $video_block ? 'side__btn--lock' : ''; ?>">
        <?php if ( $video_block ) : ?>
          <svg aria-labelledby="<?= __( 'Заблокировано', 'medvoice' ); ?>" width="20" height="25">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#block"></use>            
          </svg>
        <?php else : ?>
          <svg aria-labelledby="<?= __( 'Смотреть', 'medvoice' ); ?>" width="14" height="18">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#play"></use>            
          </svg>
        <?php endif; ?> 
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