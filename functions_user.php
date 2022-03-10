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

  add_action( 'wp_ajax_medvoice_set_user_time', 'medvoice_set_user_time' );
  add_action( 'wp_ajax_nopriv_medvoice_set_user_time', 'medvoice_set_user_time' );
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
      }

      if (empty($info['user_password'])) {
        wp_send_json_error(['type' => 'password', 'message' => __('Введите пароль', 'medvoice')]);
      }

      $user_signon = wp_signon($info, false);

      if (is_wp_error($user_signon)) {
        if (!email_exists($info['user_login'])) {
          wp_send_json_error( [
            'message' => __('Неверный адрес электронной почты', 'medvoice')
          ] );
        } else {
          wp_send_json_error([
            'message' => __('Неправильный логин или пароль!', 'medvoice')
          ]);
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
function medvoice_ajax_register_mail() {
  try {
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    if($_POST['antibot'] == 1) {
      // Триальная ли форма отправлена
      $trial = ((int) $_GET['trial'] === 1) ? 1 : 0;

      // Получаем данные из полей формы и проверяем их
      $info = array();

      $info['user_login'] = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
      $info['user_password'] = isset($_POST['password']) ? $_POST['password'] : '';
      $info['nickname'] = isset($_POST['nickname']) ? $_POST['nickname'] : '';

      if ( empty($info['user_login']) || !filter_var($info['user_login'], FILTER_VALIDATE_EMAIL) || !is_email($info['user_login']) ) {
        wp_send_json_error(['type' => 'email', 'message' => __('Введите правильный адрес электронной почты', 'medvoice')]);
      } else if( username_exists($info['user_login']) || email_exists( $info['user_login'] ) ) {
        wp_send_json_error(['type' => 'email', 'message' => __('Такой e-mail уже зарегистрирован ранее', 'medvoice')]);
      }

      if ( empty($info['user_password']) ) {
        wp_send_json_error(['type' => 'password', 'message' => __('Введите пароль', 'medvoice')]);
      } else if( 8 >= mb_strlen($info['user_password']) ) {
        wp_send_json_error(['type' => 'password', 'message' => __('Пароль должен быть не менее 8 символов.', 'medvoice')]);
      }

      $confirm_subject = get_bloginfo( 'name' ) . ' - ' . __('Подтверждение e-mail', 'medvoice');

      $pass = wp_hash_password($info['user_password']);
      
      $confirm_link = get_home_url(  ) . '/?action=confirm' .
                                         '&key=' . $pass . 
                                         '&email=' . rawurlencode($info['user_login']) . 
                                         '&name=' . $info['nickname'] .
                                         '&trial=' . $trial;

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

      // Добавление пользователя во временную таблицу
      // if ( class_exists( 'Medvoice' ) ) {
      //   $medvoice = new Medvoice;
      // } 

      wp_send_json_success(['info' => $info, 'message' => __('Успешный запрос!', 'medvoice')]);
    } else {
      wp_send_json_error(['post' => $_POST, 'message' => __('Подтвердите, что Вы не робот', 'medvoice')]);
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
  if (isset($_GET['action']) && $_GET['action'] === 'confirm') {
    $trial = (int) $_GET['trial'];

    $password = htmlspecialchars($_GET['key']);
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

      if ( $trial === 1 ) {
        // Тут будет код/ф-я для подписки
      }

      /* Перенаправление браузера */
      header('Location: ' . get_bloginfo( 'url' )); 

      /* Убедиться, что код ниже не выполнится после перенаправления .*/
      exit;
    } else {
      return $user_id;
    }
  }
}


/* ==============================================
********  //Время по часовому поясу
=============================================== */
function medvoice_set_user_time()
{
  try {
    if (isset($_POST['offset']) && (!isset($_COOKIE['medvoice_user_time_offset']) || $_COOKIE['medvoice_user_time_offset'] !== $_POST['offset'])) {
      setcookie('medvoice_user_time_offset', $_POST['offset'], time() + 60 * 60 * 24, "/");
    }

    wp_send_json_success( 'Локальная дата установлена!' );
  } catch ( Throwable $th) {
    wp_send_json_error( $th );
  } 
  
  wp_die(  );
}

// function medvoice_show_time()
// {
//   return date('H:i', utc_to_usertime(time())) . ' (UTC' . utc_value() . ')';
// }

// function utc_to_usertime($time)
// {
//   return isset($_COOKIE['medvoice_user_time_offset']) ? $time - ($_COOKIE['medvoice_user_time_offset'] * 60) : $time;
// }

// function usertime_to_utc($time)
// {
//   return isset($_COOKIE['medvoice_user_time_offset']) ? $time + ($_COOKIE['medvoice_user_time_offset'] * 60) : $time;
// }

// function utc_value()
// {
//   return isset($_COOKIE['medvoice_user_time_offset']) ? (($_COOKIE['medvoice_user_time_offset'] <= 0 ? '+' : '-') . (!empty($_COOKIE['medvoice_user_time_offset']) ? gmdate('H:i',
//           abs($_COOKIE['medvoice_user_time_offset'] * 60)) : 0)) : '+0';
// }

class Medvoice
{
  public function insert_table_unconfirmed_mail_users_into_db( ) 
  {
    global $wpdb;

    // set the default character set and collation for the table
    $charset_collate = $wpdb->get_charset_collate();
    // Check that the table does not already exist before continuing
    $sql = "CREATE TABLE IF NOT EXISTS `{$table}unconfirmed_mail_users` (
      id bigint(50) NOT NULL AUTO_INCREMENT,
      user_key varchar(100),
      user_email varchar(100),
      user_pass varchar(100),
      nickname varchar(100),
      PRIMARY KEY (id)
      ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta( $sql );

    $is_error = !empty( $wpdb->last_error ); 

    if ($is_error) {
      echo $wpdb->last_error;
    }

    return $is_error;
  }

  public function get_unconfirmed_mail_user( $key = null )
  {
    global $wpdb;

    if ($key) {
      $medvoice_user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `{$wpdb->base_prefix}unconfirmed_mail_users` where user_key = %d", $key ) );

      return $medvoice_user;
    }    
  }
}

?>