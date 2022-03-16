<?php 
  /**
   * Template Name: Формы
   */
?>

<?php 
  get_header( 'forms' );
?>

<main class="main-user">
  <section class="user">
    <div class="user__wrapper">
      <?php 
        get_template_part( 'templates/logo', 'user' );

        get_template_part( 'templates/forms', 'user' );
      ?>        
    </div>
  </section>
</main>

<?php 
  get_footer( 'forms' );
?>