<?php 
/* ==============================================
********  //Логин
=============================================== */

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
  }
}

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
      $info = array();

      $info['user_login'] = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
      $info['user_password'] = isset($_POST['password']) ? $_POST['password'] : '';
      $info['nickname'] = isset($_POST['nickname']) ? $_POST['nickname'] : '';

      if ( empty($info['user_login']) || !filter_var($info['user_login'], FILTER_VALIDATE_EMAIL) || !is_email($info['user_login']) ) {
        wp_send_json_error(['type' => 'email', 'message' => __('Введите правильный адрес электронной почты', 'medvoice')]);

        die(  );  
      } else if( username_exists($info['user_login']) || email_exists( $info['user_login'] ) ) {
        wp_send_json_error(['type' => 'email', 'message' => __('Такой e-mail уже зарегистрирован ранее', 'medvoice')]);

        die(  );  
      }

      if ( empty($info['user_password']) ) {
        wp_send_json_error(['type' => 'password', 'message' => __('Введите пароль', 'medvoice')]);

        die(  );  
      } else if( 7 >= mb_strlen($info['user_password']) ) {
        wp_send_json_error(['type' => 'password', 'message' => __('Пароль должен быть не менее 8 символов.', 'medvoice')]);

        die(  );  
      }

      $confirm_subject = get_bloginfo( 'name' ) . ' - ' . __('Подтверждение e-mail', 'medvoice');

      $key = wp_hash_password( $info['user_password'] . ';' . $info['nickname'] . ';' . $info['user_login'] );

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
          $saved_pass = $medvoice->set_unconfirmed_mail_user_pass( $key, $info['user_password'] );

          if ( $saved_pass === false || $saved_pass === 0 ) {
            wp_send_json_error(['message' => __('Не удалось сохранить Ваши данные (строка). Пожалуйста, повторите позже: ', 'medvoice') . $table_unconfirmed_mail_users['error'] ]);

            die(  ); 
          }
        }        
      }
      
      $confirm_link = get_forms_page_url(  ) . '?action=confirm' .
                                         '&key=' . $key . 
                                         '&email=' . rawurlencode($info['user_login']) . 
                                         '&name=' . $info['nickname'];

      $confirm_text = get_custom_logo() . '<br><br>';
      $confirm_text .= '<p>' . __( 'Приветствуем Вас, ', 'medvoice' ) . '<b>' . $info['nickname'] . '</b></p>';
      $confirm_text .= '<p>' . __('Для завершения регистрации, пожалуйста, подтвердите Ваш e-mail.', 'medvoice') . '</p>';
      $confirm_text .= '<p>' . __('Для подтверждения e-mail - перейдите по ссылке ниже: ', 'medvoice') . '</p>';
      $confirm_text .= '<p><a href="' . $confirm_link . '">' . __('Подтвердить e-mail и завершить регистрацию', 'medvoice') . '</a></p>';
      
      $to = $info['user_login'];   

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

    $key = $_GET['key'];    

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
          $email = rawurldecode($_GET['email']);
          $nickname = $_GET['name'];

          $userdata = array(
            'user_login'   =>   sanitize_user( $email ),
            'nickname'     =>   $nickname,
            'display_name' =>   $nickname,
            'user_email'   =>   $email,
            'user_pass'	   =>   $password,
          );

          $user_id = wp_insert_user( $userdata );

          if( !is_wp_error( $user_id ) ) {

            wp_new_user_notification( $user_id, null, 'user' );

            $info = array();
            $info['user_login'] = $email;
            $info['user_password'] = $password;
            $info['remember'] = true;

            $user_signon = wp_signon( $info, false );

            wp_set_current_user( $user_signon->ID, $user_signon->user_login );   

            wp_redirect( get_home_url(  ) );

            exit();
          } else {
            return $user_id;
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
          'retrieve_password' => true,
          'message' => sprintf(
            /* translators: %s: Link to the login page. */
            __('Check your email for the confirmation link, then visit the <a href="%s">login page</a>.', 'medvoice' ),
            add_query_arg('action', 'login', home_url())
          ),
        ]);
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
          //		$errors = $user;
          $errors->add('invalid_key', sprintf(
              __('Некорректные данные для смены пароля. Проверьте, правильно ли вы скопировали ссылку из письма или отправьте <a href="%s">ещё одно</a>.'),
              add_query_arg('action', 'forgot', home_url())
          ));
      }
        /*else {
        echo 'Ключ прошел проверку. Можно высылать новый пароль на почту.';
      }*/

      // check to see if user added some string
      if (empty($pass1) || empty($pass2)) {
          $errors->add('password_required', __('Введите пароль.', 'medvoice'));
      }
      if (7 >= strlen($pass1)) {
        $errors->add('password_short', __('Пароль должен быть не менее 8 символов.', 'medvoice'));
      }
      // is pass1 and pass2 match?
      if ($pass1 != $pass2) {
        $errors->add('password_reset_mismatch', __('The passwords do not match.', 'medvoice'));
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

          /*		$errors->add( 'password_reset',
        sprintf(
          __( 'Check your email for the confirmation link, then visit the <a href="%s">login page</a>.' ),
          add_query_arg( 'action', 'login', home_url() ) ) );*/
          $errors->add('password_reset', __('Your password has been reset.'));
      }

      // display error message
      if ($errors->get_error_code()) {
        wp_send_json_error(['message' => $errors->get_error_message($errors->get_error_code())]);
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