<?php 
  /**
   * Template Name: Тарифы
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

  $title = get_field( 'title' ) ?? '';

  $tariffs = get_field( 'tariffs' ) ?? [];

  $args = array(
    'include' => $tariffs,
    'orderby' => 'menu_order',
    'order' => 'ASC'
  );

  $tariffs = wc_get_products( $args );
?>

<main class="main-tariff">
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
              <div class="tariff-card <?= $key === 0 ? 'active' : ''; ?>" data-product-id="<?= $tariff->get_id(); ?>" data-months="<?= (int) $tariff->name; ?>">
                <div class="tariff-card__head">
                  <h2 class="tariff-card__duration">
                    <?= $tariff->name; ?>
                  </h2>
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

          <p id="ajax-response"></p>
        <?php endif; ?>
      </form>
    <?php endif; ?>  
  </section>
</main>

<?php 
  get_footer( 'empty' );
?>