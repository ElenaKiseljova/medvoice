<?php 
/*INCLUDE SETTINGS FUNCTIONS.PHP*/
require_once( TEMPLATEPATH . '/functions_settings.php' );

/*INCLUDE ENTER FUNCTIONS.PHP*/
require_once( TEMPLATEPATH . '/functions_enter.php' );

/* medvoice */
  
add_action('wp_enqueue_scripts', 'medvoice_styles', 3);
add_action('wp_enqueue_scripts', 'medvoice_scripts', 5);

// Styles theme
function medvoice_styles () {
  // wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

  // wp_enqueue_style('swiper-style', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css');

  wp_enqueue_style('medvoice-style', get_stylesheet_uri());    
}

// Scripts theme
function medvoice_scripts () {
  wp_enqueue_script('additional-script', get_template_directory_uri() . '/assets/js/additional.js', $deps = array(), $ver = null, $in_footer = true );

  // С переводами
  wp_set_script_translations( 'additional-script', 'medvoice' );

  // reCAPTCHA v3
  $site_key = get_field( 'site_key', 'options' ) ?? false;

  if ($site_key) {
    wp_enqueue_script('recaptcha-script', 'https://www.google.com/recaptcha/api.js?render=' . $site_key, $deps = array(), $ver = null, $in_footer = true );
  }

  // AJAX
  $args = array(
    'url' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('additional-script.js_nonce'),
  );  

  if ( $site_key ) {
    $args['site_key'] = $site_key;
  }

  wp_localize_script( 'additional-script', 'medvoice_ajax', $args);  
}

add_action( 'after_setup_theme', 'medvoice_after_setup_theme_function' );

if (!function_exists('medvoice_after_setup_theme_function')) :
  function medvoice_after_setup_theme_function () {
    load_theme_textdomain('medvoice', get_template_directory() . '/languages');

    /* ==============================================
    ********  //Миниатюрки
    =============================================== */
    add_theme_support( 'post-thumbnails' );

    /* ==============================================
    ********  //Title
    =============================================== */
    add_theme_support( 'title-tag' );
    
    /* ==============================================
    ********  //Лого
    =============================================== */
    add_theme_support( 'custom-logo' );
    
    /* ==============================================
    ********  //Меню
    =============================================== */
    register_nav_menu( 'main', 'Главная навигация' );

    register_nav_menu( 'social', 'Социальные сети' );
    
    /* ==============================================
    ********  //Размеры картирок
    =============================================== */
    /* Main */
    // add_image_size( 'main_bg_large', 1600, 916, false);
  }
endif;

// Init
add_action( 'init', 'medvoice_init_function' );
  
if (!function_exists('medvoice_init_function')) :
  function medvoice_init_function () {
    /* ==============================================
    ********  //Регистрация кастомных типов постов
    =============================================== */
    function register_custom_post_types () {
      // Услуги
      // register_post_type( 'services', [
      //   'label'  => null,
      //   'labels' => [
      //     'name'               => 'Услуги', // основное название для типа записи
      //     'singular_name'      => 'Услуга', // название для одной записи этого типа
      //     'add_new'            => 'Добавить услугу', // для добавления новой записи
      //     'add_new_item'       => 'Добавление услуги', // заголовка у вновь создаваемой записи в админ-панели.
      //     'edit_item'          => 'Редактирование услуги', // для редактирования типа записи
      //     'new_item'           => 'Новая услуга', // текст новой записи
      //     'view_item'          => 'Показать услугу', // для просмотра записи этого типа.
      //     'search_items'       => 'Искать услугу', // для поиска по этим типам записи
      //     'not_found'          => 'Услуга не найдена', // если в результате поиска ничего не было найдено
      //     'not_found_in_trash' => 'Услуга не найдена в корзине', // если не было найдено в корзине
      //     'parent_item_colon'  => '', // для родителей (у древовидных типов)
      //     'menu_name'          => 'Услуги', // название меню
      //   ],
      //   'description'         => 'Это наши услуги',
      //   'public'              => true,
      //   'publicly_queryable'  => true, // зависит от public
      //   'exclude_from_search' => true, // зависит от public
      //   'show_ui'             => true, // зависит от public
      //   'show_in_nav_menus'   => true, // зависит от public
      //   'show_in_menu'        => true, // показывать ли в меню адмнки
      //   'show_in_admin_bar'   => true, // зависит от show_in_menu
      //   'show_in_rest'        => true, // добавить в REST API. C WP 4.7
      //   'rest_base'           => null, // $post_type. C WP 4.7
      //   'menu_position'       => 19,
      //   'menu_icon'           => 'dashicons-media-document',
      //   //'capability_type'   => 'post',
      //   //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
      //   //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
      //   'hierarchical'        => true,
      //   'supports'            => ['title', 'editor', 'thumbnail','excerpt', 'page-attributes' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
      //   'taxonomies'          => [],
      //   'has_archive'         => true,
      //   'rewrite'             => true,
      //   'query_var'           => true,
      // ] );
    }   
    
    register_custom_post_types();
    
    /* ==============================================
    ********  //Регистрация кастомных таксономий 
    =============================================== */
    function register_custom_taxonomy () {
      // // Категории публикаций
      // register_taxonomy( 'publications-category', [ 'publications' ], [
      //   'label'                 => '', // определяется параметром $labels->name
      //   'labels'                => [
      //     'name'              => 'Категории публикаций',
      //     'singular_name'     => 'Категория',
      //     'search_items'      => 'Найти категорию',
      //     'all_items'         => 'Все категории',
      //     'view_item '        => 'Посмотреть категорию',
      //     'parent_item'       => 'Родительская услуга',
      //     'parent_item_colon' => 'Родительская категория:',
      //     'edit_item'         => 'Редактировать категорию',
      //     'update_item'       => 'Обновить категорию',
      //     'add_new_item'      => 'Добавить новую категорию',
      //     'new_item_name'     => 'Название новой категории',
      //     'menu_name'         => 'Категории публикаций',
      //   ],
      //   'description'           => 'Категории публикаций', // описание таксономии
      //   'public'                => true,
      //   'publicly_queryable'    => true, // равен аргументу public
      //   // 'show_in_nav_menus'     => true, // равен аргументу public
      //   'show_ui'               => true, // равен аргументу public
      //    'show_in_menu'          => true, // равен аргументу show_ui
      //   // 'show_tagcloud'         => true, // равен аргументу show_ui
      //   // 'show_in_quick_edit'    => null, // равен аргументу show_ui
      //   'hierarchical'          => true,
      //   'rewrite'               => true,
      //   //'query_var'             => $taxonomy, // название параметра запроса
      //   // 'capabilities'          => array(),
      //   // 'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
      //   // 'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
      //   'show_in_rest'          => true, // добавить в REST API
      //   // 'rest_base'             => null, // $taxonomy
      //   // '_builtin'              => false,
      //   //'update_count_callback' => '_update_post_term_count',
      // ] );
    }   
  
    register_custom_taxonomy();

    /* ==============================================
    ********  //ACF опциональные страницы
    =============================================== */

    function medvoice_create_acf_pages() {
      if(function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
          'page_title' 	=> 'Настройки для темы Medvoice',
          'menu_title'	=> 'Настройки для темы Medvoice',
          'menu_slug' 	=> 'medvoice-settings',
          'capability'	=> 'edit_posts',
          'icon_url' => 'dashicons-admin-settings',
          'position' => 22,
          'redirect'		=> false,
        ));
      }    
    }

    medvoice_create_acf_pages();
  }  
endif;

/* ==============================================
  ********  //ACF редактирование набора инструментов редактора
  =============================================== */

add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
  
  array_push($toolbars['Full' ][1], 'underline');

  // return $toolbars - IMPORTANT!
  return $toolbars;
}

/* ==============================================
  ********  //Редиректы
  =============================================== */
add_action( 'parse_query', 'medvoice_disabled_some_links' );

function medvoice_disabled_some_links ( $query ) {  
  
  $cur_query = $query->query_vars;

  if( ($query->is_singular && $cur_query['post_type'] === 'product') ) {
    wp_redirect( home_url() );

    exit;
  }
}

/* ==============================================
  ********  //Фильтры ссылок
  =============================================== */
add_filter( 'register_url', 'medvoice_register_urf_filter' );
function medvoice_register_urf_filter( $register ){
	return '/?action=register';
}

add_filter( 'login_url', 'medvoice_login_url_filter', 10, 3 );
function medvoice_login_url_filter( $login_url, $redirect, $force_reauth ){
	return '/?action=login';
}
add_filter( 'wp_mail_content_type', 'medvoice_wp_mail_content_type_filter' );
function medvoice_wp_mail_content_type_filter( $content_type ){
	return 'text/html';
}

add_filter( 'wp_new_user_notification_email', 'wp_new_user_notification_email_filter', 10, 3 );
function wp_new_user_notification_email_filter( $wp_new_user_notification_email, $medvoice_user, $blogname ){
	$wp_new_user_notification_email['subject'] = __( 'Регистрация на сайте', 'medvoice' ) .' ' . wp_specialchars_decode( $blogname );
	$wp_new_user_notification_email['message'] = 
		get_custom_logo().'<br><br>
		'. __( 'Добро пожаловать на сайт', 'medvoice' ) .' '. get_bloginfo('name') . '<br>
		'. __( 'Ваш логин для входа:', 'medvoice' ) .' '.$medvoice_user->user_email.'<br>
		'. __( 'Вход:', 'medvoice' ) .' <a href="'.home_url('?action=login').'">'.home_url('?action=login').'</a>';
	
	return $wp_new_user_notification_email;
}

/* ==============================================
  ********  //Currency by Countries
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

function medvoice_get_price_text( $currency_code = 'USD', $price = 0 ) {
  switch ($currency_code) {
    case 'USD':
      return '$ ' . $price;

      break;

    case 'EUR':
      return '€ ' . $price;
      
      break;
    
    case 'RUR':
      return $price . ' руб';
      
      break;

    case 'UAH':
      return $price . ' грн';
      
      break;
    
    default:
      return '$ ' . $price;

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

if ( class_exists( 'WC_wayforpay' ) && class_exists( 'woocommerce' )) {
  /* ==============================================
  ********  //Смена статуса заказа при успешной оплате
  =============================================== */
  add_action( 'woocommerce_payment_complete_order_status_processing', 'medvoice_set_completed_for_paid_orders' );

  function medvoice_set_completed_for_paid_orders( $order_id ) 
  {

    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );   
    
  }  

  /* ==============================================
  ********  //Обновление данных о подписке пользователя при смене статуса заказа
  =============================================== */
  add_action( 'woocommerce_order_status_changed', 'medvoice_woocommerce_order_status_changed', 10, 4 );

  function medvoice_woocommerce_order_status_changed( $order_id, $status_transition_from, $status_transition_to, $that )
  { 
    $order = wc_get_order( $order_id );

    if ( $order instanceof WC_Order) {
      // Статус сменился на Завершен
      if ( $status_transition_to === 'completed' ) { 
        medvoice_subscribe( $order, 'to' );     
      }
      
      // Статус сменился на любой кроме Завершенного
      if ( $status_transition_from === 'completed' ) {
        medvoice_subscribe( $order, 'from' );
      }      
    }     
  }

  /* ==============================================
  ********  //Подписка на тариф 
  ********  //(создание заказа WooCommerce)
  =============================================== */
  
  if ( is_user_logged_in(  ) ) {
    add_action( 'wp_ajax_medvoice_create_order_ajax', 'medvoice_create_order_ajax' );
    add_action( 'wp_ajax_nopriv_medvoice_create_order_ajax', 'medvoice_create_order_ajax' );
  }  

  function medvoice_create_order_ajax(  ) {
    try {
      // Проверка nonce
      check_ajax_referer('additional-script.js_nonce', 'security');

      // Получение срока подписки
      $months = isset($_REQUEST['months']) ? (int) trim( $_REQUEST['months'] ) : null;

      if ( isset($months) ) {
        // Получить ID Товара из $_REQUEST
        $product_id = isset($_REQUEST['product_id']) ? (int) trim( $_REQUEST['product_id'] ) : null;

        if ( isset($product_id) ) {

          // Создание заказа
          medvoice_create_order($product_id, $months);
               
        } else {
          $response = [
            'message' => __('Товар не существует', 'medvoice'),
          ];

          wp_send_json_error( $response );
        } 
      } else {
        $response = [
          'message' => __('Не указан период', 'medvoice'),
        ];

        wp_send_json_error( $response );        
      } 
      
      wp_die(  );
    } catch (\Throwable $th) {
      $response = [
        'error' => $th,
        'message' => __('Что-то пошло не так...', 'medvoice'),
      ];

      wp_send_json_error( $response );

      wp_die(  );
    }
  }

  function medvoice_create_order( $product_id = null, $months = null ) 
  {
    // Получить корзину
    $cart = WC()->cart ?? null;

    if ($cart && $cart instanceof WC_Cart) {
      // Очистить корзину на старте оформления
      $cart->empty_cart();

      // Добавить выбранный Товар
      $cart->add_to_cart( $product_id );

      // Получение данных о Пользователе 
      $medvoice_user = wp_get_current_user();

      if ( $medvoice_user instanceof WP_User) {
        $user_id = $medvoice_user->ID;    
          
        // Данные для WooCommerce
        $address = [];
          
        // Создание заказа
        $attr = [
          'customer_id'   => $user_id,
          'created_via'   => 'medvoice_ajax',
        ];

        // Если оформляется триал - переводим заказ в выполненный сразу
        if ( !isset($months) ) {
          $attr['status'] = 'completed';
        }  

        $order = wc_create_order( $attr );
    
        // Информация о покупателе
        $order->set_address( $address, 'billing' );
        $order->set_address( $address, 'shipping' );

        // Товары из корзины
        foreach( $cart->get_cart() as $cart_item_key => $cart_item ) {

          $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
          $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

          $order->add_product( $_product, $cart_item['quantity'], [
            'variation' => $cart_item['variation'],
            'totals'    => [
              'subtotal'     => $cart_item['line_subtotal'],
              'subtotal_tax' => $cart_item['line_subtotal_tax'],
              'total'        => $cart_item['line_total'],
              'tax'          => $cart_item['line_tax'],
              'tax_data'     => $cart_item['line_tax_data']
            ]
          ]);
        }

        // Добавить купоны
        foreach ( $cart->get_coupons() as $code => $coupon ) {
          $order->add_coupon( $code, $cart->get_coupon_discount_amount( $code ), $cart->get_coupon_discount_tax_amount( $code ) );
        }

        $order->calculate_totals();

        // Записываю кол-во месяцев в заказ
        if ( isset($months) ) {
          $order->update_meta_data( 'months', $months );
          $order->update_meta_data( 'trial', 0 );
        } else {    
          $order->update_meta_data( 'months', 0 );            
          $order->update_meta_data( 'trial', 1 );
        }
        
        // Сохранение обновлений мета заказа
        $order->save();

        // Отправить письмо юзеру
        $mailer = WC()->mailer();
        $email = $mailer->emails['WC_Email_Customer_Processing_Order'];
        $email->trigger( $order->id );

        // Отправить письмо админу
        $email = $mailer->emails['WC_Email_New_Order'];
        $email->trigger( $order->id );

        // Очистить корзину
        $cart->empty_cart();

        

        // Если заказ не триальный - выставляем счет
        if ( isset($months) ) {
          // Получаем форму WayForPay
          $new_wc_wayforpay = new WC_wayforpay();

          $wayforpay_form = $new_wc_wayforpay->medvoice_generate_wayforpay_form( $order->id );  

          $response = [
            'message' => __('Успешно сформирован счет в WayForPay. Идёт перенаправление...', 'medvoice'), 
            'form' => $wayforpay_form,               
          ];
          
          
          wp_send_json_success( $response );
        }     
      } else {
        $response = [
          'message' => __('Пользователь не существует', 'medvoice'),
        ];

        wp_send_json_error( $response );
      }            
    } else {
      $response = [
        'message' => __('Корзина не существует', 'medvoice'),
      ];

      wp_send_json_error( $response );
    } 
  }

  /* ==============================================
  ********  //Подписка на тариф 
  ********  //(оформление подписки после оплаты заказа WooCommerce или откат подписки при отмене заказа)
  =============================================== */
  function medvoice_subscribe( $order = null, $direction = 'to' )
  {
    if ( isset($order) ) {
      $months = (int) $order->get_meta( 'months' );
      $trial = (int) $order->get_meta( 'trial' );

      $user_id = $order->get_user_id();

      $medvoice_user = get_user_by( 'id', $user_id );

      if ( $medvoice_user instanceof WP_User) {  
        // Оформление подписки после оплаты заказа
        if ( $direction === 'to' ) {        
          $start_time = (!empty($medvoice_user->get('st')) && $medvoice_user->get('st') > time()) ? $medvoice_user->get('st') : time();
          
          $st = time();

          if ( $months > 0 ) {
            $st = mktime(date('H', time()), date('i', time()), date('s', time()), date('m', $start_time) + $months, date('d', $start_time), date('Y', $start_time));
          } else {
            $trial_days = get_field( 'trial_days', 'options' ) ?? 7;

            $st = mktime(date('H', time()), date('i', time()), date('s', time()), date('m', $start_time), date('d', $start_time) + $trial_days, date('Y', $start_time));
          }          

          update_metadata('user', $medvoice_user->ID, 'subscribed', 1);
          update_metadata('user', $medvoice_user->ID, 'st', $st);
        } 
        
        // Откат подписки при отмене заказа 
        if ( $direction === 'from' ) {    
          $end_time = (!empty($medvoice_user->get('st')) && $medvoice_user->get('st') > time()) ? $medvoice_user->get('st') : time();
          
          $st = mktime(date('H', $end_time), date('i', $end_time), date('s', $end_time), date('m', $end_time) - $months, date('d', $end_time), date('Y', $end_time));

          update_metadata('user', $medvoice_user->ID, 'st', $st);

          if ( $st <= time() ) {
            update_metadata('user', $medvoice_user->ID, 'subscribed', 0);
          }
        }
        
      }
    }    
    
  }

  /* ==============================================
  ********  //Список подписок пользователя 
  ********  //(для личного кабинета)
  =============================================== */
  function medvoice_get_user_subscribe_list(  )
  {
    if ( is_user_logged_in(  ) ) {
      $medvoice_user = wp_get_current_user(  );

      $args = [
        'customer_id' => $medvoice_user->ID,
        'status' => ['wc-completed'],
        'return' => 'object'
      ];

      $orders = wc_get_orders( $args );

      return $orders;
    }
  }

  /* ==============================================
  ********  //Кол-во оставшихся дней подписки пользователя 
  ********  //(для личного кабинета)
  =============================================== */
  function medvoice_get_user_subscribe_days_left() 
  {

  }

  /* ==============================================
  ********  //Конечная дата подписки пользователя 
  ********  //(-)
  =============================================== */
  function medvoice_get_user_subscribe_end_date()
  {
    if ( is_user_logged_in(  ) ) {
      $st = time();

      $medvoice_user = wp_get_current_user(  );

      $subscribed = !empty($medvoice_user->get( 'subscribed' )) ? (int) $medvoice_user->get( 'subscribed' ) : 0;

      if ( $subscribed === 1 ) {
        $st = !empty($medvoice_user->get( 'st' )) ? $medvoice_user->get( 'st' ) : time();
      }

      return date('Y-m-d H:i:s', utc_to_usertime($st));
    }
  }
} 

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
  
  wp_die(  );
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