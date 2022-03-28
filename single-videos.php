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

  // Проверка наличия дочерних Видео (если есть, то это - Курс)
  global $video_arr, $video_have_children;
  
  $args = array(
    'post_parent' => $video_id,
    'post_type' => 'videos',
    'orderby' => 'menu_order',
  );

  $video_children = get_children( $args );

  $video_have_children = isset($video_children) && !empty($video_children);

  // Присваиваю глобальной переменной массив с видео
  $video_arr = $video_children;
?>

<?php 
  get_header(  );
?>

<main class="main <?= $video_have_children ? '' : 'main--lection'; ?>">
  <?php 
    if ( $video_have_children ) {
      get_template_part( 'templates/video/banner' );

      get_template_part( 'templates/video/course' );
    } else {
      get_template_part( 'templates/video/lection' );

      get_template_part( 'templates/video/side' );
    }
  ?>  
</main>

<?php 
  get_footer(  );
?>