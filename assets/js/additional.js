(() => {
  'use strict';

  const { __, _x, _n, _nx } = wp.i18n;

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

              tariffs.forEach(item => item.classList.remove('active'));

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
    // Логирование, регистрация, заказ триала
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
    }
  };

  document.addEventListener('DOMContentLoaded', () => {
    additional.subscription.init();

    additional.user.init(['login', 'register', 'trial', 'forgot', 'reset', 'editinfo', 'editpassword']);

    additional.setUserTime();

    additional.popups();
  });
})();