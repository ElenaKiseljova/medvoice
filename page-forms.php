<?php 
  /**
   * Template Name: Формы
   */
?>

<?php 
  get_header( 'empty' );
?>

<main class="main-user">
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