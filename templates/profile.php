<?php if ( is_user_logged_in(  ) ) : ?>
  <?php 
    $medvoice_user = wp_get_current_user(  );

    $name = !empty($medvoice_user->first_name) ? $medvoice_user->first_name : $medvoice_user->nickname;
  ?>
  <div class="header__user">
    <div class="profile">
      <?php if (medvoice_user_have_subscribe_trial()) : ?>
        <p class="profile__trial">
          <?=
            sprintf( __( 'Осталось %s%s дней%s триала', 'medvoice' ), 
              '<span class="header__trial-count">',
              medvoice_get_user_subscribe_or_trial_days_left(),
              '</span>'
            );
          ?>        
        </p>
      <?php endif; ?>
      
      <?php 
        $medvoice_avatar = $medvoice_user->get( 'avatar' );
      ?>
      <div class="profile__avatar <?= medvoice_have_user_avatar(  ) ? '' : 'profile__avatar--empty'; ?>">
        <?php if( medvoice_have_user_avatar(  ) ) : ?>
          <img class="profile__avatar-img" src="<?= medvoice_get_user_avatar(  ); ?>" alt="<?= $name; ?>">
        <?php else : ?>
          <img class="profile__avatar-img" src="<?= get_template_directory_uri(  ); ?>/assets/img/avatar-default.svg" alt="<?= $name; ?>">
        <?php endif; ?>                 
      </div>
      <p class="profile__username">
        <?= $name; ?>
      </p>

      <div class="profile__menu">
        <ul class="profile__list">
          <li class="profile__item">
            <a class="profile__item-link" href="<?= medvoice_get_special_page( 'profile', 'url' ); ?>">
              <svg class="profile__icon" width="20" height="20">
                <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#profile"></use>
              </svg>
              <p class="profile__text"><?= __( 'Профиль', 'medvoice' ); ?></p>
            </a>
          </li>
          <li class="profile__item">
            <a class="profile__item-link" href="<?= medvoice_get_special_page( 'bookmarks', 'url' ); ?>">
              <svg class="profile__icon" width="20" height="20">
                <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#bookmarks"></use>
              </svg>
              <p class="profile__text"><?= __( 'Закладки', 'medvoice' ); ?></p>
            </a>
          </li>          
          <li class="profile__item">
            <a class="profile__item-link" href="<?= wp_logout_url( home_url() ); ?>">
              <svg class="profile__icon" width="20" height="20">
                <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#exit"></use>
              </svg>
              <p class="profile__text"><?= __( 'Выйти', 'medvoice' ); ?></p>
            </a>
          </li>
        </ul>
      </div>
    </div>    
  </div>
<?php else: ?>
  <div class="header__guest-mode">
    <a href="<?= medvoice_get_special_page( 'forms', 'url'  ); ?>?action=register" class="button button--subscribe"><?= __( 'Оформить подписку', 'medvoice' ); ?></a>
    <a href="<?= wp_login_url(  ); ?>" class="button button--login"><?= __( 'Log in', 'medvoice' ); ?></a>
  </div>
<?php endif; ?> 