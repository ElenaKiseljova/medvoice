<?php 
  $video_id = get_the_ID(  );

  // Нет ИД
  if ( !isset($video_id) ) {
    wp_redirect( get_home_url(  ) );

    exit();
  }

  // Нет подписки/Нет логирования  и не бесплатно 
  if ( !medvoice_is_free_video( $video_id  ) && (!is_user_logged_in(  ) || (!medvoice_user_have_subscribe_trial() && !medvoice_user_have_subscribe())) ) {
    wp_redirect( get_home_url(  ) );

    exit();
  }

  // Формат Видео
  global $video_format;

  $video_format = '';
  $video_format_terms = wp_get_post_terms( $video_id, 'format', ['fields' => 'names']) ?? [];
  $video_format = ( !is_wp_error( $video_format_terms ) && !empty($video_format_terms) ) ? $video_format_terms[0] : null;


  // Проверка наличия дочерних Видео (если есть, то это - Курс)
  global $video_children;
  
  $args = array(
    'post_parent' => $video_id,
    'post_type' => 'videos',
  );

  $video_children = get_children( $args );
?>

<?php 
  get_header(  );
?>

<main class="main">
  <?php 
    if ( isset($video_children) && !empty($video_children) ) {
      get_template_part( 'templates/video/banner' );

      get_template_part( 'templates/video/course' );
    }
  ?>  
</main>

<?php 
  get_footer(  );
?>