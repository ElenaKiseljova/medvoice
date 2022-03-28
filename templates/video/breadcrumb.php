<?php 
  $video_id = get_the_ID(  );

  // Дефолтное значение по которому определяется формат видео для видео без Курса
  $video_format_id = $video_id;

  // Проверка принадлежности видео к Курсу
  $video_parent_id = wp_get_post_parent_id(  );
  if ( $video_parent_id ) {    
    $video_format_id = $video_parent_id;
  }  

  // Формат видео
  $video_format = medvoice_get_single_format_video_arr( $video_format_id, ['name', 'link'], false);

  $video_format_link = '';
  $video_format_name = '';
  if ( $video_format && is_array($video_format) && !is_wp_error( $video_format ) ) {
    $video_format_link = $video_format['link'] ?? '';
    $video_format_name = $video_format['name'] ?? '';
  }
?>

<ul class="lection__breadcrumb">
  <li class="lection__breadcrumb-item">
    <a href="<?= $video_format_link; ?>" class="lection__breadcrumb-link">
      <?= $video_format_name; ?>
    </a>
  </li>

  <?php if ( $video_parent_id ) : ?>
    <li class="lection__breadcrumb-item">
      <a href="<?= get_permalink( $video_parent_id ); ?>" class="lection__breadcrumb-link">
        <?= get_the_title( $video_parent_id ); ?>
      </a>
    </li>
  <?php endif; ?>        
</ul>