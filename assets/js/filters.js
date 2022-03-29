(() => {
  'use strict';

  try {
    window.filters = {
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
                  window.filters.getAjaxSearch(value);

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
                window.filters.removeActiveClass(paginationButtons, 'current');

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
                  window.filters.removeActiveClass(paginationButtons, 'current');

                  toPagedButton.classList.add('current');
                }
              }

              window.filters.getPage(paginationButton);
            });
          });
        } catch (e) {
          console.log(e);
        }
      },
      // Фильтры
      activate() {
        // try {
        //   const filterButtons = document.querySelectorAll('.graduates__button');

        //   filterButtons.forEach((filterButton) => {
        //     filterButton.addEventListener('click', (e) => {
        //       if (!filterButton.classList.contains('active')) {
        //         window.filters.removeActiveClass(filterButtons);

        //         filterButton.classList.add('active');

        //         if (typeof window.filters.getTerm === 'function') {
        //           window.filters.getTerm(filterButton);
        //         }
        //       }
        //     });
        //   });
        // } catch (e) {
        //   console.log(e);
        // }
      },
      // Ф-я удаления активного класса у массива элементов
      removeActiveClass(elements, className = 'active') {
        elements.forEach((element, i) => {
          if (element.classList.contains(className)) {
            element.classList.remove(className);
          }
        });
      },
      // getTerm(button) {
      //   const termId = button.dataset.termId;

      //   window.termId = termId ? termId : -1;

      //   window.filters.getAjaxPage(window.termId, 1);
      // },
      getPage(button) {
        let paged = button.dataset.paged;

        paged = paged ? paged : 1;

        window.filters.getAjaxPage(paged);
      },
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

          window.filters.onAjax(dataForm, dataAjaxContainer);
        }
      },
      getAjaxSearch(value) {
        const dataAjaxContainer = document.querySelector('#search-ajax');

        if (dataAjaxContainer) {
          let dataForm = new FormData();

          dataForm.append('action', 'medvoice_ajax_search_list');
          dataForm.append('security', medvoice_ajax.nonce);

          dataForm.append('posts_per_page', 3);
          dataForm.append('paged', 1);
          dataForm.append('s', value);

          window.filters.onAjax(dataForm, dataAjaxContainer);
        }
      },
      // Отправка на сервер
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

                window.filters.paginationActivate();

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
      // window.filters.activate();

      window.filters.paginationActivate();
      window.filters.search();
    });
  } catch (e) {
    console.error(e);
  }
})(jQuery);