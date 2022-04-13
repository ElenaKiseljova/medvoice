<?php 
  /**
   * Template Name: Формы
   * Template Post Type: page
   */
?>

<?php 
  if ( !isset($_GET['action']) || is_user_logged_in(  ) ) {
    wp_redirect( get_home_url(  ) );

    exit();
  }
?>

<?php 
  get_header( 'empty' );
?>

<main class="main main--user">
  <section class="user">
    <div class="user__wrapper">
      <?php medvoice_get_logo_html( 'user' ); ?>

      <?php 
        get_template_part( 'templates/forms', 'user' );
      ?>        
    </div>
  </section>
</main>

<?php 
  get_footer( 'empty' );
?>