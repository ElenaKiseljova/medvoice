document.addEventListener("DOMContentLoaded", function (event) {

  // Навигация
  let buttonMinimize = document.querySelector('.nav__btn');
  let navigationMenu = document.querySelector('.nav');
  let mainContainer = document.querySelector('.content');
  let logo = document.querySelector('.logo')

  if (buttonMinimize) {
    buttonMinimize.addEventListener('click', function () {
      navigationMenu.classList.toggle('nav--minimize');
      mainContainer.classList.toggle('content--minimize');
      logo.classList.toggle('logo--min');
    })
  };

  //Бургер
  let nav = document.querySelector('.nav');
  let burger = nav.querySelector('.nav__burger');

  if (burger) {
    const rootElement = document.documentElement;

    burger.addEventListener('click', function () {
      // alert(navigator.userAgent);
      nav.classList.toggle('open');
      burger.classList.toggle('open');
      rootElement.classList.toggle('block');

      if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
        // alert('Safari');
        nav.classList.toggle('padding');
      };
    });
  };


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

      on: {
        init(e) {
          if (window.screen.width >= 768) {
            e.enable()
          } else {
            e.slideTo(0, 0)
            e.disable()
          }
        },
        resize(e) {
          if (window.screen.width >= 768) {
            e.enable()
          } else {
            e.slideTo(0, 0)
            e.disable()
          }
        }
      }
    });

    const swiperWebinar = new Swiper('.swiper-webinar', {
      spaceBetween: 20,
      slidesPerView: 'auto',

      navigation: {
        nextEl: '.slider__btn-next',
        prevEl: '.slider__btn-prev',
      },

      on: {
        init(e) {
          if (window.screen.width >= 768) {
            e.enable()
          } else {
            e.slideTo(0, 0)
            e.disable()
          }
        },
        resize(e) {
          if (window.screen.width >= 768) {
            e.enable()
          } else {
            e.slideTo(0, 0)
            e.disable()
          }
        }
      }
    });

    const swiperLecture = new Swiper('.swiper-lecture', {
      spaceBetween: 20,
      slidesPerView: 'auto',

      navigation: {
        nextEl: '.slider__btn-next',
        prevEl: '.slider__btn-prev',
      },

      on: {
        init(e) {
          if (window.screen.width >= 768) {
            e.enable()
          } else {
            e.slideTo(0, 0)
            e.disable()
          }
        },
        resize(e) {
          if (window.screen.width >= 768) {
            e.enable()
          } else {
            e.slideTo(0, 0)
            e.disable()
          }
        }
      }
    });

    const selectSlides = document.querySelectorAll('.swiper-select');
    if (selectSlides.length > 0) {
      const swiperSelect = new Swiper('.swiper-select', {
        direction: "vertical",
        slidesPerView: "auto",
        freemode: true,
        allowTouchMove: true,

        scrollbar: {
          el: ".scrollbar",
          dragClass: "scrollbar__drag",
          draggable: true,
          snapOnRelease: false
        },
        mousewheel: true,
      });
    }

    const side = document.querySelector('.swiper-side');
    if (side) {
      const swiperSide = new Swiper('.swiper-side', {
        direction: "vertical",
        slidesPerView: "auto",
        freemode: true,
        allowTouchMove: true,

        scrollbar: {
          el: ".scrollbar",
          dragClass: "scrollbar__drag",
          draggable: true,
          dragSize: 75,
          snapOnRelease: false
        },
        mousewheel: true,
      });
    }
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

  // Фильтр на странице "Каталог"
  let buttonFilter = document.querySelector('.button--filter');
  let filterBlock = document.querySelector('.catalog__filter');

  if (buttonFilter) {
    buttonFilter.addEventListener('click', function () {
      buttonFilter.classList.toggle('active');
      filterBlock.classList.toggle('active');
    })
  }

  // Чекбоксы
  let dropdownHead = document.querySelectorAll('.dropdown__header');

  if (dropdownHead) {
    dropdownHead.forEach(item => {
      item.addEventListener('click', function () {
        this.parentElement.classList.toggle('dropdown--active');
      });
    });
  }

  // Вид карточек на странице "Каталог"
  let iconRow = document.querySelector('.catalog__icon-row');
  let iconGrid = document.querySelector('.catalog__icon-grid');

  let catalogCards = document.querySelector('.catalog__cards');
  let cards = document.querySelectorAll('.card');

  if (iconRow && iconGrid && catalogCards && cards.length > 0) {
    iconRow.addEventListener('click', function () {
      catalogCards.classList.add('catalog__cards--row');
      cards.forEach(item => {
        item.classList.add('card--row');
      });
      iconGrid.classList.remove('active');
      iconRow.classList.add('active');
    });

    iconGrid.addEventListener('click', function () {
      catalogCards.classList.remove('catalog__cards--row');
      cards.forEach(item => {
        item.classList.remove('card--row');
      });
      iconRow.classList.remove('active');
      iconGrid.classList.add('active');
    });
  }

  // Табы на странице "Автор"
  let tabTitle = document.querySelectorAll('.banner__item');
  let authorTab = document.querySelectorAll('.author__tab');

  if (authorTab) {
    tabTitle.forEach(function (item) {
      item.addEventListener('click', function () {
        for (let i = 0; i < authorTab.length; i++) {
          tabTitle[i].classList.remove('active');
          authorTab[i].classList.remove('author__tab--active');
        };
        item.classList.add('active');

        for (let j = 0; j < authorTab.length; j++) {
          if (tabTitle[j].classList.contains('active')) {
            authorTab[j].classList.add('author__tab--active');
          }
        };
      });
    });
  }

  // Табы на странице "Курс"
  let courseTab = document.querySelectorAll('.course__tab');

  if (courseTab) {
    tabTitle.forEach(function (item) {
      item.addEventListener('click', function () {
        for (let i = 0; i < courseTab.length; i++) {
          tabTitle[i].classList.remove('active');
          courseTab[i].classList.remove('course__tab--active');
        };
        item.classList.add('active');

        for (let j = 0; j < courseTab.length; j++) {
          if (tabTitle[j].classList.contains('active')) {
            courseTab[j].classList.add('course__tab--active');
          }
        };
      });
    });
  }

  // Видео
  const video = document.querySelector('.lection__video');

  if (video) {
    const videoPlayButton = video.querySelector('.lection__img');
    const videoIframe = video.querySelector('iframe');

    if (videoPlayButton && videoIframe) {
      videoPlayButton.addEventListener('click', () => {
        const videoId = videoPlayButton.dataset.videoId;

        if (videoId) {
          videoIframe.src = `https://player.vimeo.com/video/${videoId}?h=e4d417a182&autoplay=1&color=7b42e9&title=0&byline=0&portrait=0`;

          videoPlayButton.classList.add('hide');
        }
      });
    }
  }






  console.log("DOM fully loaded and parsed");
});