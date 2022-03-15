<?php 
  /* ==============================================
********  //Время по часовому поясу
=============================================== */
add_action( 'wp_ajax_medvoice_set_user_time', 'medvoice_set_user_time' );
add_action( 'wp_ajax_nopriv_medvoice_set_user_time', 'medvoice_set_user_time' );
 
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
  
  die(  );
}

function utc_to_usertime($time)
{
  return isset($_COOKIE['medvoice_user_time_offset']) ? $time - ($_COOKIE['medvoice_user_time_offset'] * 60) : $time;
}

function usertime_to_utc($time)
{
  return isset($_COOKIE['medvoice_user_time_offset']) ? $time + ($_COOKIE['medvoice_user_time_offset'] * 60) : $time;
}

function utc_value()
{
  return isset($_COOKIE['medvoice_user_time_offset']) ? (($_COOKIE['medvoice_user_time_offset'] <= 0 ? '+' : '-') . (!empty($_COOKIE['medvoice_user_time_offset']) ? gmdate('H:i',
          abs($_COOKIE['medvoice_user_time_offset'] * 60)) : 0)) : '+0';
}
?>