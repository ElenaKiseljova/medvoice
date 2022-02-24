(function () {
  'use strict';

  const additional = {
    subscription() {
      const form = document.querySelector('#subscription');

      if (form) {
        // Сообщение с результатами ajax запроса
        const formStatus = form.querySelector('#ajax-response');

        const inputProductId = form.querySelector('input[name="product_id"]');

        // Установка заначений скрытых полей Названия и Стоимости Тарифа
        const setValueInputs = (tariff) => {
          const productId = parseInt(tariff.dataset.productId);

          inputProductId.value = productId;
        };

        const tariffs = form.querySelectorAll('.list__item');

        if (tariffs && tariffs.length > 0 && inputProductId) {
          tariffs.forEach(tariff => {
            // Если есть активный пункт в верстке
            if (tariff.classList.contains('active')) {
              setValueInputs(tariff);
            }

            // Если кликнули по пункту
            tariff.addEventListener('click', () => {
              tariffs.forEach(item => item.classList.remove('active'));

              tariff.classList.add('active');
              setValueInputs(tariff);
            });
          });
        }

        // Отправка формы
        form.addEventListener('submit', (evt) => {
          evt.preventDefault();

          if (inputProductId.value.length > 0) {
            const url = medvoice_ajax.url;
            const data = new FormData(form);

            data.append('action', 'medvoice_ajax_create_order');

            try {
              form.classList.add('sending');

              fetch(url, {
                method: "POST",
                credentials: 'same-origin',
                body: data
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

                    // WayForPay (start)
                    let formWayForPayHTML = response.data.form ?? '';

                    form.insertAdjacentHTML('afterend', formWayForPayHTML);

                    const formWayForPay = document.querySelector('#form_wayforpay');

                    if (formWayForPay) {
                      formWayForPay.submit();
                    }
                    // WayForPay (end)

                    console.log('Успех:', response);
                  } else {
                    if (formStatus) {
                      formStatus.innerHTML = (response.data && response.data.message) ? response.data.message : 'Что-то пошло не так...';
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
          } else {
            if (formStatus) {
              formStatus.innerHTML = 'Выберите Тариф';
            }
          }
        });
      }
    },
  };

  document.addEventListener('DOMContentLoaded', () => {
    additional.subscription();
  });
})();