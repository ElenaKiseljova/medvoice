<div class="tab">
  <form class="tab__form form" id="editpassword">
    <div class="form__wrapper">
      <div class="form__content form__content--account">
        <p class="form__row">
          <label class="form__label" for="password-old"><?= __( 'Старый пароль', 'medvoice' ); ?></label>
          <input class="form__field" type="password" name="password-old" id="password-old" >
        </p>

        <p class="form__row">
          <label class="form__label" for="password-confirm"><?= __( 'Повторить пароль', 'medvoice' ); ?></label>
          <input class="form__field" type="password" name="password-confirm" id="password-confirm" >
        </p>
      </div>

      <div class="form__content form__content--account">
        <p class="form__row">
          <label class="form__label" for="password"><?= __( 'Новый пароль', 'medvoice' ); ?></label>
          <input class="form__field" type="password" name="password" id="password" >
        </p>
      </div>
    </div>

    <button class="form__button form__button--tab button">
      <?= __( 'Изменить пароль', 'medvoice' ); ?>
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