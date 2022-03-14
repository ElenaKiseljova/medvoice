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

        wp_die(  );
      }

      if (empty($info['user_password'])) {
        wp_send_json_error(['type' => 'password', 'message' => __('Введите пароль', 'medvoice')]);

        wp_die(  );
      }

      $user_signon = wp_signon($info, false);

      if (is_wp_error($user_signon)) {
        if (!email_exists($info['user_login'])) {
          wp_send_json_error( [
            'message' => __('Неправильный адрес электронной почты', 'medvoice')
          ] );

          wp_die(  );
        } else {
          wp_send_json_error([
            'message' => __('Неправильный логин или пароль', 'medvoice'),
            'error' => $user_signon->get_error_message()
          ]);

          wp_die(  );
        }        
      } else {
        wp_set_current_user($user_signon->ID, $user_signon->user_login);
        wp_set_auth_cookie($user_signon->ID, true);
        
        wp_send_json_success(['message' => __('Отлично! Идет перенаправление...', 'medvoice')]);
      }
    } else {
      wp_send_json_error(['message' => __('Подтвердите, что Вы не робот', 'medvoice')]);
    }   

    wp_die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => $th
    ] );

    wp_die();
  }  
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

        wp_die(  );  
      } else if( username_exists($info['user_login']) || email_exists( $info['user_login'] ) ) {
        wp_send_json_error(['type' => 'email', 'message' => __('Такой e-mail уже зарегистрирован ранее', 'medvoice')]);

        wp_die(  );  
      }

      if ( empty($info['user_password']) ) {
        wp_send_json_error(['type' => 'password', 'message' => __('Введите пароль', 'medvoice')]);

        wp_die(  );  
      } else if( 7 >= mb_strlen($info['user_password']) ) {
        wp_send_json_error(['type' => 'password', 'message' => __('Пароль должен быть не менее 8 символов.', 'medvoice')]);

        wp_die(  );  
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

          wp_die(  );          
        } else {
          // Запись пароля
          $saved_pass = $medvoice->set_unconfirmed_mail_user_pass( $key, $info['user_password'] );

          if ( $saved_pass === false || $saved_pass === 0 ) {
            wp_send_json_error(['message' => __('Не удалось сохранить Ваши данные (строка). Пожалуйста, повторите позже: ', 'medvoice') . $table_unconfirmed_mail_users['error'] ]);

            wp_die(  ); 
          }
        }        
      }
      
      $confirm_link = get_home_url(  ) . '/?action=confirm' .
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

    wp_die();
  } catch (\Throwable $th) {
    wp_send_json_error( [
      'message' => $th
    ] );

    wp_die();
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
  } else if ( is_user_logged_in(  ) ) {
    $medvoice_user = wp_get_current_user(  );

    $trial = (int) $medvoice_user->get( 'trial' );

    if ( $trial !== 1 ) {
      $product_id = get_field( 'trial', 'options' ) ?? null;

      if ( isset($product_id) ) {
        // Вызов ф-и подключения триала при создании нового пользователя
        medvoice_create_order( $product_id );
      }	
    }
  }
}

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