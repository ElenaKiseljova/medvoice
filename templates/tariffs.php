<?php 
  $title = get_field( 'title' ) ?? '';

  $tariffs = get_field( 'tariffs' ) ?? [];
?>

<section class="tariff">
    <?php if ( is_user_logged_in(  ) ) : ?>
      <form class="tariff__wrapper" id="subscription">
        <?php medvoice_get_logo_html( 'tariff' ); ?>

        <h1 class="tariff__title">
          <?= $title ; ?>
        </h1>

        <?php if ($tariffs && !empty($tariffs) && !is_wp_error( $tariffs )) : ?>
          <div class="tariff__cards">
            <?php foreach ($tariffs as $key => $tariff) : ?>
              <?php 
                $discount = 0;

                $tariff = wc_get_product( $tariff ); 

                if ( $tariff instanceof WC_Product ) {
                  $discount = get_field( 'discount', $tariff->get_id() );
                } else {
                  break;
                }
              ?>
              <div class="tariff-card" data-product-id="<?= $tariff->get_id(); ?>" data-months="<?= (int) $tariff->name; ?>">
                <div class="tariff-card__head">
                  <h2 class="tariff-card__duration">
                    <?= $tariff->name; ?>
                  </h2>

                  <?php if ( $discount > 0 ) : ?>
                    <div class="tariff-card__discount">                    
                      <?= __( 'Скидка', 'medvoice' ) . ' ' . $discount . '%'; ?>
                    </div>
                  <?php endif; ?>                  
                </div>

                <div class="tariff-card__price tariff-card__price--<?= medvoice_get_price_side( ); ?>">
                  <p class="tariff-card__number">
                    <?= medvoice_get_converted_price( $tariff->get_price() ); ?>
                  </p>
                  <p class="tariff-card__currency tariff-card__currency--<?= medvoice_get_price_side( medvoice_get_currency_code() ); ?>">
                    <?= medvoice_get_currency_code_text(  ); ?>
                  </p>
                </div>

                <button class="button tariff-card__button">
                  <?= __( 'Выбрать', 'medvoice' ); ?>
                </button>
              </div>
            <?php endforeach; ?>            
          </div>

          <input type="hidden" name="product_id">
          <input type="hidden" name="months">          

          <button class="button tariff__button" type="submit">
            <?= __( 'Перейти к оплате', 'medvoice' ); ?>
          </button>         

          <div class="text text--ajax text--right" id="ajax-response"></div>
        <?php endif; ?>
      </form>
    <?php endif; ?>  
  </section>