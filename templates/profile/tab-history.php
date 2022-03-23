<?php 
  // $user = wp_get_current_user(  );

  // update_metadata( 'user', $user->ID, 'subscribed', '0' );
  // update_metadata( 'user', $user->ID, 'trial', '0' );
  // update_metadata( 'user', $user->ID, '_new_user', '1' );
  // update_metadata( 'user', $user->ID, 'st', time() );

  $subscriptions = medvoice_get_user_subscribe_array() ?? [];

  $subscription_current = medvoice_get_user_subscribe_array( 1 ) ?? [];
?>
<div class="tab">
  <div class="tab__head">
    <div class="tab__title-box">
      <h3 class="tab__title">
        <?= __( 'Текущая подписка:', 'medvoice' ); ?>
        <span class="tab__subtitle">
          <?= $subscription_current['type'] ?? '-'; ?>
        </span>
      </h3>

      <h3 class="tab__title">
        <?= __( 'Дата окончания:', 'medvoice' ); ?>
        <span class="tab__subtitle">
          <?= medvoice_get_user_subscribe_end_date( 'd.m.Y' ); ?> 
        </span>
      </h3>
    </div>

    <a class="button" href="<?= medvoice_get_special_page( 'tariffs', 'url'  ); ?>">
      <?php if ( medvoice_user_have_subscribe_trial() || medvoice_user_have_subscribe() ) : ?>
        <?= __( 'Продлить подписку', 'medvoice' ); ?>
      <?php else : ?>
        <?= __( 'Оформить подписку', 'medvoice' ); ?>
      <?php endif; ?>      
    </a>
  </div>

  <?php if ($subscriptions && is_array($subscriptions) && !empty($subscriptions)) : ?>
    <table class="tab__table">
      <thead>
        <tr>
          <td><?= __( 'Дата транзакции', 'medvoice' ); ?></td>
          <td><?= __( 'Тип подписки', 'medvoice' ); ?></td>
          <td><?= __( 'Сумма', 'medvoice' ); ?></td>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($subscriptions as $key => $subscription) : ?>     
          <tr>
            <td>
              <?= $subscription['date'][0]; ?>
              <span class="tab__time">
                <?= $subscription['date'][1]; ?>
              </span>
            </td>
            <td><?= $subscription['type']; ?></td>
            <td>
              <?= $subscription['price']; ?>           
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>  
</div>