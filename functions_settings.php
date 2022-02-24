<?php 
  $currency_zones = [
    'EUR' => [
      'AT', 
      'BE', 
      'DE', 
      'GR',
      'IE',
      'ES', 
      'IT', 
      'CY', 
      'LV',
      'LT',
      'LU', 
      'MT', 
      'NL', 
      'PT',
      'SK',
      'SI', 
      'FI', 
      'FR', 
      'EE',
    ],
    'RUR' => [
      'RU',
    ],
    'UAH' => [
      'UA', 
    ],    
  ];

  update_site_option('currency_zones', $currency_zones);
?>