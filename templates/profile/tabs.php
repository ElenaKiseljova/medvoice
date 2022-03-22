<div class="account__head">
  <ul class="account__list">
    <li class="account__item account__item--active">
      <svg class="account__icon" width="20" height="20">
        <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#personal"></use>
      </svg>
      <h2 class="account__title">
        <?= __( 'Персональные данные', 'medvoice' ); ?>
      </h2>
    </li>
    <li class="account__item">
      <svg class="account__icon" width="20" height="20">
        <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#authorization"></use>
      </svg>
      <h2 class="account__title">
        <?= __( 'Даннные авторизации', 'medvoice' ); ?>
      </h2>
    </li>
    <li class="account__item">
      <svg class="account__icon" width="20" height="20">
        <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#pay"></use>
      </svg>
      <h2 class="account__title">
        <?= __( 'История платежей', 'medvoice' ); ?>
      </h2>
    </li>
  </ul>
</div>