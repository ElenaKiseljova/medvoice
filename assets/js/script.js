// Навигация
let buttonMinimize = document.querySelector('.nav__btn');
let navigationMenu = document.querySelector('.nav');
let mainContainer = document.querySelector('.content');
let logo = document.querySelector('.logo__img')
let logoShort = document.querySelector('.logo__img--short')

if (buttonMinimize) {
    buttonMinimize.addEventListener('click', function() {
        navigationMenu.classList.toggle('nav--minimize');
        mainContainer.classList.toggle('content--minimize');
        logo.classList.toggle('hidden');
        logoShort.classList.toggle('hidden');
    })
}


// Выпадающее меню в шапке при клике на пользователя
let headerProfile = document.querySelector('.header-profile'); // находим кнопку для открытия/закрытия окна навигации
let headerProfileMenu = document.querySelector('.header-profile__menu'); // находим окно навигации

if (headerProfile) {
    headerProfile.addEventListener('click', () => {
        headerProfileMenu.classList.toggle('hidden');
    })
}

window.addEventListener('click', e => {
    const target = e.target;
    if (!target.closest('.header-profile__menu') && !target.closest('.header-profile')) {
        headerProfileMenu.classList.add('hidden');
    }
})


// Свайпер
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