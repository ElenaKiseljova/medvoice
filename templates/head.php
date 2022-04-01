<?php 
  // Перенаправление на страницу форм, если вдруг гет запрос где-то не там, где надо появился
  $forms_page_id = medvoice_get_special_page( 'forms', 'id' );

  if ( isset($_GET['action']) && 
    ( 
      $_GET['action'] === 'login' || 
      $_GET['action'] === 'reset' || 
      $_GET['action'] === 'forgot' || 
      $_GET['action'] === 'register' ||
      $_GET['action'] === 'trial'
    ) && !is_page( $forms_page_id )) {
    wp_redirect( get_permalink( $forms_page_id ) . '?action=' . $_GET['action'] );

    exit();
  }

  // Контроль сессий
  $medvoice_user = wp_get_current_user(  );

  /** ЭТО ВРОДЕ РАБОТАЕТ! (ОТРУБАЕТ ВСЕ СЕССИИ КРОМЕ ТЕКУЩЕЙ) */
  $token_to_keep = wp_get_session_token(  );

  $wp_session_tokens = WP_Session_Tokens::get_instance($medvoice_user->ID);

  $wp_session_tokens->destroy_others( $token_to_keep );

  // update_metadata( 'user', $medvoice_user->ID, 'bookmarks', '[]' );
  // update_user_meta($medvoice_user->ID, '_new_user', '1');
  // update_user_meta($medvoice_user->ID, 'st', time());
  // delete_metadata( 'user', $medvoice_user->ID, 'subscribed_days' );
  // var_dump( get_user_meta( $medvoice_user->ID ) );
  // global $wpdb;
  // $themes_table               =   $wpdb->prefix . 'unconfirmed_mail_users';
  //   $wpdb->query("DROP TABLE IF EXISTS `".$themes_table."`");
  
  //echo wp_get_session_token();

  // if ( class_exists('WP_Session_Tokens') ) {
  //   $manager = WP_Session_Tokens::get_instance( get_current_user_id() );

  //   var_dump($manager);
  // }


  // echo '<br><br><br><br>';


  // $wp_sessions = wp_get_all_sessions() ?? [];

  //   foreach ($wp_sessions as $key => $wp_session) {
  //     var_dump($wp_session);
  //     echo '<br><br>';
      
  //     // echo date('Y-m-d H:i:s', utc_to_usertime($wp_session['expiration'])) . '<br>';
  //   }

    // echo medvoice_get_user_subscribe_end_date();



    
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  
  <?php
    wp_head();
  ?>
</head>

<body> 