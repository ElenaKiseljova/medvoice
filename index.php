<?php 
  get_header(  );
?>

<?php  
  // Перенаправление после оплаты WayForPay
  if (isset($_GET['key']) && isset($_GET['order'])) {
    wp_redirect( get_bloginfo( 'url' ) );
  }
?>

<main>
  <h1 class="title"><?php the_title(  ); ?></h1>

  <?php the_content(  ); ?>  
  
</main>

<?php 
  get_footer(  );
?>