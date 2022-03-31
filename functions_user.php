<?php 
if( wp_doing_ajax() ) {
  if (!is_user_logged_in()) {
    add_action('wp_ajax_medvoice_ajax_login', 'medvoice_ajax_login');
    add_action('wp_ajax_nopriv_medvoice_ajax_login', 'medvoice_ajax_login');

    add_action( 'wp_ajax_medvoice_ajax_register_mail', 'medvoice_ajax_register_mail' );
    add_action( 'wp_ajax_nopriv_medvoice_ajax_register_mail', 'medvoice_ajax_register_mail' );  
    
    add_action('wp_ajax_medvoice_ajax_forgot_password', 'medvoice_ajax_forgot_password');
    add_action('wp_ajax_nopriv_medvoice_ajax_forgot_password', 'medvoice_ajax_forgot_password');

    add_action('wp_ajax_medvoice_ajax_reset_password', 'medvoice_ajax_reset_password');
    add_action('wp_ajax_nopriv_medvoice_ajax_reset_password', 'medvoice_ajax_reset_password');     
  } else {
    add_action('wp_ajax_medvoice_ajax_edit_user_info', 'medvoice_ajax_edit_user_info');
    add_action('wp_ajax_nopriv_medvoice_ajax_edit_user_info', 'medvoice_ajax_edit_user_info');   

    add_action('wp_ajax_medvoice_ajax_edit_password', 'medvoice_ajax_edit_password');
    add_action('wp_ajax_nopriv_medvoice_ajax_edit_password', 'medvoice_ajax_edit_password');    
    
    add_action('wp_ajax_medvoice_ajax_add_to_bookmarks', 'medvoice_ajax_add_to_bookmarks');
    add_action('wp_ajax_nopriv_medvoice_ajax_add_to_bookmarks', 'medvoice_ajax_add_to_bookmarks'); 

    add_action('wp_ajax_medvoice_ajax_remove_from_bookmarks', 'medvoice_ajax_remove_from_bookmarks');
    add_action('wp_ajax_nopriv_medvoice_ajax_remove_from_bookmarks', 'medvoice_ajax_remove_from_bookmarks'); 
  }
}

/* ==============================================
********  //Логин
=============================================== */

// Signin
function medvoice_ajax_login()
{
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if($_POST['antibot'] == 1) {
      // Получаем данные из полей формы и проверяем их
      $info = array();

      $info['remember'] = true;

      $info['user_login'] = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
      $info['user_password'] = isset($_POST['password']) ? $_POST['password'] : '';

      if (empty($info['user_login']) || !filter_var($info['user_login'], FILTER_VALIDATE_EMAIL) || !is_email($info['user_login'])) {
        wp_send_json_error(['type' => 'email', 'message' => __('Введите правильный адрес электронной почты', 'medvoice')]);

        die(  );
      }

      if (empty($info['user_password'])) {
        wp_send_json_error(['type' => 'password', 'message' => __('Введите пароль', 'medvoice')]);

        die(  );
      }

      $user_signon = wp_signon($info, false);

      if (is_wp_error($user_signon)) {
        if (!email_exists($info['user_login'])) {
          wp_send_json_error( [
            'message' => __('Неправильный адрес электронной почты', 'medvoice')
          ] );

          die(  );
        } else {
          wp_send_json_error([
            'message' => __('Неправильный логин или пароль', 'medvoice'),
            'error' => $user_signon->get_error_message()
          ]);

          die(  );
        }        
      } else {
        wp_set_current_user($user_signon->ID, $user_signon->user_login);
        wp_set_auth_cookie($user_signon->ID, true);
        
        wp_send_json_success(['message' => __('Отлично! Идет перенаправление...', 'medvoice')]);
      }
    } else {
      wp_send_json_error(['message' => __('Подтвердите, что Вы не робот', 'medvoice')]);
    }   

    die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => $th
    ] );

    die();
  }  
}

/* ==============================================
********  //Регистрация
=============================================== */

// Добавление флага для нового пользователя
add_action('user_register', 'medvoice_register_add_meta');
function medvoice_register_add_meta($user_id) { 
	add_user_meta($user_id, '_new_user', '1');
}

// Sign up (mail)
function medvoice_ajax_register_mail() 
{
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if($_POST['antibot'] == 1) {
      // Получаем данные из полей формы и проверяем их
      $user_login = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
      $user_password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
      $first_name = isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '';
      
      $subscribe = isset($_POST['subscribe']) ? (int) $_POST['subscribe'] : 0;

      if ( empty($user_login) || !filter_var($user_login, FILTER_VALIDATE_EMAIL) || !is_email($user_login) ) {
        wp_send_json_error(['type' => 'email', 'message' => __('Введите правильный адрес электронной почты', 'medvoice')]);

        die(  );  
      } 
      
      if( username_exists($user_login) || email_exists( $user_login ) ) {
        wp_send_json_error(['type' => 'email', 'message' => __('Такой e-mail уже зарегистрирован ранее', 'medvoice')]);

        die(  );  
      }
      
      if ( empty($user_password) ) {
        wp_send_json_error(['type' => 'password', 'message' => __('Введите пароль', 'medvoice')]);

        die(  );  
      } 
      
      if( 7 >= mb_strlen($user_password) ) {
        wp_send_json_error(['type' => 'password', 'message' => __('Пароль должен быть не менее 8 символов.', 'medvoice')]);

        die(  );  
      }

      $confirm_subject = get_bloginfo( 'name' ) . ' - ' . __('Подтверждение e-mail', 'medvoice');

      $key = wp_hash_password( $user_password . ';' . $first_name . ';' . $user_login );

      // Запись в БД пользователя с неподтвержденным мейлом
      if ( class_exists( 'Medvoice' ) ) {
        $medvoice = new Medvoice;

        // Создание таблицы, если ее нет
        $table_unconfirmed_mail_users = $medvoice->insert_table_unconfirmed_mail_users_into_db();

        if ( is_array($table_unconfirmed_mail_users) && $table_unconfirmed_mail_users['success'] === 0 ) {
          wp_send_json_error(['message' => __('Не удалось сохранить Ваши данные (таблица). Пожалуйста, повторите позже: ', 'medvoice') . $table_unconfirmed_mail_users['error'] ]);

          die(  );          
        } else {
          // Запись пароля
          $saved_pass = $medvoice->set_unconfirmed_mail_user_pass( $key, $user_password );

          if ( $saved_pass === false || $saved_pass === 0 ) {
            wp_send_json_error(['message' => __('Не удалось сохранить Ваши данные (строка). Пожалуйста, повторите позже: ', 'medvoice') . $table_unconfirmed_mail_users['error'] ]);

            die(  ); 
          }
        }        
      }
      
      $confirm_link = get_forms_page_url(  ) . '?action=confirm' .
                                         '&key=' . $key . 
                                         '&email=' . rawurlencode($user_login) . 
                                         '&name=' . $first_name .
                                         '&subscribe=' . $subscribe;

      $confirm_text = get_custom_logo() . '<br><br>';
      $confirm_text .= '<p>' . __( 'Приветствуем Вас, ', 'medvoice' ) . '<b>' . $first_name . '</b></p>';
      $confirm_text .= '<p>' . __('Для завершения регистрации, пожалуйста, подтвердите Ваш e-mail.', 'medvoice') . '</p>';
      $confirm_text .= '<p>' . __('Для подтверждения e-mail - перейдите по ссылке ниже: ', 'medvoice') . '</p>';
      $confirm_text .= '<p><a href="' . $confirm_link . '">' . __('Подтвердить e-mail и завершить регистрацию', 'medvoice') . '</a></p>';
      
      $to = $user_login;   

      $site_name = 'From: ' . get_bloginfo( 'name' ) . ' <' . get_option('admin_email') . '>';

      // удалим фильтры, которые могут изменять заголовок $headers
      remove_all_filters( 'wp_mail_from' );
      remove_all_filters( 'wp_mail_from_name' );

      $headers = array(
        $site_name,
        'content-type: text/html',
      );

      wp_mail( $to, $confirm_subject, $confirm_text, $headers );

      wp_send_json_success(['message' => __('Успешный запрос!', 'medvoice')]);
    } else {
      wp_send_json_error(['message' => __('Подтвердите, что Вы не робот', 'medvoice')]);
    }   

    die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => $th
    ] );

    die();
  }
}

// Sign up (confirm)
add_action( 'init', 'medvoice_register' );

function medvoice_register()
{
  if ( !is_user_logged_in(  ) && isset($_GET['action']) && $_GET['action'] === 'confirm' ) {
    $password = null;

    $key = isset($_GET['key']) ? htmlspecialchars($_GET['key']) : null; 
    
    if ( !isset($key) ) {
      echo __('Нет ключа проверки. Проверьте правильность ссылки, которую Вы получили по e-mail.', 'medvoice');

      return false;
    }

    if ( class_exists( 'Medvoice' ) ) {
      $medvoice = new Medvoice;

      // Получение пароля пользователя
      $password = $medvoice->get_unconfirmed_mail_user_pass( $key );

      if ( empty($password) ) {
        echo __('Не удалось получить данные. Пожалуйста, повторите позже', 'medvoice');

        return false;
      } else {
        $password = $password[0];

        // Удаление записи из таблицы с неподтвержденными пользователями
        $password_deteted = $medvoice->delete_unconfirmed_mail_user_info( $key );

        if ( $password_deteted === false || $password_deteted === 0 ) {
          echo __('Не удалось удалить данные. Пожалуйста, повторите позже', 'medvoice');

          return false; 
        } else {
          $email = isset($_GET['email']) ? rawurldecode($_GET['email']) : '';
          $name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';

          if ( empty($email) ) {
            echo __('E-mail не может быть пустым. Проверьте правильность ссылки, которую Вы получили по e-mail.', 'medvoice');

            return false; 
          }

          $userdata = array(
            'user_login'   =>   sanitize_user( $email ),
            'nickname'     =>   sanitize_email( $email ),
            'display_name' =>   sanitize_email( $email ),
            'user_email'   =>   sanitize_email( $email ),
            'user_pass'	   =>   $password,
            'first_name'   =>   $name, 
          );

          $user_id = wp_insert_user( $userdata );

          if( !is_wp_error( $user_id ) ) {            

            wp_new_user_notification( $user_id, null, 'user' );

            $info = array();
            $info['user_login'] = sanitize_email( $email );
            $info['user_password'] = $password;
            $info['remember'] = true;

            $user_signon = wp_signon( $info, false );

            wp_set_current_user( $user_signon->ID, $user_signon->user_login );   

            // Проверка желаемого типа подписки
            $subscribe = $_GET['subscribe'] ? (int) $_GET['subscribe'] : 0;

            $redirect_url = get_home_url(  );
            
            if ( $subscribe === 1 ) {
              $redirect_url = medvoice_get_special_page( 'tariffs', 'url'  ) ?? get_home_url(  );
            }

            wp_redirect( $redirect_url );

            exit();
          } else {
            print_r($user_id);

            return false; 
          }
        }
      }
    }    
  }
}

/* ==============================================
********  //Забыл пароль
=============================================== */
function medvoice_ajax_forgot_password()
{
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if($_POST['antibot'] == 1) {
      $email = isset($_POST['email']) ? $_POST['email'] : '';

      $lostpassword = medvoice_retrieve_password();

      if ( is_wp_error($lostpassword) ) {
        $errors = '';

        foreach ($lostpassword->get_error_messages() as $error) {
            $errors .= $error . PHP_EOL;
        }

        wp_send_json_error(['message' => $errors]);

        die( );
      } else {
        wp_send_json_success([
          'message' => __('Форма отправлена!', 'medvoice' ),
          'email' => $email,
        ]);
      }
    } else {
      wp_send_json_error(['message' => __('Подтвердите, что Вы не робот', 'medvoice')]);
    } 

    die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => __( 'Что-то пошло не так...', 'medvoice'),
      'data' => $th
    ] );

    die();
  }
}

/**
 * Handles sending a password retrieval email to a user.
 *
 * @return true|WP_Error True when finished, WP_Error object on error.
 * @since 2.5.0
 *
 */
function medvoice_retrieve_password()
{
    $errors = new WP_Error();
    $user_data = false;

    if (empty($_POST['email']) || !is_string($_POST['email'])) {
      $errors->add('empty_username', __('Введите ваш адрес электронной почты.', 'medvoice'));
    } elseif (!is_email($_POST['email'])) {
      $errors->add('wrong_username', __('Некорректный емейл.', 'medvoice'));
    } elseif (strpos($_POST['email'], '@')) {
      $user_data = get_user_by('email', trim(wp_unslash($_POST['email'])));

      if (empty($user_data)) {
        $errors->add('invalid_email',
            __('Не найден аккаунт с таким адресом электронной почты.', 'medvoice'));
      }
    }

    /**
     * Fires before errors are returned from a password reset request.
     *
     * @param WP_Error $errors A WP_Error object containing any errors generated
     *                                 by using invalid credentials.
     * @param WP_User|false $user_data WP_User object if found, false if the user does not exist.
     * @since 5.4.0 Added the `$user_data` parameter.
     *
     * @since 2.1.0
     * @since 4.4.0 Added the `$errors` parameter.
     */
    do_action('lostpassword_post', $errors, $user_data);

    /**
     * Filters the errors encountered on a password reset request.
     *
     * The filtered WP_Error object may, for example, contain errors for an invalid
     * username or email address. A WP_Error object should always be returned,
     * but may or may not contain errors.
     *
     * If any errors are present in $errors, this will abort the password reset request.
     *
     * @param WP_Error $errors A WP_Error object containing any errors generated
     *                                 by using invalid credentials.
     * @param WP_User|false $user_data WP_User object if found, false if the user does not exist.
     * @since 5.5.0
     *
     */
    $errors = apply_filters('lostpassword_errors', $errors, $user_data);

    if ($errors->has_errors()) {
      return $errors;
    }

    if (!$user_data) {
      $errors->add('invalidcombo',
          __('Не найден аккаунт с таким адресом электронной почты.', 'medvoice'));
      return $errors;
    }
    // Redefining user_login ensures we return the right case in the email.
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;

    $key = get_password_reset_key($user_data);

    if (is_wp_error($key)) {
      return $key;
    }

    if (is_multisite()) {
      $site_name = get_network()->site_name;
    } else {
        /*
     * The blogname option is escaped with esc_html on the way into the database
     * in sanitize_option. We want to reverse this for the plain text arena of emails.
     */
      $site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    }

    $message = '<p>' . __('Someone has requested a password reset for the following account:') . '</p>';
    /* translators: %s: Site name. */
    $message .= '<p>' . sprintf(__('Site Name: %s'), $site_name) . '</p>';
    /* translators: %s: User login. */
    $message .= '<p>' . sprintf(__('Username: %s'), $user_login) . '</p>';
    $message .= '<p>' . __('If this was a mistake, ignore this email and nothing will happen.') . '</p>';
    $message .= '<p>' . __('To reset your password, visit the following address:') . '</p>';
    $message .= '<p><a href="' . get_forms_page_url(  ) . '?action=reset&key=$key&login=' . rawurlencode($user_login) . '">' . __('Ссылка для установки нового пароля', 'medvoice') . '</a></p>';

    $requester_ip = $_SERVER['REMOTE_ADDR'];
    if ($requester_ip) {
        $message .= sprintf(
            /* translators: %s: IP address of password reset requester. */
                __('This password reset request originated from the IP address %s.'),
                $requester_ip
            ) . "\r\n";
    }

    /* translators: Password reset notification email subject. %s: Site title. */
    $title = sprintf(__('[%s] Password Reset'), $site_name);

    /**
     * Filters the subject of the password reset email.
     *
     * @param string $title Email subject.
     * @param string $user_login The username for the user.
     * @param WP_User $user_data WP_User object.
     * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
     *
     * @since 2.8.0
     */
    $title = apply_filters('retrieve_password_title', $title, $user_login, $user_data);

    /**
     * Filters the message body of the password reset mail.
     *
     * If the filtered message is empty, the password reset email will not be sent.
     *
     * @param string $message Email message.
     * @param string $key The activation key.
     * @param string $user_login The username for the user.
     * @param WP_User $user_data WP_User object.
     * @since 2.8.0
     * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
     *
     */
    $message = apply_filters('retrieve_password_message', $message, $key, $user_login, $user_data);

    if ($message && !wp_mail($user_email, wp_specialchars_decode($title), $message)) {
        $errors->add('retrieve_password_email_failure',
            __('The email could not be sent. Your site may not be correctly configured to send emails.', 'medvoice'));
        return $errors;
    }

    return true;
}

/* ==============================================
********  //Сброс пароля
=============================================== */
function medvoice_ajax_reset_password()
{
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if($_POST['antibot'] == 1) {
      $errors = new WP_Error();

      $pass1 = $_POST['password'];
      $pass2 = $_POST['password-confirm'];
      $key = $_POST['key'];
      $login = $_POST['login'];      

      $user = check_password_reset_key($key, $login);

      if (is_wp_error($user)) {
        $errors->add('invalid_key', sprintf(
          __('Некорректные данные для смены пароля. Проверьте, правильно ли вы скопировали ссылку из письма или отправьте <a href="%s">ещё одно</a>.'),
          add_query_arg('action', 'forgot', medvoice_get_special_page( 'forms', 'url' ))
        ));
      }
        /*else {
        echo 'Ключ прошел проверку. Можно высылать новый пароль на почту.';
      }*/

      // check to see if user added some string
      if (empty($pass1)) {
          $errors->add('password', __('Введите пароль.', 'medvoice'));
      }

      if (empty($pass2)) {
        $errors->add('password-confirm', __('Введите подтверждение пароля.', 'medvoice'));
      }

      if (7 >= mb_strlen($pass1)) {
        $errors->add('password', __('Пароль должен быть не менее 8 символов.', 'medvoice'));
      }
      // is pass1 and pass2 match?
      if ($pass1 != $pass2) {
        $errors->add('password-confirm', __('Пароли не совпадают.', 'medvoice'));
      }

      /**
       * Fires before the password reset procedure is validated.
       *
       * @param object $errors WP Error object.
       * @param WP_User|WP_Error $user WP_User object if the login and reset key match. WP_Error object otherwise.
       * @since 3.5.0
       *
       */
      do_action('validate_password_reset', $errors, $user);

      if ((!$errors->get_error_code()) && isset($pass1) && !empty($pass1)) {
          reset_password($user, $pass1);
      }

      // display error message
      if ($errors->get_error_code()) {
        wp_send_json_error([
          'type' => $errors->get_error_code(),
          'message' => $errors->get_error_message($errors->get_error_code())
        ]);
      } else {
        wp_send_json_success([
          'message' => __( 'Ваш пароль успешно изменен!', 'medvoice' )
        ]);
      }

      die( );
    } else {
      wp_send_json_error(['message' => __('Подтвердите, что Вы не робот', 'medvoice')]);
    } 

    die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => $th
    ] );

    die();
  }
}

/* ==============================================
********  //Обновление информации о подписчике
=============================================== */
function medvoice_ajax_edit_user_info()
{
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if($_POST['antibot'] == 1) {
      $medvoice_user = wp_get_current_user();

      // Получаем данные из полей формы и проверяем их
      $info = [];

      $info['ID'] = $medvoice_user->ID;

      $info['first_name'] = isset($_POST['first_name']) ? htmlspecialchars(trim($_POST['first_name'])) : '';
      $info['last_name'] = isset($_POST['last_name']) ? htmlspecialchars(trim($_POST['last_name'])) : '';
      $info['user_email'] = isset($_POST['user_email']) ? filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL) : '';
            
      if ( empty($info['user_email']) || !filter_var($info['user_email'], FILTER_VALIDATE_EMAIL) || !is_email($info['user_email']) ) {
        wp_send_json_error([
          'type' => 'user_email', 
          'message' => __('Введите правильный адрес электронной почты', 'medvoice')
        ]);

        die(  );  
      } 

      if ( 25 < mb_strlen( $info['first_name'] ) ) {
        wp_send_json_error([
          'type' => 'first_name', 
          'message' => __('Имя должно быть не более 25 символов', 'medvoice')
        ]);

        die(  );  
      } 

      if ( 25 < mb_strlen( $info['last_name'] ) ) {
        wp_send_json_error([
          'type' => 'last_name', 
          'message' => __('Фамилия должна быть не более 25 символов', 'medvoice')
        ]);

        die(  );  
      }      

      $user_updated = wp_update_user( $info );

      if ( is_wp_error( $user_updated ) ) {
        wp_send_json_error([
          'message' => __('Произошла ошибка, возможно такого пользователя не существует.', 'medvoice')
        ]);

        die(  );
      } else {
        $info_meta = [];
        $info_meta['specialization'] = isset($_POST['specialization']) ? htmlspecialchars($_POST['specialization']) : '';
  
        $info_meta['billing_country'] = isset($_POST['billing_country']) ? htmlspecialchars($_POST['billing_country']) : '';
        $info_meta['billing_city'] = isset($_POST['billing_city']) ? htmlspecialchars($_POST['billing_city']) : '';

        foreach ($info_meta as $key => $value) {
          $meta_value = get_metadata( 'user', $medvoice_user->ID, $key, true );

          if ( $meta_value !== $value ) {
            $meta_updated = update_metadata( 'user', $medvoice_user->ID, $key, $value );

            if ($meta_updated === false) {
              wp_send_json_error([
                'message' => __('Не удалось обновить: ', 'medvoice') . $key
              ]);

              die();
            }
          }          
        }

        // Аватар
        if ( !empty($_FILES) && !empty($_FILES['avatar']['tmp_name']) ) {
          // ограничим вес загружаемой картинки
          $filesize = $_FILES['avatar']['size'];
          $max_filesize_mb = 4;
          $max_filesize = $max_filesize_mb * 1024 * 1024;

          if ($filesize > $max_filesize) {
            wp_send_json_error([
              'message' => __('Фото не должно быть больше ', 'medvoice') . $max_filesize_mb . 'Mb.'
            ]);

            die(  );  
          }

          // ограничим размер загружаемой картинки
          $sizedata = getimagesize($_FILES['avatar']['tmp_name']);
          $max_size = 4000;

          if ($sizedata[0]/*width*/ > $max_size || $sizedata[1]/*height*/ > $max_size) {
            wp_send_json_error([
              'message' => __('Фото не должно быть больше ', 'medvoice') . $max_size . __('px в ширину или высоту.', 'medvoice')
            ]);

            die(  );  
          }

          //разрешим только картинки
          if ($_FILES['avatar']['type'] !== 'image/jpeg' && $_FILES['avatar']['type'] !== 'image/png') {
            wp_send_json_error([
              'message' => __('Тип файла не подходит по соображениям безопасности.', 'medvoice')
            ]);

            die(  );  
          } 

          // обрабатываем загрузку файла
          require_once ABSPATH . 'wp-admin/includes/image.php';
          require_once ABSPATH . 'wp-admin/includes/file.php';
          require_once ABSPATH . 'wp-admin/includes/media.php';
  
          // фильтр допустимых типов файлов - разрешим только картинки
          add_filter('upload_mimes', function ($mimes) {
              return [
                'jpg|jpeg|jpe' => 'image/jpeg',
                // 'gif' => 'image/gif',
                'png' => 'image/png',
              ];
          });
  
          $uploaded_imgs = [];
          $attach = [];
     
          foreach ($_FILES as $file_id => $data) {
            $attach_id = media_handle_upload($file_id, 0);

            if ( is_wp_error($attach_id) ) {
              $uploaded_imgs[] = __('Ошибка загрузки файла', 'medvoice') . '`' . $data['name'] . '`: ' . $attach_id->get_error_message();
            } else {      
              $attach[] = $attach_id;
            }
          }

          if ( !empty($uploaded_imgs) ) {
            wp_send_json_error([
              'message' => implode('<br>', $uploaded_imgs),
            ]);

            die(  );  
          }

          $avatar_updated = null;
          if ( !empty($attach) ) {
            $avatar_updated = update_metadata( 'user', $medvoice_user->ID, 'avatar', $attach[0] );

            if ( $avatar_updated === false ) {
              wp_send_json_error([
                'message' => __('Не удалось обновить аватар! ', 'medvoice')
              ]);
  
              die(  ); 
            }
          }
        }

        wp_send_json_success([
          'message' => __('Данные успешно обновлены!', 'medvoice'), 
          //'avatar' => $avatar_updated
        ]);

        die();
      }      
    } else {
      wp_send_json_error(['message' => __('Подтвердите, что Вы не робот', 'medvoice')]);
    }   

    die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => $th
    ] );

    die();
  }
}

function medvoice_ajax_edit_password()
{  
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if($_POST['antibot'] == 1) {  
      $medvoice_user = wp_get_current_user(  );

      $errors = new WP_Error();

      // Получаем данные из полей формы и проверяем их  
      $pass1 = $_POST['password'];
      $pass2 = $_POST['password-confirm'];

      $pass_old = $_POST['password-old'];

      // Проверка старого пароля
      $result = wp_check_password($pass_old, $medvoice_user->user_pass, $medvoice_user->ID);

      if ($result === false) {
        $errors->add('password-old', __('Вы ввели неправильный старый пароль.', 'medvoice'));
      }

      // check to see if user added some string
      if ( empty($pass1) ) {
        $errors->add('password', __('Введите пароль.', 'medvoice'));
      }

      if ( empty($pass2) ) {
        $errors->add('password-confirm', __('Введите подтверждение пароля.', 'medvoice'));
      }

      if ( 7 >= mb_strlen($pass1) ) {
        $errors->add('password', __('Пароль должен быть не менее 8 символов.', 'medvoice'));
      }

      // is pass1 and pass2 match?
      if ( $pass1 != $pass2 ) {
        $errors->add('password-confirm', __('Пароли не совпадают.', 'medvoice'));
      }

      if ((!$errors->get_error_code()) && isset($pass1) && !empty($pass1)) {
        wp_set_password( $pass1, $medvoice_user->ID );

        // Log-in again.
        wp_set_auth_cookie($medvoice_user->ID);
        wp_set_current_user($medvoice_user->ID);

        do_action('wp_login', $medvoice_user->user_login, $medvoice_user);
      }

      // display error message
      if ($errors->get_error_code()) {
        wp_send_json_error([
          'type' => $errors->get_error_code(),
          'message' => $errors->get_error_message($errors->get_error_code())
        ]);
      } else {
        wp_send_json_success([
          'message' => __( 'Ваш пароль успешно изменен!', 'medvoice' )
        ]);
      }

      die( );     
    } else {
      wp_send_json_error(['message' => __('Подтвердите, что Вы не робот', 'medvoice')]);
    }   

    die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => $th
    ] );

    die();
  }
}

/* ==============================================
********  //Добавление селекта со специальностями в редактирование профиля в админке
=============================================== */
add_action( 'show_user_profile', 'medvoice_specialization_profile_field' );
add_action( 'edit_user_profile', 'medvoice_specialization_profile_field' );

function medvoice_specialization_profile_field( $user ) 
{
  $specializations = get_site_option( 'specializations' ) ?? [];
  $specialization = $user->get( 'specialization' );
  ?>
      <h3 class="heading"><?= __( 'Специальность', 'medvoice' ); ?></h3>

      <table class="form-table">
          <tr>
              <th></th>

              <td>
                <select id="specialization" name="specialization" size="">
                  <option value="0" <?= (empty($specialization) || $specialization == '0') ? 'selected' : ''; ?>>
                    <?= __( 'Выберите специальность', 'medvoice' ); ?>
                  </option>
                  <?php foreach ($specializations as $key => $item) : ?>
                    <option value="<?= $item['value']; ?>" <?php selected( $specialization, $item['value'] ) ?>><?= $item['label']; ?></option>
                  <?php endforeach; ?>                  
                </select>
              </td>
          </tr>
      </table>
  <?php
} 

add_action( 'personal_options_update', 'medvoice_save_specialization_profile_field' );
add_action( 'edit_user_profile_update', 'medvoice_save_specialization_profile_field' );

function medvoice_save_specialization_profile_field( $user_id ) 
{

    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }

    update_usermeta( $user_id, 'specialization', esc_attr( $_POST['specialization'] ) );
}

/* ==============================================
********  //Проверка наличия Аватара
=============================================== */
function medvoice_have_user_avatar( $user_id = null )
{
  if ( isset($user_id) ) {
    $medvoice_user = get_user_by( 'id', $user_id );

    if ( $medvoice_user instanceof WP_User ) {
      $medvoice_user_avatar = $medvoice_user->get( 'avatar' );

      if ( isset($medvoice_user_avatar) && !empty($medvoice_user_avatar) ) {
        return true;
      }
    }
  }

  if ( is_user_logged_in(  ) ) {
    $medvoice_user = wp_get_current_user(  );
    
    $medvoice_user_avatar = $medvoice_user->get( 'avatar' );

    if ( isset($medvoice_user_avatar) && !empty($medvoice_user_avatar) ) {
      return true;
    }
  }  

  return false;
}

/* ==============================================
********  //Получение Аватара
=============================================== */
function medvoice_get_user_avatar( $size = 'thumbnail', $user_id = null )
{
  if ( isset($user_id) ) {
    $medvoice_user = get_user_by( 'id', $user_id );

    if ( $medvoice_user instanceof WP_User ) {
      $medvoice_user_avatar = $medvoice_user->get( 'avatar' );

      if ( isset($medvoice_user_avatar) && !empty($medvoice_user_avatar) ) {
        $medvoice_user_avatar = wp_get_attachment_image_src( $medvoice_user_avatar, $size );
  
        return is_array($medvoice_user_avatar) ? $medvoice_user_avatar[0] : get_avatar_url( $medvoice_user->ID );
      }
    }
  }

  if ( is_user_logged_in(  ) ) {
    $medvoice_user = wp_get_current_user(  );
    
    $medvoice_user_avatar = $medvoice_user->get( 'avatar' );

    if ( isset($medvoice_user_avatar) && !empty($medvoice_user_avatar) ) {
      $medvoice_user_avatar = wp_get_attachment_image_src( $medvoice_user_avatar, $size );

      return is_array($medvoice_user_avatar) ? $medvoice_user_avatar[0] : get_avatar_url( $medvoice_user->ID );
    }
  }  

  return false;
}

/* ==============================================
********  //Фильтр дефолтного Аватара
=============================================== */
add_filter('get_avatar', 'medvoice_custom_user_avatar_filter', 1, 5);

function medvoice_custom_user_avatar_filter($avatar, $id_or_email, $size, $alt, $args) 
{
  $medvoice_user = get_user_by( 'id', $id_or_email );

  if ( $medvoice_user instanceof WP_User ) {
    $medvoice_user_avatar = $medvoice_user->get( 'avatar' );

    if ( isset($medvoice_user_avatar) && !empty($medvoice_user_avatar) ) {
      $size_avatar = 'thumbnail';

      $medvoice_user_avatar = wp_get_attachment_image_src( $medvoice_user_avatar, $size_avatar );

      $medvoice_user_avatar_src = is_array($medvoice_user_avatar) ? $medvoice_user_avatar[0] : get_avatar_url( $medvoice_user->ID );

      // enter your custom image output here
      $avatar = '<img alt="' . $alt . '" src="' . $medvoice_user_avatar_src . '" width="' . $size . '" height="' . $size . '" />';
    }
  }

  return $avatar;
}

/* ==============================================
********  //Получение названия специализации
=============================================== */
function medvoice_get_specialization_label( $value = '' )
{
  // Получаем список всех специализаций
  $specializations = get_site_option( 'specializations' ) ?? [];

  foreach ($specializations as $key => $specialization) {
   if ( $specialization['value'] === $value) {
     return $specialization['label'];
   }
  }
}

/* ==============================================
********  //Добавление/удаление в/из закладки (-ок)
=============================================== */
function medvoice_ajax_add_to_bookmarks() 
{
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if ( is_user_logged_in(  ) ) {
      $video_id = isset($_POST['video_id']) ? (int) $_POST['video_id'] : null;

      if ( isset($video_id) ) {
        $video_ids = medvoice_get_post_languages_arr( $video_id );

        $bookmarks = [];

        $medvoice_user = wp_get_current_user(  );
      
        $medvoice_user_bookmarks = $medvoice_user->get( 'bookmarks' );

        if ( !empty($medvoice_user_bookmarks) ) {
          $bookmarks = json_decode( $medvoice_user_bookmarks, true );
        }

        foreach ($video_ids as $key => $video_id) {
          if ( !in_array($video_id, $bookmarks) ) {
            $bookmarks[] = $video_id;
          }
        }

        $bookmarks = json_encode( $bookmarks );

        $bookmarks_updated = update_metadata( 'user', $medvoice_user->ID, 'bookmarks', $bookmarks );

        if ( $bookmarks_updated === false ) {
          wp_send_json_error([
            'message' => __('Не удалось обновить закладки!', 'medvoice'),
          ]);

          die();
        } else {
          wp_send_json_success([
            'message' => __('Видео успешно добавлено в закладки!', 'medvoice'),
            'bookmarks' => $bookmarks,
          ]);
        }
      } else {
        wp_send_json_error( [
          'message' => __('Нет ID видео!', 'medvoice'),
        ]);
      }     
    }

    die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => __( 'Что-то пошло не так...', 'medvoice' ),
      'error' => $th,
    ]);

    die();
  }
}

function medvoice_ajax_remove_from_bookmarks() 
{
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if ( is_user_logged_in(  ) ) {
      $video_id = isset($_POST['video_id']) ? (int) $_POST['video_id'] : null;

      if ( isset($video_id) ) {
        $video_ids = medvoice_get_post_languages_arr( $video_id );

        $medvoice_user = wp_get_current_user(  );
      
        $medvoice_user_bookmarks = $medvoice_user->get( 'bookmarks' );

        if ( !empty($medvoice_user_bookmarks) ) {
          $bookmarks = json_decode( $medvoice_user_bookmarks, true );

          foreach ($video_ids as $key => $video_id) {
            $bookmarks_key = array_search($video_id, $bookmarks);

            if ( $bookmarks_key ) {
              unset( $bookmarks[$bookmarks_key] );
            }
          }

          $bookmarks = json_encode( $bookmarks );

          $bookmarks_updated = update_metadata( 'user', $medvoice_user->ID, 'bookmarks', $bookmarks );

          if ( $bookmarks_updated === false ) {
            wp_send_json_error([
              'message' => __('Не удалось обновить закладки!', 'medvoice'),
            ]);

            die();
          } else {
            wp_send_json_success([
              'message' => __('Видео успешно удалено из закладок!', 'medvoice'),
              'bookmarks' => $bookmarks,
            ]);
          }
        }
      } else {
        wp_send_json_error( [
          'message' => __( 'Нет ID видео!', 'medvoice' ),
        ]);
      }     
    }

    die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => __( 'Что-то пошло не так...', 'medvoice' ),
      'error' => $th,
    ]);

    die();
  }
}

function medvoice_get_user_bookmarks()
{
  $bookmarks = [];

  if ( is_user_logged_in(  ) ) {
    $medvoice_user = wp_get_current_user(  );
    
    $medvoice_user_bookmarks = $medvoice_user->get( 'bookmarks' );

    if ( !empty($medvoice_user_bookmarks) ) {
      $bookmarks = json_decode( $medvoice_user_bookmarks, true );
    }
  }  

  return $bookmarks;
}

/* ==============================================
********  //Класс для операций с БД
=============================================== */
class Medvoice
{
  public function insert_table_unconfirmed_mail_users_into_db( ) 
  {
    global $wpdb;

    // set the default character set and collation for the table
    $charset_collate = $wpdb->get_charset_collate();
    // Check that the table does not already exist before continuing
    $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}unconfirmed_mail_users` (
      id bigint(50) NOT NULL AUTO_INCREMENT,
      user_key varchar(100),
      user_pass varchar(100),
      PRIMARY KEY (id)
      ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta( $sql );

    $response = [
      'success' => 1,
      'error' => ''
    ];

    if ( !empty( $wpdb->last_error ) ) {
      $response = [
        'success' => 0,
        'error' => $wpdb->last_error
      ];
    }

    return $response;
  }

  public function set_unconfirmed_mail_user_pass( $key = null, $pass = null )
  {
    global $wpdb;

    if ( isset($key) && isset($pass) ) {
      $medvoice_user_pass_set = $wpdb->insert( $wpdb->prefix . 'unconfirmed_mail_users', array( 'user_key' => $key, 'user_pass' => $pass ) );
      
      return $medvoice_user_pass_set;
    }      
  }

  public function get_unconfirmed_mail_user_pass( $key = null )
  {
    global $wpdb;

    if ($key) {
      $medvoice_user_pass_get = $wpdb->get_col( $wpdb->prepare( "SELECT user_pass FROM `{$wpdb->base_prefix}unconfirmed_mail_users` WHERE user_key = %d", $key ) );

      return $medvoice_user_pass_get;
    }    
  }

  public function delete_unconfirmed_mail_user_info( $key = null )
  {
    global $wpdb;

    if ($key) {
      $table = $wpdb->prefix . 'unconfirmed_mail_users';
      
      $medvoice_user_pass = $wpdb->delete( $table, [ 'user_key' => $key ] );

      return $medvoice_user_pass;
    } 
  }
}
?>