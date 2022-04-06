<?php 
  global $video, $video_id, $place;

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

  // Длительность Видео  
  $video_duration = '';

  // Формат видео
  $video_format = medvoice_get_single_format_video_arr( $video_id, ['name'] );

  $video_format_name = '';
  if ( $video_format && is_array($video_format) && !is_wp_error( $video_format ) ) {
    $video_format_name = $video_format['name'] ?? '';
  }

  // Проверка наличия дочерних Видео (если есть, то это - Курс)
  $video_children_count = 0;

  $args = [
    'post_parent' => $video_id,
    'post_type' => 'videos',
  ];

  $video_children = get_children( $args );

  $video_have_children = isset($video_children) && !empty($video_children);

  if ( $video_have_children ) {
    if (empty($video_format_name)) {
      $video_format_name = __( 'Курс', 'medvoice' );
    }    

    $video_children_count = count($video_children);
  } else {
    if (empty($video_format_name)) {
      $video_format_name = __( 'Лекция', 'medvoice' );
    } 

    $vimeo_id = get_field( 'vimeo_id', $video_id ) ?? '';  

    if ( !empty($vimeo_id) ) {
      $video_duration = medvoice_vimeo_duration( $vimeo_id );

      $video_duration = $video_duration ? medvoice_seconds_to_hour( $video_duration ) : '';
    }
  }

  // Класс для карточки
  $video_class = 'swiper-slide';  
  if ( $place === 'list') {
    $video_class = 'card--search';
  }
?>

<a href="<?= get_permalink( $video_id ); ?>" class="<?= $video_class; ?> card <?= $video_block ? 'card--block' : ''; ?>">
  <div class="card__link-box">
    <?php if ( has_post_thumbnail( $video_id )) : ?>
      <img class="card__img" src="<?= get_the_post_thumbnail_url( $video_id, 'video_card' ); ?>" alt="<?= strip_tags( get_the_title( $video_id ) ); ?>">
    <?php endif; ?>
    
    <div class="card__btn <?= $video_block ? 'card__btn--lock' : ''; ?>">  
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
          <?= $video_format_name; ?>
        </p>

        <p class="card__description-text">      
          <?php if ( !empty($video_children) ) : ?>
            <?=
              medvoice_pluralize($video_children_count, __('лекция', 'medvoice'), __('лекции', 'medvoice'),
                      __('лекций', 'medvoice'));
            ?>
          <?php else : ?>
            <?= $video_duration; ?>
          <?php endif; ?> 
        </p>              
      </div>

      <?php 
        get_template_part( 'templates/bookmarks' );
      ?>
    </div>
  </div>
</a>