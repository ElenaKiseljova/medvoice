<?php 
  global $video_id;

  if ( !isset($video_id) || is_wp_error( $video_id )) {
    return;
  }

  // Сохранено ли в закладки Видео
  $video_bookmarks_saved = false;

  // Проверка залогиненности
  $video_bookmarks_block = true;
  if ( is_user_logged_in(  ) ) {
    $video_bookmarks_block = false;

    // Получение закладок пользователя
    $video_bookmarks_user = medvoice_get_user_bookmarks();
    if ( in_array($video_id, $video_bookmarks_user) ) {
      $video_bookmarks_saved = true;
    }
  }
?>
<button data-video-id="<?= $video_id; ?>" class="bookmarks <?= $video_bookmarks_saved ? 'saved' : ''; ?> <?= $video_bookmarks_block ? 'bookmarks--block' : ''; ?>">
  <svg aria-labelledby="<?= __( 'Добавить в закладки', 'medvoice' ); ?>" width="16" height="20">
    <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#bookmark-2"></use>            
  </svg>
</button>