<?php 
  get_header(  );
?>

<main>
  <h1 class="title"><?php the_title(  ); ?></h1>

  <?php the_content(  ); ?>  

  <?php  
    if (isset($_GET['key']) && isset($_GET['order'])) {
      $order_id = (int) $_GET['order'];

      $order = wc_get_order( $order_id );

      $order_data = $order->get_data();

      $order_status = $order_data['status'];

      echo 'Статус заказа: ' . $order_status; 
    }
  ?>
</main>

<?php 
  get_footer(  );
?>