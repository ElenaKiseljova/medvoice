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
      const pattern = /^[\p{L} ._-]+$/gu;
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
        field.parentNode.classList.remove('error');
      } else {
        field.parentNode.classList.add('error');
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
        }
      };

      const fields = form.querySelectorAll('input');

      fields.forEach((field) => {
        checkValid(field);

        field.addEventListener('input', () => {
          checkValid(field);

          let nextElement = field.parentNode.nextElementSibling;

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
                  }

                  // Уникальные действия при успехе отправки формы
                  data.callback(form, response);

                  console.log('Успех:', response);
                } else {
                  if (response.data && response.data.type && response.data.message) {
                    const field = form.querySelector(`input[name="${response.data.type}"]`);

                    if (field) {
                      const errorSpan = document.createElement('span');
                      errorSpan.classList.add('error-span');
                      errorSpan.textContent = response.data.message;
                      errorSpan.style.color = 'red';

                      field.parentNode.insertAdjacentElement('afterend', errorSpan);
                    }
                  } else if (formStatus) {
                    formStatus.innerHTML = (response.data && response.data.message) ?
                      response.data.message :
                      __('Что-то пошло не так...', 'medvoice');
                  }

                  console.error('Ошибка:', response);
                }

                form.classList.remove('sending');

                setTimeout(() => {
                  if (formStatus) {
                    formStatus.innerHTML = '';
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
            }
          }
        });
      }
    },
    // Подписка на тариф
    subscription: {
      init() {
        const tariffs = document.querySelectorAll('.list__item');

        if (tariffs && tariffs.length > 0) {
          tariffs.forEach(tariff => {
            // Если есть активный пункт в верстке
            if (tariff.classList.contains('active')) {
              additional.subscription.setProductId(tariff);
            }

            // Если кликнули по пункту
            tariff.addEventListener('click', () => {
              tariffs.forEach(item => item.classList.remove('active'));

              tariff.classList.add('active');
              additional.subscription.setProductId(tariff);
            });
          });
        }

        const data = {
          id: 'subscription',
          action: 'medvoice_ajax_create_order',
          condition: additional.subscription.checkProductId,
          noConditionText: 'Выберите Тариф',
          callback: additional.subscription.callback
        };

        additional.form(data);
      },
      // Получение заначения ИД продукта
      checkProductId() {
        const inputProductId = document.querySelector('input[name="product_id"]');

        return inputProductId ? inputProductId.value.length > 0 : false;
      },
      // Установка заначения ИД продукта
      setProductId(tariff) {
        const productId = parseInt(tariff.dataset.productId);
        const inputProductId = document.querySelector('input[name="product_id"]');

        inputProductId.value = productId;
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
        };

        const callbacks = {
          login() {
            document.location.reload();
          },
          register() {
            // Какие-то действия
          },
          trial() {
            // Какие-то действия
          }
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
    }
  };

  document.addEventListener('DOMContentLoaded', () => {
    additional.subscription.init();

    additional.user.init(['login', 'register', 'trial']);
  });
})();