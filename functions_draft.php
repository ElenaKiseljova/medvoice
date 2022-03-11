<?php 
/* ==============================================
  ********  //Хэш-сумма
  =============================================== */

  /**
   * $data : $_POST, $_REQUEST, др. ассоциативный массив
   * $attr : ключи массива, которые используются для создания хэш строки
   */
  // function medvoice_generate_hash ( $data = [], $attr = [] ) {
  //   // Дефолтный массив ключей (при создании платежа) для хэша
  //   if (empty($attr)) {
  //     $attr = [
  //       'merchantAccount', 
  //       'merchantDomainName', 
  //       'orderReference',
  //       'orderDate',
  //       'amount',
  //       'currency',
  //       'productName',
  //       'productCount',
  //       'productPrice',
  //     ];
  //   }

  //   // Массив из элементов, которые используются для создания хэша
  //   $data_filtered = [];

  //   // Проверка $data
  //   foreach ($data as $key => $value) {

  //     // Если ключ массива есть в массиве атрибутов для хэша
  //     if ( in_array( $key, $attr ) ) {

  //       if (is_array($value)) {
  //         $value = implode(';', $value);
  //       }

  //       // Добавляем в отфильтрованный ассоциативный массив
  //       array_push($data_filtered, $value);

  //     }
  //   }

  //   // Получаем строку
  //   $hash_string = implode(';', $data_filtered);

  //   // Убираем пробелы
  //   $hash_string = trim($hash_string);
    
  //   // Получаем ключ безопасности WayForPay
  //   $new_wc_wayforpay = new WC_wayforpay();

  //   $key = $new_wc_wayforpay->settings['secret_key'] ?? '';  

  //   // Получаем хэш
  //   $hash = hash_hmac( 'md5', $hash_string, $key );

  //   return $hash;
  // }


  // class Medvoice
  // {
  //   public function insert_table_unconfirmed_mail_users_into_db( ) 
  //   {
  //     global $wpdb;
  
  //     // set the default character set and collation for the table
  //     $charset_collate = $wpdb->get_charset_collate();
  //     // Check that the table does not already exist before continuing
  //     $sql = "CREATE TABLE IF NOT EXISTS `{$table}unconfirmed_mail_users` (
  //       id bigint(50) NOT NULL AUTO_INCREMENT,
  //       user_key varchar(100),
  //       user_email varchar(100),
  //       user_pass varchar(100),
  //       nickname varchar(100),
  //       PRIMARY KEY (id)
  //       ) $charset_collate;";
  
  //     require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  
  //     dbDelta( $sql );
  
  //     $is_error = !empty( $wpdb->last_error ); 
  
  //     if ($is_error) {
  //       echo $wpdb->last_error;
  //     }
  
  //     return $is_error;
  //   }
  
  //   public function get_unconfirmed_mail_user( $key = null )
  //   {
  //     global $wpdb;
  
  //     if ($key) {
  //       $medvoice_user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `{$wpdb->base_prefix}unconfirmed_mail_users` where user_key = %d", $key ) );
  
  //       return $medvoice_user;
  //     }    
  //   }
  // }

  // function medvoice_show_time()
// {
//   return date('H:i', utc_to_usertime(time())) . ' (UTC' . utc_value() . ')';
// }
?>