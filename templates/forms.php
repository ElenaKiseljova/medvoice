<?php 
  // Если Подписка или Триал закончились - устанавливаем значения гет параметров для отображения нужной формы
  $subscribe_ended = is_user_logged_in(  ) && !medvoice_user_have_subscribe_trial() && !medvoice_user_have_subscribe();

  if ( $subscribe_ended ) {
    $_GET['action'] = 'success';
    $_GET['type'] = 'end';    
  }

  if ( isset($_GET['action']) && (!is_user_logged_in(  ) || $subscribe_ended ) ) {
    $email = null;

    $action = $_GET['action'];

    switch ( $action ) {
      case 'login':            
        $title = __( 'Войдите в свой аккаунт', 'medvoice' );
        $button = __( 'Войти', 'medvoice' );
        $password = __( 'Введите ваш пароль', 'medvoice' );

        break;
      
      case 'register':
        $title = __( 'Создайте аккаунт', 'medvoice' );
        $button = __( 'Начать регистрацию', 'medvoice' );
        $password = __( 'Придумайте пароль', 'medvoice' );

        break;

      case 'trial':
        $title = __( 'Создайте аккаунт', 'medvoice' );
        $button = __( 'Оформить триал', 'medvoice' );
        $password = __( 'Придумайте пароль', 'medvoice' );

        $email = isset($_GET['email']) ? strip_tags($_GET['email']) : null;

        break;
      
      case 'forgot':
        $title = __( 'Забыли пароль?', 'medvoice' );
        $button = __( 'Восстановить', 'medvoice' );

        break;
      
      case 'reset':
        $title = __( 'Создайте новый пароль', 'medvoice' );
        $button = __( 'Сохранить', 'medvoice' );
        $password = '';

        break;       
      
      default:
        $title = '';
        $button = '';
        $password = '';
        
        break;
    }

    if ( $action !== 'success' ) {
      ?>      

        <form class="form form--<?= $action; ?>" id="<?= $action; ?>">
          <h1 class="form__title"><?= $title; ?></h1>

          <div class="form__content">
            <?php if ( $action === 'register' || $action === 'trial' || $action === 'login' ) : ?>
              <div class="form__google">
                <?php 
                  /**
                   * hooked login_button (Google Log In plugin)
                   */

                  do_action( 'login_form' );  
                ?>
              </div>
            <?php endif; ?>          
            
            <?php if ( $action === 'register' || $action === 'trial' ) : ?>
              <p class="form__row">
                <label class="form__label" for="first_name"><?= __( 'Имя', 'medvoice' ); ?></label>
                <input class="form__field" type="text" name="first_name" id="first_name" placeholder="<?= __( 'Введите ваше имя', 'medvoice' ); ?>">
              </p>
            <?php endif; ?>            
            
            <?php if ( $action !== 'reset' ) : ?>
              <p class="form__row">
                <label class="form__label" for="email"><?= __( 'Логин', 'medvoice' ); ?></label>
                <input class="form__field" type="email" name="email" id="email" placeholder="<?= __( 'Введите ваш email', 'medvoice' ); ?>" <?= isset($email) ? 'value="' . $email . '"' : ''; ?>>
              </p>
            <?php endif; ?>               
            
            <?php if ( $action !== 'forgot' ) : ?>
              <p class="form__row">
                <label class="form__label" for="password"><?= __( 'Пароль', 'medvoice' ); ?></label>
                <input class="form__field" type="password" name="password" id="password" placeholder="<?= $password; ?>">
              </p>
            <?php endif; ?>   
            
            <?php if ( $action === 'reset' ) : ?>
              <p class="form__row">
                <label class="form__label" for="password-confirm"><?= __( 'Подтвердите пароль', 'medvoice' ); ?></label>
                <input class="form__field" type="password" name="password-confirm" id="password-confirm" placeholder="<?= $password; ?>">
              </p>
            <?php endif; ?> 
            
            <?php if ( $action === 'login' ) : ?>
              <p class="form__text text">
                <?= 
                  sprintf(
                    __( '<a href="%s">Забыли пароль</a>', 'medvoice' ),
                    medvoice_get_special_page( 'forms', 'url'  ) . '?action=forgot'
                  ); 
                ?>  
              </p>
            <?php endif; ?>

            <?php if ( $action === 'reset' && isset($_GET['key']) && isset($_GET['login']) ) : ?>
              <input type="hidden" name="key" value="<?= $_GET['key']; ?>">
              <input type="hidden" name="login" value="<?= $_GET['login']; ?>">
            <?php elseif( $action === 'register' ) : ?>
              <input type="hidden" name="subscribe" value="1">
            <?php endif; ?> 

            <button class="form__button form__button--<?= $action; ?> button" type="submit">
              <?= $button; ?>         
            </button>
            
            <div class="text text--ajax" id="ajax-response"></div>
          </div>            
        </form>
        
        <p class="text text--subform">
          <?php if ( $action === 'login' ) : ?>
            <?= 
                sprintf(
                  __( 'Ещё нет аккаунта? 
                        <a href="%s">Оформите подписку</a> 
                        или 
                        <a href="%s">триальную версию</a>', 'medvoice' 
                    ),
                    wp_registration_url(),
                    medvoice_get_special_page( 'forms', 'url'  ) . '?action=trial'
                ); 
              ?>  
          <?php elseif( $action === 'reset' ) : ?>
            <?= 
              sprintf(
                __( '<a href="%s">
                      <svg width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.75723 11.7639C6.59538 11.9213 6.39306 12 6.17052 12C5.96821 12 5.74566 11.9213 5.58381 11.7639L0.242774 6.57049C0.080924 6.41312 0 6.21639 0 6C0 5.78361 0.080924 5.58689 0.242774 5.42951L5.58381 0.236066C5.90751 -0.0786885 6.43353 -0.0786885 6.75723 0.236066C7.08092 0.55082 7.08092 1.06229 6.75723 1.37705L2.00289 6L6.75723 10.623C7.08092 10.9377 7.08092 11.4492 6.75723 11.7639Z"/>
                      </svg>
                      Вернуться на страницу входа
                    </a>', 'medvoice' 
                  ),
                  medvoice_get_special_page( 'forms', 'url'  ) . '?action=login'
              ); 
            ?> 
          <?php else : ?>
            <?= 
                sprintf(
                  __( '<a href="%s">Войти</a>  в существующий аккаунт' ),
                    wp_login_url(  )
                ); 
              ?> 
          <?php endif; ?>
        </p>
      
      <?php
    } else {
      $type = $_GET['type'];

      switch ( $type ) {
        case 'forgot':    
          $email = $_GET['email'] ?? '';

          $title = __( 'Проверьте свою почту', 'medvoice' );

          $description = sprintif( __( 'Мы отправили ссылку для восстановления пароля на почту %s', 'medvoice' ), $email );

          $button_text = __( 'Открыть почту', 'medvoice' );
          $button_link = 'mailto:' . $email;
  
          break;

        case 'reset':    
          $title = __( 'Пароль восстановлен', 'medvoice' );

          $description = __( 'Вы успешно создали новый пароль. Пожалуйста, войдите заново в свой профиль', 'medvoice' );

          $button_text = __( 'Войти', 'medvoice' );
          $button_link = medvoice_get_special_page( 'forms', 'url'  ) . '?action=login';          
  
          break;  
        
        case 'register':    
          $image = get_template_directory_uri(  ) . '/assets/img/vector-confirm.svg';

          $title = __( 'Подтвердите свою почту', 'medvoice' );

          $description = __( 'Мы отправили вам письмо с верификационной ссылкой. Вам необходимо подтвердить почту.', 'medvoice' );       
  
          break; 

        case 'end':   
          $image = get_template_directory_uri(  ) . '/assets/img/vector-trial.svg';

          if ( medvoice_user_was_subscribed() ) {
            $title = __( 'Срок действия вашей подписки вышел', 'medvoice' );

            $description = __( 'Чтобы продолжить пользоваться платформой, необходимо продлить подписку', 'medvoice' );             
          } else {
            $title = __( 'Срок действия вашей триальной версии вышел', 'medvoice' );

            $description = __( 'Чтобы продолжить пользоваться платформой, необходимо оформить подписку', 'medvoice' );
          }

          $button_text = __( 'Оформить подписку', 'medvoice' );
          $button_link = medvoice_get_special_page( 'tariffs', 'url'  );      
  
          break; 
        
        default:
          $image = '';

          $title = '';

          $description = '';

          $button_text = '';
          $button_link = '';
          
          break;
      }
      ?>
        <div class="form form--div">
          <?php if ( !empty($image) ) : ?>
            <div class="form__img-box">
              <img class="form__img" src="<?= $image; ?>" alt="<?= strip_tags($title); ?>">
            </div>
          <?php endif; ?>          

          <h1 class="form__title form__title--margin">
            <?= $title; ?>
          </h1>

          <div class="form__content form__content--width">    
            <p class="text text--size">
              <?= $description; ?>
            </p>

            <?php if ( !empty($button_text) && !empty($button_link) ) : ?>
              <a class="form__button button button--link" href="<?= $button_link; ?>">
                <?= $button_text; ?>        
              </a>
            <?php endif; ?>            
          </div>            
        </div>
        
        <?php if ( $type === 'forgot' ) : ?>
          <p class="text text--subform">
            <?= 
              sprintf(
                __( '<a href="%s">
                      <svg width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.75723 11.7639C6.59538 11.9213 6.39306 12 6.17052 12C5.96821 12 5.74566 11.9213 5.58381 11.7639L0.242774 6.57049C0.080924 6.41312 0 6.21639 0 6C0 5.78361 0.080924 5.58689 0.242774 5.42951L5.58381 0.236066C5.90751 -0.0786885 6.43353 -0.0786885 6.75723 0.236066C7.08092 0.55082 7.08092 1.06229 6.75723 1.37705L2.00289 6L6.75723 10.623C7.08092 10.9377 7.08092 11.4492 6.75723 11.7639Z"/>
                      </svg>
                      Вернуться на страницу входа
                    </a>', 'medvoice' 
                  ),
                  medvoice_get_special_page( 'forms', 'url'  ) . '?action=login'
              ); 
            ?>  
          </p>
        <?php else : ?>
            
        <?php endif; ?>        
      <?php
    }    
  }  
?>