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
      Выйти
    </a>
  <?php else : ?>
    <p>
      <a href="<?= wp_login_url(  ); ?>">
        Войти
      </a>
    </p>
    
    <p>
      <a href="<?= wp_registration_url(); ?>">
        Зарегистрироваться
      </a>
    </p>

    <?php 
      /**
       * hooked login_button (Google Log In plugin)
       */

      do_action( 'login_form' ); 
    ?>

  <style>
    .error input {
      border-color: red;
    }
  </style>

    <?php 
      if ( isset($_GET['action']) ) {
        $action = $_GET['action'];

        switch ( $_GET['action'] ) {
          case 'login':            
            $title = 'Войдите в свой аккаунт';
            $button = 'Войти';
            $password = 'Введите ваш пароль';

            break;
          
          case 'register':
            $title = 'Создайте аккаунт';
            $button = 'Начать регистрацию';
            $password = 'Придумайте пароль';

            break;

          case 'trial':
            $title = 'Создайте аккаунт';
            $button = 'Оформить триал';
            $password = 'Придумайте пароль';

            break;
          
          default:
            $title = '';
            $button = '';
            $password = '';
            
            break;
        }

        ?>
          <h3><?= $title; ?></h3>

          <form action="" id="<?= $action; ?>">
            <?php if ( $action !== 'login' ) : ?>
              <p>
                <label for="nickname">Имя</label>
                <input type="text" name="nickname" id="nickname" placeholder="Введите ваше имя">
              </p>
            <?php endif; ?>            

            <p>
              <label for="email">Логин</label>
              <input type="email" name="email" id="email" placeholder="Введите ваш email">
            </p>

            <p>
              <label for="password">Пароль</label>
              <input type="password" name="password" id="password" placeholder="<?= $password; ?>">
            </p>

            <?php if ( $action === 'trial' ) : ?>
              <input type="hidden" name="trial" value="1">
            <?php endif; ?>

            <button type="submit">
              <?= $button; ?>         
            </button>

            <div id="ajax-response"></div>
          </form>

          <?php if ( $action === 'login' ) : ?>
            <p>Ещё нет аккаунта? <a href="<?= wp_registration_url(); ?>">Оформите подписку</a> или <a href="/?action=trial">триальную версию</a></p>
          <?php else : ?>
            <p><a href="<?= wp_login_url(  ); ?>">Войти</a> в существующий аккаунт</p>
          <?php endif; ?>
        <?php
      }  
    ?>   

  <?php endif; ?>
  