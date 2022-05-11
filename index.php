<?php 
  get_header(  );
?>

<?php  
  // Перенаправление после оплаты WayForPay
  if (isset($_GET['key']) && isset($_GET['order'])) {
    wp_redirect( get_bloginfo( 'url' ) );
  }
?>

<main class="main main--policy">
  <section class="policy">
    <h1 class="policy__title"><?php the_title(  ); ?></h1>
    <p class="policy__update"><?= __( 'Дата останнього оновлення:', 'medvoice' ) . ' ' . get_the_modified_time('d.m.Y'); ?></p>

    <div class="policy__content">
      <?php the_content(  ); ?> 
    </div>
  </section>
</main>

<?php 
  get_footer(  );
?>