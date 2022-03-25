<?php 
  global $video_children, $video_format;

  // Формат видео
  $video_format = isset($video_format) && !empty($video_format) ? $video_format : __( 'Курс', 'medvoice' );

  // Кол-во дочерних страниц
  $video_children_count = 0;
  if ( isset($video_children) && !empty($video_children) ) {
    $video_children_count = count($video_children);
  }

  // Проверка залогиненности
  $video_bookmarks_block = true;
  if ( is_user_logged_in(  ) ) {
    $video_bookmarks_block = false;
  }
?>
<section class="banner banner--course" id="banner">
  <div class="banner__head">
    <div class="banner__box">
      <ul class="banner__about">
        <li class="banner__about-item">
          <?= $video_format ; ?>
        </li>
        <li class="banner__about-item">
          <?=
              medvoice_pluralize($video_children_count, __('лекция', 'medvoice'), __('лекции', 'medvoice'),
                      __('лекций', 'medvoice'))
          ?>
        </li>
      </ul>

      <button class="bookmarks <?= $video_bookmarks_block ? 'bookmarks--block' : ''; ?>">
        <svg aria-labelledby="<?= __( 'Добавить в закладки', 'medvoice' ); ?>" width="16" height="20">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#bookmark-2"></use>            
        </svg>
      </button>
    </div>

    <h1 class="banner__name">
      <?= get_the_title(  ); ?>
    </h1>
  </div>

  <ul class="banner__list">
    <li class="banner__item banner__item--active">
      <?= __( 'Список лекций', 'medvoice' ); ?>
    </li>
    <li class="banner__item">
      <?= __( 'Описание курса', 'medvoice' ); ?>
    </li>
  </ul>
</section>