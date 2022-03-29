
<?php 
  /**
   * Template Name: Каталог
   */
?>

<?php 
  get_header(  );
?>

<main class="main">
  <?php 
    get_template_part( 'templates/archive/banner' );

    get_template_part( 'templates/catalog' );
  ?>
</main>

<?php 
  get_footer(  );
?>