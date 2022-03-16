<?php 
  /**
   * Template Name: Поиск
   */
?>

<?php 
  get_header(  );
?>

<?php 
  global $wp_query;

  $posts_found = $wp_query->found_posts ?? 0;
?>

<main class="search">
  <div class="search__head">
    <h1 class="search__title">
      <?= 
        sprintf( __( 'Результаты поиска «%s»', 'medvoice' ), get_search_query(  ) );
      ?>        
    </h1>

    <h3 class="search__link">
      <?= 
        sprintf( __( '%s совпадений', 'medvoice' ), $posts_found );
      ?> 
    </h3>
  </div>

  <div class="search__cards-wrapper">
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <a href="#" class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
            <div class="card__btn">
                <svg class="card__btn-icon" width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 17.4339V2.56611C0 1.00425 1.71019 0.0451181 3.0429 0.85955L15.2074 8.29344C16.4836 9.0733 16.4836 10.9267 15.2074 11.7066L3.0429 19.1404C1.71019 19.9549 0 18.9957 0 17.4339Z"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon card__description-icon--save" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </a>
    <div class="card card--search">
        <div class="card__link-box">
            <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-2.jpg" alt="hospital">
            <div class="card__btn card__btn--lock">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.6979 11H2.30208C1.58296 11 1 11.583 1 12.3021V24.6979C1 25.417 1.58296 26 2.30208 26H19.6979C20.417 26 21 25.417 21 24.6979V12.3021C21 11.583 20.417 11 19.6979 11Z" fill="#505FB6" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10.8171V5.83582C6 3.07439 8.23858 1 11 1C13.7614 1 16 3.07439 16 5.83582V10.8171" stroke="#505FB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19V20.75" stroke="#DCDFF0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 19C12.1046 19 13 18.1046 13 17C13 15.8954 12.1046 15 11 15C9.89543 15 9 15.8954 9 17C9 18.1046 9.89543 19 11 19Z" fill="#DCDFF0"/>
                </svg>
            </div>
        </div>
        <div class="card__info">
            <h3 class="card__title">
                Международный симпозиум по тромбозу и гемостазу
            </h3>
            <div class="card__description">
                <div class="card__description-box">
                    <p class="card__description-name">
                        Курс
                    </p>
                    <p class="card__description-text">
                        15 лекций
                    </p>
                </div>
                <button class="card__description-link">
                    <svg class="card__description-icon" width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.39928 13.8695C8.1592 13.7028 7.8408 13.7028 7.60072 13.8695L1.17112 18.3345C0.972188 18.4726 0.7 18.3303 0.7 18.0881V2.22222C0.7 1.82497 0.862133 1.43986 1.15743 1.15277C1.45339 0.865029 1.85889 0.7 2.28571 0.7H13.7143C14.1411 0.7 14.5466 0.865029 14.8426 1.15277C15.1379 1.43986 15.3 1.82497 15.3 2.22222V18.0881C15.3 18.3303 15.0278 18.4726 14.8289 18.3345L8.39928 13.8695Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
  </div>

  <div class="search__pagination">
    <ul class="search__list">
        <li class="search__item search__item--disabled">
            <svg class="search__arrow-prev" width="9" height="14" viewBox="0 0 9 14" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12.3433L3.43725 7L9 1.645L7.28745 0L0 7L7.28745 14L9 12.3433Z"/>
            </svg>
            Назад
        </li>
        <li class="search__item">1</li>
        <li class="search__item">2</li>
        <li class="search__item">3</li>
        <li class="search__item">4</li>
        <li class="search__item">5</li>
        <li class="search__item">6</li>
        <li class="search__item">7</li>
        <li class="search__item">8</li>
        <li class="search__item">9</li>
        <li class="search__item">10</li>
        <li class="search__item">
            Вперёд
            <svg class="search__arrow-next" width="9" height="14" viewBox="0 0 9 14" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 12.3433L5.56275 7L0 1.645L1.71255 0L9 7L1.71255 14L0 12.3433Z"/>
            </svg>
        </li>
    </ul>
  </div>
</main>

<?php 
  get_footer(  );
?>