<?php 
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

  function medvoice_create_order_ajax(  ) 
  {
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

          die(  );
        } 
      } else {
        $response = [
          'message' => __('Не указан период', 'medvoice'),
        ];

        wp_send_json_error( $response );        
      } 
      
      die(  );
    } catch (\Throwable $th) {
      $response = [
        'error' => $th,
        'message' => __('Что-то пошло не так...', 'medvoice'),
      ];

      wp_send_json_error( $response );

      die(  );
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
          $order->update_meta_data( 'trial', '0' );
        } else {    
          $order->update_meta_data( 'months', 0 );            
          $order->update_meta_data( 'trial', '1' );
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
          'user' => $medvoice_user
        ];

        wp_send_json_error( $response );

        die(  );
      }            
    } else {
      $response = [
        'message' => __('Корзина не существует', 'medvoice'),
      ];

      if ( isset($months) ) {
        wp_send_json_error( $response );

        die(  );
      } else {
        wp_redirect( get_home_url(  ) );

        exit();
      }        
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
      $trial = $order->get_meta( 'trial' );

      $user_id = $order->get_user_id();

      $medvoice_user = get_user_by( 'id', $user_id );

      if ( $medvoice_user instanceof WP_User) {  
        // Оформление подписки после оплаты заказа
        if ( $direction === 'to' ) {        
          $start_time = (!empty($medvoice_user->get('st')) && $medvoice_user->get('st') > time()) ? $medvoice_user->get('st') : time();
          
          $st = time();

          if ( $months > 0 ) {
            $st = mktime(date('H', time()), date('i', time()), date('s', time()), date('m', $start_time) + $months, date('d', $start_time), date('Y', $start_time));
            
            update_user_meta($medvoice_user->ID, 'trial', '0');
            update_user_meta($medvoice_user->ID, 'subscribed', '1');
          } else {
            $trial_days = get_field( 'trial_days', 'options' ) ?? 7;

            $st = mktime(date('H', time()), date('i', time()), date('s', time()), date('m', $start_time), date('d', $start_time) + $trial_days, date('Y', $start_time));
            
            update_user_meta($medvoice_user->ID, 'trial', '1');
          }   
          
          update_user_meta($medvoice_user->ID, 'st', $st);
        } 
        
        // Откат подписки при отмене заказа 
        if ( $direction === 'from' ) {    
          $end_time = (!empty($medvoice_user->get('st')) && $medvoice_user->get('st') > time()) ? $medvoice_user->get('st') : time();
          
          $st = mktime(date('H', $end_time), date('i', $end_time), date('s', $end_time), date('m', $end_time) - $months, date('d', $end_time), date('Y', $end_time));

          update_user_meta($medvoice_user->ID, 'st', $st);

          if ( $st <= time() ) {
            update_user_meta($medvoice_user->ID, 'subscribed', '0');
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

    return;
  }

  /* ==============================================
  ********  //Кол-во оставшихся дней подписки пользователя 
  ********  //(для личного кабинета)
  =============================================== */
  function medvoice_get_user_subscribe_days_left() 
  {
    if ( is_user_logged_in(  ) ) {
      $st = time();

      $medvoice_user = wp_get_current_user(  );

      $subscribed = !empty($medvoice_user->get( 'subscribed' )) ? $medvoice_user->get( 'subscribed' ) : '0';

      if ( $subscribed === '1' ) {
        $st = !empty($medvoice_user->get( 'st' )) ? $medvoice_user->get( 'st' ) : $st;
      }

      $start_date = new DateTime( date( 'Y-m-d' ) );
      $end_date = new DateTime( date( 'Y-m-d', $st ));

      $difference = $end_date->diff( $start_date );

      $subscribe_days_left = $difference->format("%a");

      return $subscribe_days_left;     
    }

    return;
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

      $subscribed = !empty($medvoice_user->get( 'subscribed' )) ? $medvoice_user->get( 'subscribed' ) : '0';

      if ( $subscribed === '1' ) {
        $st = !empty($medvoice_user->get( 'st' )) ? $medvoice_user->get( 'st' ) : $st;
      }

      return date('Y-m-d H:i:s', utc_to_usertime($st));
    }

    return;
  }

  function medvoice_check_user_subscribe_trial() {
    if ( is_user_logged_in(  ) ) {
      $medvoice_user = wp_get_current_user(  );

      $trial = !empty($medvoice_user->get( 'trial' )) ? $medvoice_user->get( 'trial' ) : '0';
      $subscribed = !empty($medvoice_user->get( 'subscribed' )) ? $medvoice_user->get( 'subscribed' ) : '0';

      return get_user_meta( $medvoice_user->ID );
    }

    return;
  }
} 
?>