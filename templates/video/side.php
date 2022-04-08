<?php 
  global $video;

  $video_id = get_the_ID(  );

  // Дефолтное значение по которому определяется формат видео для видео без Курса
  $video_format_id = $video_id;

  // Список видео
  $video_side = [];

  $video_title = '';

  // Проверка принадлежности видео Курсу
  $video_parent_id = wp_get_post_parent_id(  );
  if ( $video_parent_id ) {
    $video_format_id = $video_parent_id;

    $args = array(
      'post_parent' => $video_parent_id,
      'post_type' => 'videos',
      'exclude' => $video_id,
    );
  
    $video_children = get_children( $args );

    $video_side = $video_children;

    // Формат видео
    $video_format = medvoice_get_single_format_video_arr( $video_format_id, ['name'] );

    $video_format_name = '';
    if ( $video_format && is_array($video_format) && !is_wp_error( $video_format ) ) {
      $video_format_name = empty($video_format['name']) ? __( 'Курс', 'medvoice' ) : $video_format['name'];

      $video_title = $video_format_name . ' “' . get_the_title( $video_parent_id ) . '”';
    }
  } else {
    $video_recommendations = get_field( 'recommendations' ) ?? [];

    $video_side = $video_recommendations;

    $video_title = __( 'Рекомендуем к просмотру', 'medvoice' );
  } 
?>

<section class="side">
  <h2 class="side__title">
    <?= $video_title; ?>
  </h2>

  <div class="side__body swiper swiper-side">
    <div class="side__block swiper-wrapper">
      <ul class="side__list swiper-slide">
        <?php foreach ($video_side as $key => $video_side_item) : ?>
          <?php 
            $video = $video_side_item;  

            get_template_part( 'templates/card', 'side' );
          ?>    
        <?php endforeach; ?>  
      </ul>
    </div>
    <div class="scrollbar">
      <div class="scrollbar__drag"></div>
    </div>
  </div>
</section>