<?php 
  /**
   * Template Name: Профиль
   */
?>

<?php 
  get_header(  );
?>

<?php 
  if ( !is_user_logged_in(  ) ) {
    wp_redirect( medvoice_get_special_page( 'forms', 'id'  ) . '?action=login' );

    exit();
  }
?>

<main class="main">  
  <h1 class="banner__title">
    <?= get_the_title(  ); ?>
  </h1>
</main>

<?php 
  get_footer(  );
?>