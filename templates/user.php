<?php 
      $medvoice_user = wp_get_current_user(  );
    ?>
    <!-- <h2><?= $medvoice_user->nickname; ?></h2>

    <a href="<?= wp_logout_url( home_url() ); ?>">
      <?= __( 'Выйти', 'medvoice' ); ?>
    </a>
  
    <p>
      <a href="<?= wp_login_url(  ); ?>">
        <?= __( 'Войти', 'medvoice' ); ?>
      </a>
    </p>
    
    <p>
      <a href="<?= wp_registration_url(); ?>">
        <?= __( 'Зарегистрироваться', 'medvoice' ); ?>
      </a>
    </p> -->

<?php if ( is_user_logged_in(  ) ) : ?>
  <?php 
    $medvoice_user = wp_get_current_user(  );
  ?>
  <div class="header__user">
    <p class="header__trial-text hidden">
      Осталось <span class="header__trial-count">7 дней</span> триала
    </p>
    <div class="header-profile">
      <div class="header-profile__avatar">
        <div class="header__avatar-img-container">
          <img class="header__avatar-img" src="<?= get_template_directory_uri(  ); ?>/assets/img/avatar-default.svg" alt="<?= $medvoice_user->nickname; ?>">
        </div>          
      </div>
      <p class="header-profile__username">
        <?= $medvoice_user->nickname; ?> <br> <?= medvoice_get_user_subscribe_days_left(); ?> <br> <?= medvoice_get_user_subscribe_end_date();?>
      </p>
      <?php var_dump(medvoice_check_user_subscribe_trial()); ?>
    </div>
    <div class="header-profile__menu hidden">
        <ul class="header-profile__list">
            <li class="header-profile__item">
              <a class="header-profile__item-link" href="<?= get_special_page_url( 'bookmarks' ); ?>?user=<?= $medvoice_user->ID; ?>">
                <svg class="header-profile__icon" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.2857 3H5.71429C5.25963 3 4.82359 3.16389 4.5021 3.45561C4.18061 3.74733 4 4.143 4 4.55556V16.0657C4 16.4651 4.44507 16.7033 4.77735 16.4818L9.72265 13.1849C9.8906 13.0729 10.1094 13.0729 10.2773 13.1849L15.2227 16.4818C15.5549 16.7033 16 16.4651 16 16.0657V4.55556C16 3.69222 15.2286 3 14.2857 3Z"/>
                </svg>
                <p class="header-profile__text"><?= __( 'Закладки', 'medvoice' ); ?></p>
              </a>
            </li>
            <li class="header-profile__item">
              <a class="header-profile__item-link" href="<?= get_special_page_url( 'profile' ); ?>?user=<?= $medvoice_user->ID; ?>">
                <svg class="header-profile__icon" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.33333 13.8889C5.33333 12.3333 8.44444 11.4778 10 11.4778C11.5556 11.4778 14.6667 12.3333 14.6667 13.8889V14.1667C14.6667 14.4428 14.4428 14.6667 14.1667 14.6667H5.83333C5.55719 14.6667 5.33333 14.4428 5.33333 14.1667V13.8889ZM12.3333 7.66667C12.3333 8.28551 12.0875 8.879 11.6499 9.31658C11.2123 9.75417 10.6188 10 10 10C9.38116 10 8.78767 9.75417 8.35008 9.31658C7.9125 8.879 7.66667 8.28551 7.66667 7.66667C7.66667 7.04783 7.9125 6.45434 8.35008 6.01675C8.78767 5.57917 9.38116 5.33333 10 5.33333C10.6188 5.33333 11.2123 5.57917 11.6499 6.01675C12.0875 6.45434 12.3333 7.04783 12.3333 7.66667ZM3 4.55556V15.4444C3 15.857 3.16389 16.2527 3.45561 16.5444C3.74733 16.8361 4.143 17 4.55556 17H15.4444C15.857 17 16.2527 16.8361 16.5444 16.5444C16.8361 16.2527 17 15.857 17 15.4444V4.55556C17 4.143 16.8361 3.74733 16.5444 3.45561C16.2527 3.16389 15.857 3 15.4444 3H4.55556C3.69222 3 3 3.7 3 4.55556Z"/>
                </svg>
                <p class="header-profile__text"><?= __( 'Профиль', 'medvoice' ); ?></p>
              </a>
            </li>
            <li class="header-profile__item">
              <a class="header-profile__item-link" href="<?= wp_logout_url( home_url() ); ?>">
                <svg class="header-profile__icon" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.4444 3H4.55556C3.69222 3 3 3.69222 3 4.55556V7.66667H4.55556V4.55556H15.4444V15.4444H4.55556V12.3333H3V15.4444C3 15.857 3.16389 16.2527 3.45561 16.5444C3.74733 16.8361 4.143 17 4.55556 17H15.4444C15.857 17 16.2527 16.8361 16.5444 16.5444C16.8361 16.2527 17 15.857 17 15.4444V4.55556C17 3.69222 16.3 3 15.4444 3ZM8.50667 12.7844L9.61111 13.8889L13.5 10L9.61111 6.11111L8.50667 7.20778L10.5211 9.22222H3V10.7778H10.5211L8.50667 12.7844Z"/>
                </svg>
                <p class="header-profile__text"><?= __( 'Выйти', 'medvoice' ); ?></p>
              </a>
            </li>
        </ul>
    </div>
  </div>
<?php else: ?>
  <div class="header__guest-mode">
    <a href="<?= get_special_page_url(  ); ?>?action=trial" class="button button--subscribe"><?= __( 'Оформить подписку', 'medvoice' ); ?></a>
    <a href="<?= wp_login_url(  ); ?>" class="button button--login"><?= __( 'Log in', 'medvoice' ); ?></a>
  </div>
<?php endif; ?> 