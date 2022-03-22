

(() => {
  'use strict';

  window.files = (container, attr = {}) => {
    const filesSelector = attr['filesSelector'] ?? '.files';
    const filesPictureSelector = attr['filesPictureSelector'] ?? '.files__picture';
    const filesInputSelector = attr['filesInputSelector'] ?? '.files__input';

    const files = container.querySelectorAll(filesSelector);

    if (files.length > 0) {
      // Загружаемые допустимые форматы файлов
      const fileTypes = [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/jpg'
      ];

      // Проверка типов файлов
      const validFileType = (file) => {
        for (var i = 0; i < fileTypes.length; i++) {
          if (file.type === fileTypes[i]) {
            return true;
          }
        }

        return false;
      };

      // Получение размера файла
      /*const returnFileSize = (number) => {
        if(number < 1024) {
          return number + 'bytes';
        } else if(number > 1024 && number < 1048576) {
          return (number/1024).toFixed(1) + 'KB';
        } else if(number > 1048576) {
          return (number/1048576).toFixed(1) + 'MB';
        }
      };*/

      // Ф-я обновления отображаемого после изменения значения инпута
      const updateDisplay = (inputFile, pictureFile) => {
        // Массив полученных файлов
        let curFiles = inputFile.files;

        // Нет файлов
        if (curFiles.length === 0) {
          console.log('Ошибка загрузки: Нет файлов');
        } else {
          // Перебираем все загруженные файлы и пушим в массив
          let curFilesArray = [];
          for (let i = 0; i < curFiles.length; i++) {
            curFilesArray.push(curFiles[i]);
          }

          // Перебираем элементы массива
          curFilesArray.forEach((curFilesArrayI, i) => {
            if (validFileType(curFilesArrayI)) {
              if (pictureFile) {
                const image = pictureFile.querySelector('img');
                image.src = window.URL.createObjectURL(curFilesArrayI);
              }
            } else {
              console.log('Not a valid file type. Update your selection.');
            }
          });
        }
      };

      files.forEach((file, i) => {
        const inputFile = file.querySelector(filesInputSelector);

        // Отображение загруженной картинки
        const pictureFile = file.querySelector(filesPictureSelector);

        inputFile.addEventListener('change', () => {
          updateDisplay(inputFile, pictureFile);
        });
      });
    }
  }

  document.addEventListener('readystatechange', () => {
    if (document.readyState === 'interactive') {
      const attr = {
        filesSelector: '.form__avatar',
        filesPictureSelector: '.form__avatar-box',
        filesInputSelector: 'input[type="file"]'
      };

      window.files(document, attr);
    }
  });
})();
