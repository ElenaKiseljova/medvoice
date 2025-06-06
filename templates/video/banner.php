<?php 
  global $video_id, $video_children;

  $video_id = get_the_ID(  );

  // Формат видео
  $video_format = medvoice_get_single_format_video_arr( $video_id, ['name'] );

  $video_format_name = '';
  if ( $video_format && is_array($video_format) && !is_wp_error( $video_format ) ) {
    $video_format_name = empty($video_format['name']) ? __( 'Курс', 'medvoice' ) : $video_format['name'];
  }

  // Кол-во дочерних страниц
  $video_children_count = 0;
  if ( isset($video_children) && !empty($video_children) ) {
    $video_children_count = count($video_children);
  }
?>
<section class="banner banner--course" id="banner">
  <div class="banner__head">
    <div class="banner__box">
      <ul class="banner__about">
        <li class="banner__about-item">
          <?= $video_format_name; ?>
        </li>
        <li class="banner__about-item">
          <?=
              medvoice_pluralize($video_children_count, __('лекция', 'medvoice'), __('лекции', 'medvoice'),
                      __('лекций', 'medvoice'))
          ?>
        </li>
      </ul>

      <?php 
        get_template_part( 'templates/bookmarks' );
      ?>
    </div>

    <h1 class="banner__name">
      <?= get_the_title(  ); ?>
    </h1>
  </div>

  <ul class="banner__list">
    <li class="banner__item active">
      <?= __( 'Список лекций', 'medvoice' ); ?>
    </li>
    <li class="banner__item">
      <?= __( 'Описание курса', 'medvoice' ); ?>
    </li>
  </ul>
</section>