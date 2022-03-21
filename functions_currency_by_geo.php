<?php 
/* ==============================================
  ********  //Currency by Geo
=============================================== */
function medvoice_get_ip() {
  $keys = [
    'HTTP_CLIENT_IP',
    'HTTP_X_FORWARDED_FOR',
    'REMOTE_ADDR'
  ];

  foreach ($keys as $key) {
    if (!empty($_SERVER[$key])) {
      $ip = trim(end(explode(',', $_SERVER[$key])));
      if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
      }
    }
  }
}

function medvoice_get_country_code() {
  $ip = medvoice_get_ip();

  // подключим файл SxGeo.php
  require_once TEMPLATEPATH . '/SxGeo/SxGeo.php';

  // создадим объект SxGeo (
  // 1 аргумент – имя файла базы данных, 
  // 2 аргумент – режим работы: 
  //   SXGEO_FILE (по умолчанию), 
  //   SXGEO_BATCH  (пакетная обработка, увеличивает скорость при обработке множества IP за раз), 
  //   SXGEO_MEMORY (кэширование БД в памяти, еще увеличивает скорость пакетной обработки, но требует больше памяти, для загрузки всей базы в память).
  
  if (class_exists( 'SxGeo' ) && $ip) {
    $SxGeo = new SxGeo( TEMPLATEPATH . '/SxGeo/SxGeo.dat', SXGEO_BATCH | SXGEO_MEMORY );

    // получаем двухзначный ISO-код страны (RU, UA и др.)
    $country_code = $SxGeo->getCountry($ip);
  }
  
  $country_code = ($country_code && !empty($country_code)) ? $country_code : 'UA';

  return $country_code;
}

function medvoice_get_currency_code(  ) {
  $currency_code = 'USD';

  $country_code = medvoice_get_country_code();

  // Зоны, где действует та, либо иная валюта
  $currency_zones = get_site_option( 'currency_zones' ) ?? [];

  foreach ($currency_zones as $key => $currency_zone) {
    if ( in_array( $country_code, $currency_zone ) ) {
      $currency_code = $key;
      
      return $currency_code;
    }
  }

  return $currency_code;
} 

function medvoice_get_currency_code_text(  ) {
  $currency_code = medvoice_get_currency_code(  );

  switch ($currency_code) {
    case 'USD':
      return '$';

      break;

    case 'EUR':
      return '€';
      
      break;
    
    case 'RUR':
      return 'руб';
      
      break;

    case 'UAH':
      return 'грн';
      
      break;
    
    default:
      return '$';

      break;
  }
}

function medvoice_get_price_side(  ) {
  $currency_code = medvoice_get_currency_code(  );

  switch ($currency_code) {
    case 'USD':
      return 'left';

      break;

    case 'EUR':
      return 'left';
      
      break;
    
    case 'RUR':
      return 'right';
      
      break;

    case 'UAH':
      return 'right';
      
      break;
    
    default:
      return 'left';

      break;
  }
}

/**
 * $method (string) : 'sale', 'buy'
 */
function medvoice_get_converted_price( $price = 0, $method = 'sale' ) {
  $currency_code = medvoice_get_currency_code();

  if ($currency_code !== 'UAH') {
    // Получение курса валют через API Приватбанка
    $response = file_get_contents( 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5' );
    $response = json_decode( $response, true ) ?? [];

    foreach ($response as $currency) {
      if ( $currency[ 'ccy' ] === $currency_code ) {
        $price = round( ($price / $currency[ $method ]), 1 );

        return $price;
      }
    }
  }

  return $price;
}

?>