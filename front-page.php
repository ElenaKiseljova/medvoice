<?php 
  /**
   * Template Name: Главная
   */
?>

<?php 
  get_header(  );
?>


<main class="main">  
  <?php 
  $medvoice_user = wp_get_current_user(  );
  // update_user_meta($medvoice_user->ID, '_new_user', '1');
  // update_user_meta($medvoice_user->ID, 'st', time());
  // delete_metadata( 'user', $medvoice_user->ID, 'subscribed_days' );
  // var_dump( get_user_meta( $medvoice_user->ID ) );
  
  //echo wp_get_session_token();

  // if ( class_exists('WP_Session_Tokens') ) {
  //   $manager = WP_Session_Tokens::get_instance( get_current_user_id() );

  //   var_dump($manager);
  // }
  

  // echo '<br><br>';


  // $wp_sessions = wp_get_all_sessions() ?? [];

  //   foreach ($wp_sessions as $key => $wp_session) {
  //     var_dump($wp_session);
  //     echo '<br><br>';
      
  //     // echo date('Y-m-d H:i:s', utc_to_usertime($wp_session['expiration'])) . '<br>';
  //   }

    // echo medvoice_get_user_subscribe_end_date();
  ?>
  
  <?php 
    get_template_part( 'templates/front/banner' );
  ?>

  <section class="slider" id="courses">
    <div class="swiper swiper-courses">
        <div class="slider__head">
            <h2 class="slider__title">
                Курсы
            </h2>
            <a href="#" class="slider__link">
                Смотреть все курсы
            </a>
        </div>
        <div class="swiper-wrapper">
            <a href="#" class="swiper-slide card">
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
            <div class="swiper-slide card">
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
            <a href="#" class="swiper-slide card">
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
            <div class="swiper-slide card">
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
            <a href="#" class="swiper-slide card">
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
            <div class="swiper-slide card">
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
            <a href="#" class="swiper-slide card">
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
            <div class="swiper-slide card">
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
        <div class="slider__btn-box">
            <svg class="slider__btn-prev" width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 30C6.73838 30 1.90735e-06 23.2874 1.90735e-06 15C1.90735e-06 6.71256 6.73838 0 15 0C23.2616 0 30 6.73838 30 15C30 23.2616 23.2616 30 15 30ZM15 2.11704C7.90017 2.11704 2.11704 7.90017 2.11704 15C2.11704 22.0998 7.90017 27.883 15 27.883C22.0998 27.883 27.883 22.0998 27.883 15C27.883 7.90017 22.0998 2.11704 15 2.11704Z"/>
                <path d="M18.4595 22.4872C18.2529 22.6938 17.9948 22.797 17.7108 22.797C17.4526 22.797 17.1686 22.6938 16.9621 22.4872L10.1462 15.6714C9.93968 15.4649 9.83641 15.2067 9.83641 14.9227C9.83641 14.6387 9.93968 14.3805 10.1462 14.174L16.9621 7.35815C17.3751 6.94507 18.0464 6.94507 18.4595 7.35815C18.8726 7.77123 18.8726 8.44249 18.4595 8.85557L12.3924 14.9227L18.4595 20.9898C18.8726 21.4029 18.8726 22.0742 18.4595 22.4872V22.4872Z"/>
            </svg> 
            <svg class="slider__btn-next" width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 30C23.2616 30 30 23.2874 30 15C30 6.71256 23.2616 0 15 0C6.73838 0 0 6.73838 0 15C0 23.2616 6.73838 30 15 30ZM15 2.11704C22.0998 2.11704 27.883 7.90017 27.883 15C27.883 22.0998 22.0998 27.883 15 27.883C7.90017 27.883 2.11704 22.0998 2.11704 15C2.11704 7.90017 7.90017 2.11704 15 2.11704Z"/>
                <path d="M11.5405 22.4872C11.7471 22.6938 12.0052 22.797 12.2892 22.797C12.5474 22.797 12.8314 22.6938 13.0379 22.4872L19.8538 15.6714C20.0603 15.4649 20.1636 15.2067 20.1636 14.9227C20.1636 14.6387 20.0603 14.3805 19.8538 14.174L13.0379 7.35815C12.6249 6.94507 11.9536 6.94507 11.5405 7.35815C11.1274 7.77123 11.1274 8.44249 11.5405 8.85557L17.6076 14.9227L11.5405 20.9898C11.1274 21.4029 11.1274 22.0742 11.5405 22.4872V22.4872Z"/>
            </svg>
        </div>
    </div>
  </section>
  <section class="slider" id="webinars">
    <div class="swiper swiper-webinar">
        <div class="slider__head">
            <h2 class="slider__title">
                Вебинары
            </h2>
            <a href="#" class="slider__link">
                Смотреть все вебинары
            </a>
        </div>
        <div class="swiper-wrapper">
            <a href="#" class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-3.jpg" alt="hospital">
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
                                Вебинар
                            </p>
                            <p class="card__description-text">
                                02:30:00
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
            <div class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-4.jpg" alt="hospital">
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
                                Вебинар
                            </p>
                            <p class="card__description-text">
                                02:30:00
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
            <a href="#" class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-3.jpg" alt="hospital">
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
                                Вебинар
                            </p>
                            <p class="card__description-text">
                                02:30:00
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
            <div class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-4.jpg" alt="hospital">
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
                                Вебинар
                            </p>
                            <p class="card__description-text">
                                02:30:00
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
            <a href="#" class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-3.jpg" alt="hospital">
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
                                Вебинар
                            </p>
                            <p class="card__description-text">
                                02:30:00
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
            <div class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-4.jpg" alt="hospital">
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
                                Вебинар
                            </p>
                            <p class="card__description-text">
                                02:30:00
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
        <div class="slider__btn-box">
            <svg class="slider__btn-prev" width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 30C6.73838 30 1.90735e-06 23.2874 1.90735e-06 15C1.90735e-06 6.71256 6.73838 0 15 0C23.2616 0 30 6.73838 30 15C30 23.2616 23.2616 30 15 30ZM15 2.11704C7.90017 2.11704 2.11704 7.90017 2.11704 15C2.11704 22.0998 7.90017 27.883 15 27.883C22.0998 27.883 27.883 22.0998 27.883 15C27.883 7.90017 22.0998 2.11704 15 2.11704Z"/>
                <path d="M18.4595 22.4872C18.2529 22.6938 17.9948 22.797 17.7108 22.797C17.4526 22.797 17.1686 22.6938 16.9621 22.4872L10.1462 15.6714C9.93968 15.4649 9.83641 15.2067 9.83641 14.9227C9.83641 14.6387 9.93968 14.3805 10.1462 14.174L16.9621 7.35815C17.3751 6.94507 18.0464 6.94507 18.4595 7.35815C18.8726 7.77123 18.8726 8.44249 18.4595 8.85557L12.3924 14.9227L18.4595 20.9898C18.8726 21.4029 18.8726 22.0742 18.4595 22.4872V22.4872Z"/>
            </svg> 
            <svg class="slider__btn-next" width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 30C23.2616 30 30 23.2874 30 15C30 6.71256 23.2616 0 15 0C6.73838 0 0 6.73838 0 15C0 23.2616 6.73838 30 15 30ZM15 2.11704C22.0998 2.11704 27.883 7.90017 27.883 15C27.883 22.0998 22.0998 27.883 15 27.883C7.90017 27.883 2.11704 22.0998 2.11704 15C2.11704 7.90017 7.90017 2.11704 15 2.11704Z"/>
                <path d="M11.5405 22.4872C11.7471 22.6938 12.0052 22.797 12.2892 22.797C12.5474 22.797 12.8314 22.6938 13.0379 22.4872L19.8538 15.6714C20.0603 15.4649 20.1636 15.2067 20.1636 14.9227C20.1636 14.6387 20.0603 14.3805 19.8538 14.174L13.0379 7.35815C12.6249 6.94507 11.9536 6.94507 11.5405 7.35815C11.1274 7.77123 11.1274 8.44249 11.5405 8.85557L17.6076 14.9227L11.5405 20.9898C11.1274 21.4029 11.1274 22.0742 11.5405 22.4872V22.4872Z"/>
            </svg>
        </div>
    </div>
  </section>
  <section class="slider" id="lections">
    <div class="swiper swiper-lecture">
        <div class="slider__head">
            <h2 class="slider__title">
                Смотреть бесплатные лекции
            </h2>
            <a href="#" class="slider__link">
                Смотреть все лекции
            </a>
        </div>
        <div class="swiper-wrapper">
            <a href="#" class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-5.jpg" alt="hospital">
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
                                Лекция
                            </p>
                            <p class="card__description-text">
                                00:30:00
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
            <div class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-6.jpg" alt="hospital">
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
                                Лекция
                            </p>
                            <p class="card__description-text">
                                00:30:00
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
            <a href="#" class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-5.jpg" alt="hospital">
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
                                Лекция
                            </p>
                            <p class="card__description-text">
                                00:30:00
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
            <div class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-6.jpg" alt="hospital">
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
                                Лекция
                            </p>
                            <p class="card__description-text">
                                00:30:00
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
            <a href="#" class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-5.jpg" alt="hospital">
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
                                Лекция
                            </p>
                            <p class="card__description-text">
                                00:30:00
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
            <div class="swiper-slide card">
                <div class="card__link-box">
                    <img class="card__img" src="<?= get_template_directory_uri(  ); ?>/assets/img/card-6.jpg" alt="hospital">
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
                                Лекция
                            </p>
                            <p class="card__description-text">
                                00:30:00
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
        <div class="slider__btn-box">
            <svg class="slider__btn-prev" width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 30C6.73838 30 1.90735e-06 23.2874 1.90735e-06 15C1.90735e-06 6.71256 6.73838 0 15 0C23.2616 0 30 6.73838 30 15C30 23.2616 23.2616 30 15 30ZM15 2.11704C7.90017 2.11704 2.11704 7.90017 2.11704 15C2.11704 22.0998 7.90017 27.883 15 27.883C22.0998 27.883 27.883 22.0998 27.883 15C27.883 7.90017 22.0998 2.11704 15 2.11704Z"/>
                <path d="M18.4595 22.4872C18.2529 22.6938 17.9948 22.797 17.7108 22.797C17.4526 22.797 17.1686 22.6938 16.9621 22.4872L10.1462 15.6714C9.93968 15.4649 9.83641 15.2067 9.83641 14.9227C9.83641 14.6387 9.93968 14.3805 10.1462 14.174L16.9621 7.35815C17.3751 6.94507 18.0464 6.94507 18.4595 7.35815C18.8726 7.77123 18.8726 8.44249 18.4595 8.85557L12.3924 14.9227L18.4595 20.9898C18.8726 21.4029 18.8726 22.0742 18.4595 22.4872V22.4872Z"/>
            </svg> 
            <svg class="slider__btn-next" width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 30C23.2616 30 30 23.2874 30 15C30 6.71256 23.2616 0 15 0C6.73838 0 0 6.73838 0 15C0 23.2616 6.73838 30 15 30ZM15 2.11704C22.0998 2.11704 27.883 7.90017 27.883 15C27.883 22.0998 22.0998 27.883 15 27.883C7.90017 27.883 2.11704 22.0998 2.11704 15C2.11704 7.90017 7.90017 2.11704 15 2.11704Z"/>
                <path d="M11.5405 22.4872C11.7471 22.6938 12.0052 22.797 12.2892 22.797C12.5474 22.797 12.8314 22.6938 13.0379 22.4872L19.8538 15.6714C20.0603 15.4649 20.1636 15.2067 20.1636 14.9227C20.1636 14.6387 20.0603 14.3805 19.8538 14.174L13.0379 7.35815C12.6249 6.94507 11.9536 6.94507 11.5405 7.35815C11.1274 7.77123 11.1274 8.44249 11.5405 8.85557L17.6076 14.9227L11.5405 20.9898C11.1274 21.4029 11.1274 22.0742 11.5405 22.4872V22.4872Z"/>
            </svg>
        </div>
    </div>
  </section>
</main>

<?php 
  get_footer(  );
?>