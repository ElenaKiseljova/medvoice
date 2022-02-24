(function () {
  'use strict';

  const additional = {
    subscription() {
      const form = document.querySelector('#subscription');

      if (form) {
        // Сообщение с результатами ajax запроса
        const formStatus = form.querySelector('#ajax-response');

        const inputTitle = form.querySelector('input[name="title"]');
        const inputPrice = form.querySelector('input[name="price"]');

        // Установка заначений скрытых полей Названия и Стоимости Тарифа
        const setValueInputs = (tariff) => {
          const title = tariff.querySelector('h3').textContent ?? '';
          inputTitle.value = title.trim();

          const price = tariff.querySelector('p').textContent ?? '';
          inputPrice.value = parseFloat(price);
        };

        const tariffs = form.querySelectorAll('.list__item');

        if (tariffs && tariffs.length > 0 && inputTitle && inputPrice) {
          tariffs.forEach(tariff => {
            // Если есть активный пункт в верстке
            if (tariff.classList.contains('active')) {
              setValueInputs(tariff);
            }

            // Если кликнули по пункту
            tariff.addEventListener('click', () => {
              setValueInputs(tariff);
            });
          });
        }

        // Отправка формы
        form.addEventListener('click', (evt) => {
          // evt.preventDefault();

          const url = medvoice_ajax.url;
          const data = new FormData(form);

          data.append('security', medvoice_ajax.nonce);
          data.append('action', 'medvoice_subscription');

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
                  // if (formStatus) {
                  //   formStatus.innerHTML = response.data.message ?? '';
                  // }

                  form.querySelector('input[name="merchantSignature"]').value = response.data;

                  console.log('Успех:', response);
                } else {
                  // if (formStatus) {
                  //   formStatus.innerHTML = (response.data && response.data.message) ? response.data.message : 'Что-то пошло не так...';
                  // }

                  console.error('Ошибка:', response);
                }

                form.classList.remove('sending');

                // setTimeout(() => {
                //   if (formStatus) {
                //     formStatus.innerHTML = '';
                //   }

                //   form.reset();
                // }, 2000);
              })
              .catch((error) => {
                form.classList.remove('sending');

                console.error('Ошибка:', error);
              });
          } catch (error) {
            form.classList.remove('sending');

            console.error('Ошибка:', error);
          }
        });
      }
    },
  };

  document.addEventListener('DOMContentLoaded', () => {
    additional.subscription();
  });
})();