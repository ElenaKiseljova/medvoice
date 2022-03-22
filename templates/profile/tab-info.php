<?php 
  $medvoice_user = wp_get_current_user(  );
  
  if ( $medvoice_user instanceof WP_User ) {
    $medvoice_user_first_name = $medvoice_user->first_name ?? '';
    $medvoice_user_last_name = $medvoice_user->last_name ?? '';
    $medvoice_user_email = $medvoice_user->user_email ?? '';

    // Получаю регион пользователя
    $medvoice_user_city = $medvoice_user->get( 'billing_city' ) ?? '';

    // Получаем код страны пользователя
    $medvoice_user_country = $medvoice_user->get( 'billing_country' ) ?? '';
    
    // Получаем список стран из WC
    $countries = [];
    if ( class_exists( 'WC_Countries' ) ) {
      $WC_Countries = new WC_Countries();
      $countries = $WC_Countries->get_countries();
    } 

    // Получаем список всех специализаций
    $specializations = get_site_option( 'specializations' ) ?? [];

    // Получаем специализацию пользователя
    $specialization = $medvoice_user->get( 'specialization' );    
  } else {
    return;
  }  
?>
<div class="tab tab--active">
  <form class="tab__form tab__form--locked form" id="editinfo">
    <div class="form__wrapper">
      <div class="form__avatar">
        <div class="form__avatar-box">
          <?php if ( medvoice_have_user_avatar(  ) ) : ?>
            <img class="form__avatar-img" src="<?= medvoice_get_user_avatar(  ); ?>" alt="<?= $medvoice_user->nickname; ?>">
          <?php else : ?>
            <img class="form__avatar-img" src="<?= get_template_directory_uri(  ); ?>/assets/img/avatar-default.svg" alt="<?= $medvoice_user->nickname; ?>">
          <?php endif; ?>          
        </div>
        <p class="form__row hidden">
          <label class="form__upload" for="avatar"></label>
          <input type="file" id="avatar" name="avatar" hidden>
        </p>
      </div>

      <div class="form__content form__content--account">
        <p class="form__row">
          <label class="form__label" for="first_name"><?= __( 'Имя', 'medvoice' ); ?></label>
          <input class="form__field" type="text" name="first_name" id="first_name" placeholder="<?= __( 'Введите ваше имя', 'medvoice' ); ?>"
            value="<?= $medvoice_user_first_name; ?>" >
        </p>

        <p class="form__row">
          <label class="form__label" for="last_name"><?= __( 'Фамилия', 'medvoice' ); ?></label>
          <input class="form__field" type="text" name="last_name" id="last_name"
            placeholder="<?= __( 'Введите вашу фамилию', 'medvoice' ); ?>" value="<?= $medvoice_user_last_name; ?>" >
        </p>

        <p class="form__row">
          <label class="form__label" for="user_email"><?= __( 'Email', 'medvoice' ); ?></label>
          <input class="form__field" type="text" name="user_email" id="user_email" placeholder="<?= __( 'Введите вашу почту', 'medvoice' ); ?>"
            value="<?= $medvoice_user_email; ?>" >
        </p>
      </div>

      <div class="form__content form__content--account">
        <p class="form__row">
          <label class="form__label" for="specialization"><?= __( 'Специальность', 'medvoice' ); ?></label>
          <!-- <input class="form__field" type="text" name="nickname" id="nickname"
            placeholder="<?= __( 'Выберите специальность', 'medvoice' ); ?>" value="Хирург" > -->
          <select class="form__field" name="specialization" id="specialization">
            <?php if (isset($specialization) && empty($specialization)) : ?>
              <option value="0" selected>
                <?= __( 'Выберите специальность', 'medvoice' ); ?>
              </option>
            <?php endif; ?>
            <?php foreach ($specializations as $key => $item) : ?>
              <option value="<?= $item['value']; ?>" <?php selected( $specialization, $item['value'] ) ?>>
                <?= $item['label']; ?>
              </option>
            <?php endforeach; ?>            
          </select>
        </p>

        <p class="form__row">
          <label class="form__label" for="billing_country"><?= __( 'Страна', 'medvoice' ); ?></label>
          <!-- <input class="form__field" type="text" name="surname" id="surname" placeholder="<?= __( 'Укажите свою страну', 'medvoice' ); ?>"
            value="Украина" > -->
          <select class="form__field" name="billing_country" id="billing_country">
            <?php if ($medvoice_user_country && empty($medvoice_user_country)) : ?>
              <option value="0" selected>
                <?= __( 'Укажите свою страну', 'medvoice' ); ?>
              </option>
            <?php endif; ?>
            <?php foreach ($countries as $key => $country) : ?>
              <option value="<?= $key; ?>" <?php selected( $medvoice_user_country, $key ) ?>>
                <?= $country; ?>
              </option>
            <?php endforeach; ?>            
          </select>
        </p>

        <p class="form__row">
          <label class="form__label" for="billing_city"><?= __( 'Регион', 'medvoice' ); ?></label>
          <input class="form__field" type="text" name="billing_city" id="billing_city" placeholder="<?= __( 'Укажите свой город', 'medvoice' ); ?>"
            value="<?= $medvoice_user_city; ?>" >
        </p>
      </div>
    </div>

    <button class="form__button form__button--tab button">
      <?= __( 'Редактировать профиль', 'medvoice' ); ?>
    </button>
    <div class="form__button-box hidden">
      <button class="button button--cancel">
        <?= __( 'Отменить', 'medvoice' ); ?>
      </button>
      <button class="button button--save" type="submit">
        <?= __( 'Сохранить', 'medvoice' ); ?>
      </button>
    </div>

    <div class="text text--ajax" id="ajax-response"></div>
  </form>
</div>