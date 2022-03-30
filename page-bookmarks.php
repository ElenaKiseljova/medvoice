<?php 
  /**
   * Template Name: Закладки
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

<main class="main">
  <?php 
    get_template_part( 'templates/catalog' );
  ?>
</main>

<?php 
  get_footer(  );
?>