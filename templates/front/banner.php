<?php 
  $title = get_sub_field( 'title' );
?>

<section class="banner" id="banner">
  <h1 class="banner__title">
    <?= $title; ?>
  </h1>
  <?php if ( !is_user_logged_in(  ) ) : ?>
    <form class="banner__form" method="get" action="<?= medvoice_get_special_page( 'forms', 'url' ); ?>">
      <input class="banner__input" type="email" placeholder="Ваш email" name="email" required />
      <input type="hidden" name="action" value="trial">
      <button class="button" type="submit"><?= __( 'Оформить триал', 'medvoice' ); ?></button>
    </form>
  <?php elseif( medvoice_user_have_subscribe() ) : ?>
  <?php else : ?>
    <a class="button" href="<?= medvoice_get_special_page( 'tariffs', 'url' ); ?>"><?= __( 'Оформить подписку', 'medvoice' ); ?></a>
  <?php endif; ?>    
</section>
