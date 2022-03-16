<?php 
  $email = get_field( 'email', 'options' );
  $phone = get_field( 'phone', 'options' );
?>
<?php if ($email && !empty($email['text']) && !empty($email['link'])) : ?>
  <a class="social__mail-link" href="<?= $email['link']; ?>"><?= $email['text']; ?></a>
<?php endif; ?>

<?php if ($phone && !empty($phone['text']) && !empty($phone['link'])) : ?>
  <a class="social__phone-link" href="<?= $phone['link']; ?>"><?= $phone['text']; ?></a>
<?php endif; ?>

