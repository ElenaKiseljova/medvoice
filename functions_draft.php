<?php 
/* ==============================================
  ********  //Хэш-сумма для WayForPay
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
?>