<?php 
  get_header(  );
?>

<main>
  <h1 class="title"><?php the_title(  ); ?></h1>

  <?php the_content(  ); ?>

  <address>
    <?= medvoice_get_currency_code(); ?>
  </address>

  <div>
    <?=  medvoice_get_converted_price(20); ?>
  </div>

  <?php 
    $tariffs = get_field( 'subscriptions', 'options' );
  ?>
  <form class="form"">

    <?php if ($tariffs && !empty($tariffs) && !is_wp_error( $tariffs )) : ?>
      <ul class="list">
        <?php foreach ($tariffs as $key => $tariff) : ?>
          <li class="list__item <?= $key === 0 ? 'active' : ''; ?>">
            <h3>
              <?= $tariff['title']; ?>
            </h3>
            <p><?= $tariff['price']; ?></p> грн
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <input type="hidden" name="title">
    <input type="hidden" name="price">
    <input type="hidden" name="currency" value="<?= medvoice_get_currency_code(); ?>">
    
    <?php 
      $med_user = wp_get_current_user(  );
    ?>
    <?php if ($med_user && ($med_user instanceof WP_User)) : ?>
      <input type="hidden" name="user_email" value="<?= $med_user->user_email; ?>">
      <input type="hidden" name="user_id" value="<?= $med_user->ID; ?>">
      <input type="hidden" name="nickname" value="<?= $med_user->nickname; ?>">

      
    <?php endif; ?>    
    
    <button>
      Перейти к оплате
    </button>

    <p id="ajax-response"></p>
  </form>
  

  <form method="post" action="https://secure.wayforpay.com/pay" accept-charset="utf-8" id="subscription">
    <input type="hidden" name="merchantAccount" value="test_merch_n1">
    <input type="hidden" name="merchantAuthType" value="SimpleSignature">
    <input type="hidden" name="merchantDomainName" value="<?= $_SERVER['SERVER_NAME']; ?>">

    <input type="hidden" name="orderReference" value="DH<?= time(); ?>">
    <input type="hidden" name="orderDate" value="<?= strtotime( date('d-m-y') ); ?>">

    <input type="hidden" name="amount" value="1">

    <input type="hidden" name="currency" value="UAH">

    <input type="hidden" name="orderTimeout" value="49000">

    <input type="hidden" name="productName[]" value="Тариф 1">
    <input type="hidden" name="productPrice[]" value="1">
    <input type="hidden" name="productCount[]" value="1">

    <input type="hidden" name="clientFirstName" value="Елена">
    <input type="hidden" name="clientLastName" value="Киселева">
    
    <input type="hidden" name="clientEmail" value="e.a.kiseljova@gmail.com">
    <input type="hidden" name="defaultPaymentSystem" value="card">

    <input type="hidden" name="merchantSignature" value="">
    <p>nhf nf nf</p>
    <input type="submit" value="Test">
  </form>
</main>

<?php 
  get_footer(  );
?>