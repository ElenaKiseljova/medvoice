<?php 
/* ==============================================
********  //Валюты по зонам
=============================================== */
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

/* ==============================================
********  //Специальности
=============================================== */
  $specializations = [
    [
      'label' => __( 'Хирург', 'medvoice' ),
      'value' => 'surgeon',
    ],
    [
      'label' => __( 'Стоматолог', 'medvoice' ),
      'value' => 'stomatologist',
    ],
    [
      'label' => __( 'Офтальмолог', 'medvoice' ),
      'value' => 'ophthalmologist',
    ],
    [
      'label' => __( 'Травматолог', 'medvoice' ),
      'value' => 'traumatologist',
    ],
    [
      'label' => __( 'Диетолог', 'medvoice' ),
      'value' => 'nutritionist',
    ],
  ];

  update_site_option('specializations', $specializations);
?>