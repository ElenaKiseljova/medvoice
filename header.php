<?php 
  get_template_part( 'templates/header' );
?>
  <div class="container">
    <?php 
      get_template_part( 'templates/aside' );
    ?> 
    
    <div class="content">
      <header class="header">
        <div class="header__search">
          <?php get_search_form(); ?>

          <div class="header-results hidden">
            <h3 class="header-results__title">
              Результаты
            </h3>

            <ul class="header-results__list">
              <li class="header-results__item">
                  <a href="#" class="header-results__link">
                      <div class="header-results__img-box">
                          <img class="header-results__img" src="img/card-1.jpg" alt="">
                      </div>
                      <div class="header-results__text-box">
                          <p class="header-results__text">
                              Курс
                          </p>
                          <h4 class="header-results__name">
                              Международный симпозиум по хирургии
                          </h4>
                      </div>
                  </a>
              </li>

              <li class="header-results__item">
                  <a href="#" class="header-results__link">
                      <div class="header-results__img-box">
                          <img class="header-results__img" src="img/card-3.jpg" alt="">
                      </div>
                      <div class="header-results__text-box">
                          <p class="header-results__text">
                              Вебинар
                          </p>
                          <h4 class="header-results__name">
                              Международный симпозиум по хирургии
                          </h4>
                      </div>
                  </a>
              </li>

              <li class="header-results__item">
                  <a href="#" class="header-results__link">
                      <div class="header-results__img-box">
                          <img class="header-results__img" src="img/card-5.jpg" alt="">
                      </div>
                      <div class="header-results__text-box">
                          <p class="header-results__text">
                              Лекция
                          </p>
                          <h4 class="header-results__name">
                              Всё о хирургии
                          </h4>
                      </div>
                  </a>
              </li>
            </ul>

            <a href="search.html" class="button">
              Смотреть больше
            </a>
          </div>
        </div>
        
        <?php 
          get_template_part( 'templates/user' );
        ?>         
      </header>

  