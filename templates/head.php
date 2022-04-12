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
?>

<!DOCTYPE html>
<html lang="<?= function_exists( 'pll_current_language' ) ? (pll_current_language() === 'uk' ? 'ua' : pll_current_language()) : 'ru' ; ?>">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  
  <?php
    wp_head();
  ?>
</head>

<body> 