(() => {
  'use strict';

  const { __, _x, _n, _nx } = wp.i18n;

  // Ф-я валидации полей форм
  const validation = {
    email(value) {
      const regex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      if (value.trim().length === 0) {
        return false;
      }
      return regex.test(value.toLowerCase());
    },
    name(value) {
      const pattern = /^[\d\p{L} ._-]+$/gu;
      return pattern.test(value);
    },
    phone(value) {
      const pattern = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,15}(\s*)?$/;

      return pattern.test(value);
    },
    password(value) {
      /*
        (?=.*[0-9]) - строка содержит хотя бы одно число;
        (?=.*[!@#$%^&*]) - строка содержит хотя бы один спецсимвол;
        (?=.*[a-z]) - строка содержит хотя бы одну латинскую букву в нижнем регистре;
        (?=.*[A-Z]) - строка содержит хотя бы одну латинскую букву в верхнем регистре;
        [0-9a-zA-Z!@#$%^&*]{6,} - строка состоит не менее, чем из 6 вышеупомянутых символов.
      */
      const pattern = /[0-9a-zA-Z!@#$%^&*]{8,}/g;

      return pattern.test(value);
    },
    drawError(field, valid) {
      if (valid) {
        field.closest('.form__row').classList.remove('error');

        let nextElement = field.closest('.form__row').nextElementSibling;

        if (nextElement && nextElement.classList.contains('error-span')) {
          nextElement.remove();
        }
      } else {
        field.closest('.form__row').classList.add('error');
      }
    },
    start(form) {
      let valid = true;

      const checkValid = (field) => {
        if (field.name === 'name' || field.name === 'nickname') {
          valid = validation.name(field.value);

          validation.drawError(field, valid);
        } else if (field.type === 'tel') {
          valid = validation.phone(field.value);

          validation.drawError(field, valid);
        } else if (field.type === 'email') {
          valid = validation.email(field.value);

          validation.drawError(field, valid);
        } else if (field.type === 'password') {
          valid = validation.password(field.value);

          validation.drawError(field, valid);
        } else {
          validation.drawError(field, true);
        }
      };

      const fields = form.querySelectorAll('input');

      const passwordField = form.querySelector('input[name="password"]');

      fields.forEach((field) => {
        checkValid(field);

        field.addEventListener('input', () => {
          if (field.name !== 'password-confirm') {
            checkValid(field);
          } else if (field.name === 'password-confirm' && passwordField) {
            const valid = field.value === passwordField.value && validation.password(field.value);

            validation.drawError(field, valid);
          }

          let nextElement = field.closest('.form__row').nextElementSibling;

          if (nextElement && nextElement.classList.contains('error-span')) {
            nextElement.remove();
          }
        });
      });

      return valid;
    },
  };

  // Ф-я удаления активного класса у массива элементов
  const removeActiveClass = (elements, className = 'active') => {
    elements.forEach((element, i) => {
      if (element.classList.contains(className)) {
        element.classList.remove(className);
      }
    });
  };

  const additional = {
    // data: id, condition, noConditionText, callback
    // ** callback(form, response)
    form(data) {
      const form = document.querySelector(`#${data.id}`);

      if (form) {
        // Сообщение с результатами ajax запроса
        const formStatus = form.querySelector('#ajax-response');

        // Отправка формы
        const send = (dataForm) => {
          try {
            const url = medvoice_ajax.url;

            form.classList.add('sending');

            fetch(url, {
              method: 'POST',
              credentials: 'same-origin',
              body: dataForm
            })
              .then((response) => response.json())
              .then((response) => {
                if (formStatus) {
                  formStatus.innerHTML = '';
                }

                if (response.success === true) {
                  if (formStatus) {
                    formStatus.innerHTML = response.data.message ?? '';
                    formStatus.classList.add('success');
                  }

                  // Уникальные действия при успехе отправки формы
                  data.callback(form, response);

                  console.log('Успех:', response);
                } else {
                  if (response.data && response.data.type && response.data.message) {
                    const field = form.querySelector(`input[name="${response.data.type}"]`);

                    if (field) {
                      // Проверяю: существует ли уже поле с ошибкой
                      const errorSpanExists = field.closest('.form__row').nextElementSibling ?
                        field.closest('.form__row').nextElementSibling.classList.contains('error-span') :
                        false;

                      if (errorSpanExists === false) {
                        const errorSpan = document.createElement('span');
                        errorSpan.classList.add('error-span');
                        errorSpan.textContent = response.data.message;
                        errorSpan.style.color = 'red';

                        field.closest('.form__row').insertAdjacentElement('afterend', errorSpan);
                      } else {
                        const errorSpan = field.closest('.form__row').nextElementSibling;

                        errorSpan.textContent = response.data.message;
                      }

                      field.closest('.form__row').classList.add('error');
                    }
                  } else if (formStatus) {
                    formStatus.innerHTML = (response.data && response.data.message) ?
                      response.data.message :
                      __('Что-то пошло не так...', 'medvoice');

                    formStatus.classList.add('error');
                  }

                  console.error('Ошибка:', response);
                }

                form.classList.remove('sending');

                if (formStatus) {
                  formStatus.classList.add('active');
                }

                setTimeout(() => {
                  if (formStatus) {
                    formStatus.innerHTML = '';
                    formStatus.classList.remove('active', 'error', 'success');
                  }
                }, 2000);
              })
              .catch((error) => {
                form.classList.remove('sending');

                console.error('Ошибка:', error);
              });
          } catch (error) {
            form.classList.remove('sending');

            console.error('Ошибка:', error);
          }
        };

        // Отправка формы
        form.addEventListener('submit', (evt) => {
          evt.preventDefault();

          if (data.condition(form)) {
            const dataForm = new FormData(form);

            dataForm.append('action', data.action);
            dataForm.append('security', medvoice_ajax.nonce);

            // recaptcha (start)
            let noBot = 0;

            const siteKey = medvoice_ajax.site_key ?? false;

            if (siteKey) {
              grecaptcha.ready(function () {
                grecaptcha.execute(siteKey, { action: 'submit' }).then(function (token) {
                  // console.log('grecaptcha is OK');

                  noBot = 1;

                  dataForm.append('antibot', noBot);

                  send(dataForm);
                });
              });
            } else {
              noBot = 1;

              dataForm.append('antibot', noBot);

              send(dataForm);
            }
          } else {
            if (formStatus) {
              formStatus.innerHTML = data.noConditionText ? data.noConditionText : 'Условие не выполнено';
              formStatus.classList.add('active', 'error');

              setTimeout(() => {
                formStatus.innerHTML = '';
                formStatus.classList.remove('active', 'error');
              }, 2000);
            }
          }
        });
      }
    },
    // Подписка на тариф
    subscription: {
      init() {
        const tariffs = document.querySelectorAll('.tariff-card');

        if (tariffs && tariffs.length > 0) {
          tariffs.forEach(tariff => {
            // Если есть активный пункт в верстке
            if (tariff.classList.contains('active')) {
              additional.subscription.setData(tariff);
            }

            // Если кликнули по кнопке пункта
            const tariffButton = tariff.querySelector('button');

            tariffButton.addEventListener('click', (evt) => {
              evt.preventDefault();

              removeActiveClass(tariffs, 'active');

              tariff.classList.add('active');

              additional.subscription.setData(tariff);
            });
          });
        }

        const data = {
          id: 'subscription',
          action: 'medvoice_create_order_ajax',
          condition: additional.subscription.checkData,
          noConditionText: __('Выберите Тариф', 'medvoice'),
          callback: additional.subscription.callback
        };

        additional.form(data);
      },
      // Получение заначения ИД продукта
      checkData() {
        const inputProductId = document.querySelector('input[name="product_id"]');
        const inputMonths = document.querySelector('input[name="months"]');

        return (inputProductId && inputMonths) ? (inputProductId.value.length > 0 && inputMonths.value.length > 0) : false;
      },
      // Установка заначения ИД продукта
      setData(tariff) {
        const productId = parseInt(tariff.dataset.productId);
        const inputProductId = document.querySelector('input[name="product_id"]');

        const months = parseInt(tariff.dataset.months);
        const inputMonths = document.querySelector('input[name="months"]');

        if (inputProductId && inputMonths) {
          inputProductId.value = productId;

          inputMonths.value = months;
        }
      },
      callback(form, response) {
        // WayForPay (start)
        let formWayForPayHTML = response.data.form ?? '';

        form.insertAdjacentHTML('afterend', formWayForPayHTML);

        const formWayForPay = document.querySelector('#form_wayforpay');

        if (formWayForPay) {
          formWayForPay.submit();
        }
        // WayForPay (end)
      }
    },
    // Логирование, регистрация, заказ триала, восстановление/смена пароля, редактирование информации
    user: {
      init(ids = []) {
        const actions = {
          login: 'medvoice_ajax_login',
          register: 'medvoice_ajax_register_mail',
          trial: 'medvoice_ajax_register_mail',
          forgot: 'medvoice_ajax_forgot_password',
          reset: 'medvoice_ajax_reset_password',
          editinfo: 'medvoice_ajax_edit_user_info',
          editpassword: 'medvoice_ajax_edit_password'
        };

        const callbacks = {
          login() {
            window.location.href = window.location.origin;
          },
          register() {
            if (medvoice_ajax.forms) {
              window.location.href = medvoice_ajax.forms + '?action=success&type=register';
            }
          },
          trial() {
            if (medvoice_ajax.forms) {
              window.location.href = medvoice_ajax.forms + '?action=success&type=register';
            }
          },
          forgot(form = null, response = null) {
            if (medvoice_ajax.forms) {
              const email = (response !== null) ? (response.email ?? '') : '';

              window.location.href = medvoice_ajax.forms + '?action=success&type=forgot&email=' + email;
            }
          },
          reset() {
            if (medvoice_ajax.forms) {
              window.location.href = medvoice_ajax.forms + '?action=success&type=reset';
            }
          },
          editinfo() {
            window.location.reload();
          },
          editpassword() {
            window.location.reload();
          },
        };

        ids.forEach(id => {
          const data = {
            id: id,
            action: actions[id],
            condition: validation.start,
            noConditionText: __('Некорректно заполнены поля', 'medvoice'),
            callback: callbacks[id],
          };

          additional.form(data);
        });
      },
    },
    // Установка куки с временем пользователя с привазкой к часовому поясу
    setUserTime() {
      const dataForm = new FormData();

      dataForm.append('action', 'medvoice_set_user_time');
      dataForm.append('security', medvoice_ajax.nonce);
      dataForm.append('offset', new Date().getTimezoneOffset());

      try {
        const url = medvoice_ajax.url;

        fetch(url, {
          method: 'POST',
          credentials: 'same-origin',
          body: dataForm
        })
          .then((response) => response.json())
          .then((response) => {
            if (response.success === true) {
              console.log('Успех:', response);
            } else {
              console.error('Ошибка:', response);
            }
          })
          .catch((error) => {
            console.error('Ошибка:', error);
          });
      } catch (error) {
        console.error('Ошибка:', error);
      }
    },
    // Добавление в закладки
    bookmarks() {
      const changeUserBookmarks = (bookmark, type = 'add') => {
        const videoId = bookmark.dataset.videoId ?? false;

        if (videoId) {
          const dataForm = new FormData();

          if (type === 'add') {
            dataForm.append('action', 'medvoice_ajax_add_to_bookmarks');
          } else {
            dataForm.append('action', 'medvoice_ajax_remove_from_bookmarks');
          }

          dataForm.append('video_id', videoId);
          dataForm.append('security', medvoice_ajax.nonce);

          try {
            const url = medvoice_ajax.url;

            bookmark.classList.add('sending');

            fetch(url, {
              method: 'POST',
              credentials: 'same-origin',
              body: dataForm
            })
              .then((response) => response.json())
              .then((response) => {
                if (response.success === true) {
                  if (type === 'add') {
                    bookmark.classList.add('saved');
                  } else {
                    bookmark.classList.remove('saved');
                  }

                  console.log('Успех:', response);
                } else {
                  console.error('Ошибка:', response);
                }

                bookmark.classList.remove('sending');
              })
              .catch((error) => {
                console.error('Ошибка:', error);

                bookmark.classList.remove('sending');
              });
          } catch (error) {
            console.error('Ошибка:', error);

            bookmark.classList.remove('sending');
          }
        }
      };

      const bookmarks = document.querySelectorAll('.bookmarks ');
      if (bookmarks.length > 0) {
        bookmarks.forEach(bookmark => {
          bookmark.addEventListener('click', (evt) => {
            evt.preventDefault();

            if (bookmark.classList.contains('saved')) {
              changeUserBookmarks(bookmark, 'remove');
            } else {
              changeUserBookmarks(bookmark, 'add');
            }
          });
        });
      }
    },
    // Попап с инф. об окончании Триала/Подписки
    popups() {
      const popups = document.querySelectorAll('.popup');

      if (popups.length > 0) {
        popups.forEach(popup => {
          const popupCloseButton = popup.querySelector('.popup__close');

          popupCloseButton?.addEventListener('click', () => {
            popup.classList.remove('active');

            if (popup.dataset.type === 'subscribe-ended') {
              window.cookieEdit.set('subscribe-ended', '1');
            }
          });

          window.addEventListener('load', () => {
            popup.classList.add('loaded');

            if (popup.dataset.type === 'subscribe-ended' && window.cookieEdit.get('subscribe-ended') !== '1') {
              popup.classList.add('active');
            }
          });
        });
      }
    },

    /* Фильтры Видео */
    //Поиск
    search() {
      let lastTimeout;

      const searchForm = document.querySelector('.header__form');

      if (searchForm) {
        let value = '';

        const results = document.querySelector('.results');

        const inputSearch = searchForm.querySelector('#s');

        if (inputSearch && results) {
          const changeSearchResults = (value = '') => {
            // Искать только по фразе, состоящей из более 2 символов
            if (value.length > 2 || value.length === 0) {
              if (lastTimeout) {
                clearTimeout(lastTimeout);
              }

              lastTimeout = setTimeout(() => {
                additional.getAjaxSearch(value);

                results.classList.remove('hidden');
              }, 500);
            }
          };

          const onSearchKeyUp = (evt) => {
            if (evt.target.value.trim() !== value) {
              value = evt.target.value.trim();

              changeSearchResults(value);
            }

            return false;
          };

          const onSearchKeyDown = (evt) => {
            value = inputSearch.value.trim();
          };

          const onSearchBlur = (evt) => {
            if (!results.classList.contains('hidden') && evt.target !== inputSearch) {
              results.classList.add('hidden');
            }
          };

          inputSearch.addEventListener('keydown', onSearchKeyDown);

          inputSearch.addEventListener('keyup', onSearchKeyUp);

          inputSearch.addEventListener('input', onSearchKeyUp);

          document.addEventListener('click', onSearchBlur);
        }
      }
    },
    // Пагинация
    paginationActivate() {
      try {
        const paginationButtons = document.querySelectorAll('.pagination__button');

        let paginationPrev, paginationNext;

        paginationButtons.forEach((paginationButton) => {
          if (paginationButton.classList.contains('pagination__button--prev')) {
            paginationPrev = paginationButton;
          }

          if (paginationButton.classList.contains('pagination__button--next')) {
            paginationNext = paginationButton;
          }

          paginationButton.addEventListener('click', (e) => {
            if (paginationButton.classList.contains('pagination__button--page') && !paginationButton.classList.contains('current')) {
              removeActiveClass(paginationButtons, 'current');

              if (paginationButton.classList.contains('first')) {
                paginationPrev.classList.add('disabled');
              } else {
                paginationPrev.classList.remove('disabled');
              }

              if (paginationButton.classList.contains('last')) {
                paginationNext.classList.add('disabled');
              } else {
                paginationNext.classList.remove('disabled');
              }

              paginationButton.classList.add('current');


            } else if (paginationButton.classList.contains('pagination__button--prev') || paginationButton.classList.contains('pagination__button--next')) {
              const toPaged = paginationButton.dataset.paged;
              const toPagedButton = [].find.call(paginationButtons, (button) => button.classList.contains('pagination__button--page') && button.dataset.paged === toPaged);

              if (toPagedButton) {
                removeActiveClass(paginationButtons, 'current');

                toPagedButton.classList.add('current');
              }
            }

            additional.getPage(paginationButton);
          });
        });
      } catch (e) {
        console.log(e);
      }
    },
    // Получение Видео с определенной страницы
    getPage(button) {
      let paged = button.dataset.paged;

      paged = paged ? paged : 1;

      additional.getAjaxPage(paged);
    },
    // Запрос на получение Видео с определенной страницы
    getAjaxPage(paged) {
      const dataAjaxContainer = document.querySelector('#catalog-ajax');

      if (dataAjaxContainer) {
        let dataForm = new FormData();

        dataForm.append('action', 'medvoice_ajax_videos_cards_html');
        dataForm.append('security', medvoice_ajax.nonce);

        dataForm.append('posts_per_page', window.postPerpage);
        dataForm.append('paged', paged);
        dataForm.append('taxonomies', window.taxonomies);
        dataForm.append('s', window.s);
        dataForm.append('bookmarks', window.bookmarks);

        additional.onAjax(dataForm, dataAjaxContainer);
      }
    },
    // Запрос на получение Видео по поисковой фразе
    getAjaxSearch(value) {
      const dataAjaxContainer = document.querySelector('#search-ajax');

      if (dataAjaxContainer) {
        let dataForm = new FormData();

        dataForm.append('action', 'medvoice_ajax_search_list');
        dataForm.append('security', medvoice_ajax.nonce);

        dataForm.append('posts_per_page', 3);
        dataForm.append('paged', 1);
        dataForm.append('s', value);

        additional.onAjax(dataForm, dataAjaxContainer);
      }
    },
    // Отправка на сервер данных для получения списка Видео
    onAjax(dataForm, dataAjaxContainer) {
      try {
        const url = medvoice_ajax.url;

        dataAjaxContainer.classList.add('sending');

        fetch(url, {
          method: 'POST',
          credentials: 'same-origin',
          body: dataForm
        })
          .then((response) => response.json())
          .then((response) => {
            if (response.success === true) {
              dataAjaxContainer.innerHTML = response.data.content;

              additional.paginationActivate();

              additional.bookmarks();

              // window.scrollSmooth(dataAjaxContainer);

              console.log('Успех:', response);
            } else {
              console.error('Ошибка:', response);
            }

            dataAjaxContainer.classList.remove('sending');
          })
          .catch((error) => {
            console.error('Ошибка:', error);

            dataAjaxContainer.classList.remove('sending');
          });
      } catch (error) {
        console.error('Ошибка:', error);

        dataAjaxContainer.classList.remove('sending');
      }
    }
  };

  document.addEventListener('DOMContentLoaded', () => {
    try {
      additional.subscription.init();
    } catch (error) {
      console.log(error);
    }

    try {
      additional.user.init(['login', 'register', 'trial', 'forgot', 'reset', 'editinfo', 'editpassword']);
    } catch (error) {
      console.log(error);
    }

    try {
      additional.setUserTime();
    } catch (error) {
      console.log(error);
    }

    try {
      additional.popups();
    } catch (error) {
      console.log(error);
    }

    try {
      additional.bookmarks();
    } catch (error) {
      console.log(error);
    }

    try {
      additional.paginationActivate();
    } catch (error) {
      console.log(error);
    }

    try {
      additional.search();
    } catch (error) {
      console.log(error);
    }
  });
})();