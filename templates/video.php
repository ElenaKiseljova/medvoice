<?php 
  global $video;

  $video_id = null;

  // Если не пост
  if ( $video instanceof WP_Post ) {
    $video_id = $video->ID ?? null;
  } else {
    return;
  }    

  // Если ИД нет
  if ( is_null($video_id) ) {
    return;
  }

  // Проперка подписки пользователя  
  $video_block = true;
  if ( medvoice_user_have_subscribe_trial() || medvoice_user_have_subscribe() ) {
    $video_block = false;
  }

  // Проверка залогиненности
  $video_bookmarks_block = true;
  if ( is_user_logged_in(  ) ) {
    $video_bookmarks_block = false;
  }

  // Формат Видео
  $video_format = '';
  $video_format_terms = wp_get_post_terms( $video_id, 'format', ['names']) ?? [];
  $video_format_term = ( !is_wp_error( $video_format_terms ) && !empty($video_format_terms) ) ? $video_format_terms[0] : null;

  if ( $video_format_term instanceof WP_Term ) {
    $video_format = $video_format_term->name;
  }

  // Проверка наличия дочерних Видео (если есть, то это - Курс)
  $args = array(
    'post_parent' => $video_id,
  );

  $video_children = get_children( $args );

  if ( !empty($video_children) && $video_format === '' ) {
    $video_format = __( 'Курс', 'medvoice' );
  }
?>

<a href="<?= get_permalink( $video_id ); ?>" class="swiper-slide card <?= $video_block ? 'card--block' : ''; ?>">
  <div class="card__link-box">
    <?php if ( has_post_thumbnail( $video_id )) : ?>
      <img class="card__img" src="<?= get_the_post_thumbnail_url( $video_id, 'video_card' ); ?>" alt="<?= strip_tags( get_the_title( $video_id ) ); ?>">
    <?php endif; ?>
    
    <div class="card__btn">  
      <?php if ( $video_block ) : ?>
        <svg aria-labelledby="<?= __( 'Заблокировано', 'medvoice' ); ?>" width="22" height="27">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#block"></use>            
        </svg>
      <?php else : ?>
        <svg aria-labelledby="<?= __( 'Смотреть', 'medvoice' ); ?>" width="17" height="20">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#play"></use>            
        </svg>
      <?php endif; ?>  
    </div>
  </div>

  <div class="card__info">
    <h3 class="card__title">
      <?= get_the_title( $video_id ); ?>
    </h3>

    <div class="card__description">
      <div class="card__description-box">
        <p class="card__description-name">
          <?= $video_format; ?>
        </p>

        <?php if ( !empty($video_children) ) : ?>
          <p class="card__description-text">            
            <?=
              $video_children_count = count($video_children);
              
              medvoice_pluralize($video_children_count, __('лекция', 'medvoice'), __('лекции', 'medvoice'),
                      __('лекций', 'medvoice'))
            ?>
          </p>
        <?php endif; ?>        
      </div>

      <button class="card__description-link <?= $video_bookmarks_block ? 'card__description-link--block' : ''; ?>">
        <svg aria-labelledby="<?= __( 'Добавить в закладки', 'medvoice' ); ?>" width="16" height="20">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#bookmarks-2"></use>            
        </svg>
      </button>
    </div>
  </div>
</a>