<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <?php
    wp_head();
  ?>
</head>

<body>
  <?php if (is_user_logged_in(  )) : ?>
    <?php 
      $medvoice_user = wp_get_current_user(  );
    ?>
    <h2><?= $medvoice_user->nickname; ?></h2>

    <a href="<?= wp_logout_url( home_url() ); ?>">
      <?= __( 'Выйти', 'medvoice' ); ?>
    </a>
  <?php else : ?>
    <p>
      <a href="<?= wp_login_url(  ); ?>">
        <?= __( 'Войти', 'medvoice' ); ?>
      </a>
    </p>
    
    <p>
      <a href="<?= wp_registration_url(); ?>">
        <?= __( 'Зарегистрироваться', 'medvoice' ); ?>
      </a>
    </p>

    <?php 
      if ( isset($_GET['action']) ) {
        $email = null;

        $action = $_GET['action'];

        switch ( $_GET['action'] ) {
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

        ?>
          

          <form class="form form--<?= $action; ?>" action="" id="<?= $action; ?>">
            <!-- Если это отдельные стр, то h1, если нет - h2 -->
            <h1 class="form__title"><?= $title; ?></h1>

            <div class="form__content">
              <div class="form__google">
                <?php 
                  /**
                   * hooked login_button (Google Log In plugin)
                   */

                  do_action( 'login_form' ); 
                ?>
              </div>
              
              <?php if ( $action === 'register' || $action === 'trial' ) : ?>
                <p class="form__row">
                  <label class="form__label" for="nickname"><?= __( 'Имя', 'medvoice' ); ?></label>
                  <input class="form__field" type="text" name="nickname" id="nickname" placeholder="<?= __( 'Введите ваше имя', 'medvoice' ); ?>">
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
                        '/?action=forgot'
                    ); 
                  ?>  
                </p>
              <?php endif; ?>

              <?php if ( $action === 'reset' && isset($_GET['key']) && isset($_GET['login']) ) : ?>
                <input type="hidden" name="key" value="<?= $_GET['key']; ?>">
                <input type="hidden" name="login" value="<?= $_GET['login']; ?>">
              <?php endif; ?> 

              <button class="form__button form__button--<?= $action; ?> button" type="submit">
                <?= $button; ?>         
              </button>
              
              <!-- Это не надо стилизовать (старт) -->
              <div class="text" id="ajax-response"></div>
              <!-- Это не надо стилизовать (конец) -->
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
                      '/?action=trial'
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
      }  
    ?>   

  <?php endif; ?>
  