<?php 
  /**
   * Template Name: Тарифы
   * Template Post Type: page
   */
?>

<?php 
  get_header( 'empty' );
?>

<?php 
  if ( !is_user_logged_in(  ) ) {
    wp_redirect( medvoice_get_special_page( 'forms', 'id'  ) . '?action=login' );

    exit();
  }
?>

<main class="main-tariff">
  <?php 
    get_template_part( 'templates/tariffs' );
  ?>
</main>

<?php 
  get_footer( 'empty' );
?>