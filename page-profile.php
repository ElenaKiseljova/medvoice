<?php 
  /**
   * Template Name: Профиль
   * Template Post Type: page
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

<main class="main main--account">
  <section class="account">
    <?php 
      get_template_part( 'templates/profile/tabs' );

      get_template_part( 'templates/profile/tab', 'info' );

      get_template_part( 'templates/profile/tab', 'password' );

      get_template_part( 'templates/profile/tab', 'history' );
    ?>
  </section>
</main>

<?php 
  get_footer(  );
?>