<?php 
/* ==============================================
********  //Логин
=============================================== */

if( wp_doing_ajax() ) {
  if (!is_user_logged_in()) {
    add_action('wp_ajax_medvoice_ajax_login', 'medvoice_ajax_login');
    add_action('wp_ajax_nopriv_medvoice_ajax_login', 'medvoice_ajax_login');

    // add_action( 'wp_ajax_medvoice_ajax_register', 'medvoice_ajax_register' );
    // add_action( 'wp_ajax_nopriv_medvoice_ajax_register', 'medvoice_ajax_register' );
  }
}

// Signin
function medvoice_ajax_login()
{
    // Первым делом проверяем параметр безопасности
    check_ajax_referer('additional-script.js_nonce', 'security');

    // Получаем данные из полей формы и проверяем их
    $info = array();

    $info['remember'] = true;

    $info['user_login'] = isset($_POST['email']) ? $_POST['email'] : '';
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
    die();
}

?>