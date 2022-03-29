<div class="catalog__filter hidden">
  <form class="form form--filter" action="">
    <div class="form__row">
      <input type="search" class="dropdown__field" placeholder="Поиск...">
    </div>

    <div class="form__row">
      <div class="dropdown">
        <div class="dropdown__header">
          <span class="dropdown__name">Категория</span>
          <svg class="dropdown__icon" width="12" height="8">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
          </svg>
        </div>

        <ul class="dropdown__body">
          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-01" name="value-01">
            <label class="dropdown__label" for="value-01">Хирургия</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-02" name="value-02">
            <label class="dropdown__label" for="value-02">Неврология</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-03" name="value-03">
            <label class="dropdown__label" for="value-03">Дерматология</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-04" name="value-04">
            <label class="dropdown__label" for="value-04">Стоматология</label>
          </li>
        </ul>
      </div>
    </div>

    <div class="form__row">
      <div class="dropdown">
        <div class="dropdown__header">
          <span class="dropdown__name">Подкатегория</span>
          <svg class="dropdown__icon" width="12" height="8">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
          </svg>
        </div>

        <ul class="dropdown__body">
          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-05" name="value-05">
            <label class="dropdown__label" for="value-05">Детская стоматология</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-06" name="value-06">
            <label class="dropdown__label" for="value-06">Взрослая стоматология</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-07" name="value-07">
            <label class="dropdown__label" for="value-07">Нейрохирургия</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-08" name="value-08">
            <label class="dropdown__label" for="value-08">Пластическая хирургия</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-09" name="value-09">
            <label class="dropdown__label" for="value-09">Долгожители</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-10" name="value-10">
            <label class="dropdown__label" for="value-10">Генетика детей</label>
          </li>
        </ul>
      </div>
    </div>

    <div class="form__row">
      <div class="dropdown">
        <div class="dropdown__header">
          <span class="dropdown__name">Лекции</span>
          <svg class="dropdown__icon" width="12" height="8">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
          </svg>
        </div>

        <ul class="dropdown__body">
          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-11" name="value-11">
            <label class="dropdown__label" for="value-11">Лекция 1</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-12" name="value-12">
            <label class="dropdown__label" for="value-12">Лекция 2</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-13" name="value-13">
            <label class="dropdown__label" for="value-13">Лекция 3</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-14" name="value-14">
            <label class="dropdown__label" for="value-14">Лекция 4</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-15" name="value-15">
            <label class="dropdown__label" for="value-15">Лекция 5</label>
          </li>
        </ul>
      </div>
    </div>

    <div class="form__row">
      <div class="dropdown">
        <div class="dropdown__header">
          <span class="dropdown__name">Автор</span>
          <svg class="dropdown__icon" width="12" height="8">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
          </svg>
        </div>

        <ul class="dropdown__body">
          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-16" name="value-16">
            <label class="dropdown__label" for="value-16">Иван Иванов</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-17" name="value-17">
            <label class="dropdown__label" for="value-17">Джон Доу</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-18" name="value-18">
            <label class="dropdown__label" for="value-18">Доктор Комаровский</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-19" name="value-19">
            <label class="dropdown__label" for="value-19">Ульяна Супрун</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-20" name="value-20">
            <label class="dropdown__label" for="value-20">Альберт Швейцер</label>
          </li>
        </ul>
      </div>
    </div>

    <div class="form__row">
      <div class="dropdown">
        <div class="dropdown__header">
          <span class="dropdown__name">Теги проблематики</span>
          <svg class="dropdown__icon" width="12" height="8">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
          </svg>
        </div>

        <ul class="dropdown__body">
          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-21" name="value-21">
            <label class="dropdown__label" for="value-21">Вирус</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-22" name="value-22">
            <label class="dropdown__label" for="value-22">Инфекция</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-23" name="value-23">
            <label class="dropdown__label" for="value-23">Перелом</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-24" name="value-24">
            <label class="dropdown__label" for="value-24">ОРВИ</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-25" name="value-25">
            <label class="dropdown__label" for="value-25">Пандемия</label>
          </li>
        </ul>
      </div>
    </div>

    <div class="form__row">
      <div class="dropdown">
        <div class="dropdown__header">
          <span class="dropdown__name">Языки</span>
          <svg class="dropdown__icon" width="12" height="8">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
          </svg>
        </div>

        <ul class="dropdown__body">
          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-31" name="value-31">
            <label class="dropdown__label" for="value-31">Украинский</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-32" name="value-32">
            <label class="dropdown__label" for="value-32">English</label>
          </li>

          <li class="dropdown__item">
            <input class="dropdown__check" class="" type="checkbox" id="value-33" name="value-33">
            <label class="dropdown__label" for="value-33">Deutch</label>
          </li>
        </ul>
      </div>
    </div>

    <div class="form__button-box form__button-box--filter">
      <button class="button button--reset">
        Сбросить
      </button>
      <button class="button button--apply">
        Применить
      </button>
    </div>
  </form>
</div>