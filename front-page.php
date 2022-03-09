<?php 
  get_header(  );
?>

<main style="text-align:center;">
  <h1 class="title"><?php the_title(  ); ?></h1>

  <?php the_content(  ); ?>

  <address>
    Валюта по геолокации: <?= medvoice_get_currency_code(); ?>
  </address>

  <div>
    20 грн в валюте геолокации: <?=  medvoice_get_converted_price(20); ?>
  </div>  

  <style>
    .active {
      border: 1px dashed gray;
    }
  </style>

  <?php if ( is_user_logged_in(  ) ) : ?>
    <form class="form" id="subscription" style="text-align:center;">
      <?php 
        $args = [
          'virtual' => true
        ];

        $tariffs = wc_get_products( $args );
      ?>
      <?php if ($tariffs && !empty($tariffs) && !is_wp_error( $tariffs )) : ?>
        <ul class="list" style="display:flex;justify-content:space-around;">
          <?php foreach ($tariffs as $key => $tariff) : ?>
            <li class="list__item <?= $key === 0 ? 'active' : ''; ?>" data-product-id="<?= $tariff->get_id(); ?>">
              <h3>
                <?= $tariff->name; ?>
              </h3>
              <p>
                <?= medvoice_get_price_text( medvoice_get_currency_code(), medvoice_get_converted_price( $tariff->price ) ); ?>
              </p>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <input type="hidden" name="product_id">
      
      <input type="hidden" name="security" value="<?= wp_create_nonce( 'medvoice_ajax_subscribe' ); ?>">

      <button>
        Перейти к оплате
      </button>

      <p id="ajax-response"></p>
    </form>
  <?php endif; ?>  
</main>

<?php 
  get_footer(  );
?>