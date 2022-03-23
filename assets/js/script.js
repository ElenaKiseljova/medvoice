document.addEventListener("DOMContentLoaded", function (event) {

  // Навигация
  let buttonMinimize = document.querySelector('.nav__btn');
  let navigationMenu = document.querySelector('.nav');
  let mainContainer = document.querySelector('.content');
  let logo = document.querySelector('.logo__img')
  let logoShort = document.querySelector('.logo__img--short')

  if (buttonMinimize) {
    buttonMinimize.addEventListener('click', function () {
      navigationMenu.classList.toggle('nav--minimize');
      mainContainer.classList.toggle('content--minimize');
      logo.classList.toggle('hidden');
      logoShort.classList.toggle('hidden');
    })
  }


  // Выпадающее меню в шапке при клике на пользователя
  let headerProfile = document.querySelector('.profile'); // находим кнопку для открытия/закрытия окна навигации
  let headerProfileMenu = document.querySelector('.profile__menu'); // находим окно навигации

  if (headerProfile) {
    headerProfile.addEventListener('click', () => {
      headerProfileMenu.classList.toggle('hidden');
    })
  }

  window.addEventListener('click', e => {
    if (headerProfileMenu) {
      const target = e.target;
      if (!target.closest('.profile__menu') && !target.closest('.profile')) {
        headerProfileMenu.classList.add('hidden');
      }
    }
  })


  // Свайпер
  let swiperExist = document.querySelector('.swiper');

  if (swiperExist) {
    const swiperCourses = new Swiper('.swiper-courses', {
      spaceBetween: 20,
      slidesPerView: 'auto',

      navigation: {
        nextEl: '.slider__btn-next',
        prevEl: '.slider__btn-prev',
      },
    });

    const swiperWebinar = new Swiper('.swiper-webinar', {
      spaceBetween: 20,
      slidesPerView: 'auto',

      navigation: {
        nextEl: '.slider__btn-next',
        prevEl: '.slider__btn-prev',
      },
    });

    const swiperLecture = new Swiper('.swiper-lecture', {
      spaceBetween: 20,
      slidesPerView: 'auto',

      navigation: {
        nextEl: '.slider__btn-next',
        prevEl: '.slider__btn-prev',
      },
    });
  }


  // Табы
  let tabName = document.querySelectorAll('.account__item');
  let tab = document.querySelectorAll('.tab');

  if (tab) {
    tabName.forEach(function (item) {
      item.addEventListener('click', function () {
        for (let i = 0; i < tabName.length; i++) {
          tabName[i].classList.remove('account__item--active');
          tab[i].classList.remove('tab--active');
        };
        item.classList.add('account__item--active');

        for (let j = 0; j < tabName.length; j++) {
          if (tabName[j].classList.contains('account__item--active')) {
            tab[j].classList.add('tab--active');
          }
        };
      });
    });
  }

  // Редактирование профиля
  let tabForms = document.querySelectorAll('.tab__form');

  if (tabForms.length > 0) {
    const toggleReadonlyAttr = (tabForm, valueReadonly = true, init = false) => {
      const editProfileButton = tabForm.querySelector('.form__button--tab');
      const cancelProfileButton = tabForm.querySelector('.button--cancel');

      if (editProfileButton && cancelProfileButton) {
        const tabFormButtonBox = tabForm.querySelector('.form__button-box');

        const tabFormRows = tabForm.querySelectorAll('.form__row');

        const tabFormAvatar = tabForm.querySelector('.form__avatar');

        let uploadImageButton = false;
        if (tabFormAvatar) {
          uploadImageButton = tabFormAvatar.querySelector('.form__row');
        }

        if (valueReadonly) {
          tabFormRows.forEach(el => el.classList.add('disabled'));

          editProfileButton.classList.remove('hidden');

          if (tabFormButtonBox) {
            tabFormButtonBox.classList.add('hidden');
          }

          if (uploadImageButton) {
            uploadImageButton.classList.add('hidden');
          }
        } else {
          tabFormRows.forEach(el => el.classList.remove('disabled'));

          editProfileButton.classList.add('hidden');

          if (tabFormButtonBox) {
            tabFormButtonBox.classList.remove('hidden');
          }

          if (uploadImageButton) {
            uploadImageButton.classList.remove('hidden');
          }
        }

        if (init) {
          editProfileButton.addEventListener('click', function (event) {
            event.preventDefault();

            toggleReadonlyAttr(tabForm, false);
          })

          cancelProfileButton.addEventListener('click', function (event) {
            event.preventDefault();

            toggleReadonlyAttr(tabForm, true);

            window.location.reload();
          })
        }
      }
    };

    // Перебираем все формы
    tabForms.forEach(tabForm => {
      // Инициализируем кнопки-переключатели
      toggleReadonlyAttr(tabForm, true, true);
    });
  }


  // Селект
  const selects = document.querySelectorAll('.select');

  if (selects.length > 0) {
    selects.forEach(select => {
      const selectHeader = select.querySelector('.select__header');
      const selectItems = select.querySelectorAll('.select__item');
      const selectField = select.querySelector('.select__field');

      if (selectHeader && selectField && selectItems.length > 0) {
        const selectOptions = selectField.querySelectorAll('option');

        selectHeader.addEventListener('click', function () {
          select.classList.toggle('select--active');
        })

        selectItems.forEach(selectItem => {
          selectItem.addEventListener('click', function () {
            const itemText = selectItem.textContent,
              currentText = select.querySelector('.select__current'),
              itemValue = selectItem.dataset.value ?? -1;

            selectOptions.forEach(selectOption => {
              if (selectOption.value === itemValue) {
                selectOption.selected = true;
                selectField.classList.add('selected');
              }
            });

            currentText.textContent = itemText;

            select.classList.remove('select--active');
          })
        });

        selectOptions.forEach(selectOption => {
          if (selectOption.selected === true) {
            selectItems.forEach(selectItem => {
              if (selectItem.dataset.value === selectOption.value) {
                selectItem.click();
              }
            });
          }
        });

        window.addEventListener('click', e => {
          if (
            e.target.closest('.select') !== select &&
            select.classList.contains('select--active')
          ) {
            select.classList.remove('select--active');
          }
        })
      }
    });
  }




  console.log("DOM fully loaded and parsed");
});