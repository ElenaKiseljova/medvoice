<?php 
/*INCLUDE SETTINGS FUNCTIONS.PHP*/
require_once( TEMPLATEPATH . '/functions_settings.php' );

/*INCLUDE SEARCH FUNCTIONS.PHP*/
require_once( TEMPLATEPATH . '/functions_search.php' );

/*INCLUDE CURRENCY BY GEO FUNCTIONS.PHP*/
require_once( TEMPLATEPATH . '/functions_currency_by_geo.php' );

/*INCLUDE USER TIME FUNCTIONS.PHP*/
require_once( TEMPLATEPATH . '/functions_user_time.php' );

/*INCLUDE USER FUNCTIONS.PHP*/
require_once( TEMPLATEPATH . '/functions_user.php' );

/*INCLUDE SUBSCRIBE FUNCTIONS.PHP*/
require_once( TEMPLATEPATH . '/functions_subscribe.php' );

/* medvoice */
  
// Styles theme
add_action('wp_enqueue_scripts', 'medvoice_styles', 3);
function medvoice_styles () 
{
  // wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

  wp_enqueue_style('swiper-style', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css');

  wp_enqueue_style('medvoice-style', get_stylesheet_uri());    
}

// Scripts theme
add_action('wp_enqueue_scripts', 'medvoice_scripts', 5);
function medvoice_scripts () 
{  
  wp_enqueue_script('swiper-script', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', $deps = array(), $ver = null, $in_footer = true );
 
  wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/script.js', $deps = array(), $ver = null, $in_footer = true );

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

// Customizer
add_action( 'customize_register', 'medvoice_customizer' ); 
function medvoice_customizer ( $wp_customize ) 
{
  /* Create Panel Logo */  
  $wp_customize->add_panel('logo', array(
    'priority' => 50,
    'theme_supports' => '',
    'title' => __('Логотип', 'medvoice'),
    'description' => __('Изображения для Логотипа и его узкой версии', 'medvoice'),
  ));
  
  /* Create Sections for Panel Logo */  
  $wp_customize->add_section('logo_large', array(
    'panel' => 'logo',
    'type' => 'theme_mod', 
    'priority' => 5,
    'theme_supports' => '',
    'title' => __('Логотип (широкий)', 'medvoice'),
    'description' => '',
  ));
  
  $wp_customize->add_section('logo_narrow', array(
    'panel' => 'logo',
    'type' => 'theme_mod', 
    'priority' => 10,
    'theme_supports' => '',
    'title' => __('Логотип (узкий)', 'medvoice'),
    'description' => '',
  ));
  
  /* Create Settings for Panel Logo */  
  $wp_customize->add_setting('logo_large', array(
    'default'    =>  '',
    'transport'  =>  'refresh',
  ));
  
  $wp_customize->add_setting('logo_narrow', array(
    'default'    =>  '',
    'transport'  =>  'refresh',
  ));
  
  /* Create Controls for Panel Logo */  
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo_image_large', array(
      'label'    => __('Изображение логотипа', 'medvoice'),
      'section'  => 'logo_large',
      'settings' => 'logo_large',
  )));
  
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo_image_narrow', array(
      'label'    => __('Изображение логотипа', 'medvoice'),
      'section'  => 'logo_narrow',
      'settings' => 'logo_narrow',
  )));  
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
	return  get_special_page_url(  ) . '?action=register';
}

add_filter( 'login_url', 'medvoice_login_url_filter', 10, 3 );
function medvoice_login_url_filter( $login_url, $redirect, $force_reauth ){
	return get_special_page_url(  ) . '?action=login';
}

add_filter( 'wp_mail_content_type', 'medvoice_wp_mail_content_type_filter' );
function medvoice_wp_mail_content_type_filter( $content_type ){
	return 'text/html';
}

add_filter( 'wp_new_user_notification_email', 'wp_new_user_notification_email_filter', 10, 3 );
function wp_new_user_notification_email_filter( $wp_new_user_notification_email, $medvoice_user, $blogname ){
	$wp_new_user_notification_email['subject'] = __( 'Регистрация на сайте', 'medvoice' ) .' ' . wp_specialchars_decode( $blogname );
	
  $logo_large = get_theme_mod( 'logo_large' ) ?? '';

  $wp_new_user_notification_email['message'] = 
		__( 'Добро пожаловать на сайт', 'medvoice' ) .' '. get_bloginfo('name') . '<br>
		'. __( 'Ваш логин для входа:', 'medvoice' ) .' '.$medvoice_user->user_email.'<br>
		'. __( 'Вход:', 'medvoice' ) .' <a href="' . get_special_page_url(  ) . '?action=login">' . __( 'перейти на страницу логирования', "medvoice" ) . '</a>';
	
	return $wp_new_user_notification_email;
}

/* ==============================================
  ********  //Получение ссылок на спецстраницы
  =============================================== */
  
  function get_special_page_url( $type = 'forms' )
  {
    $page_name = $type . '_page_id';

    $page_id = get_field( $page_name, 'options' ) ?? null;
  
    if ( function_exists( 'pll_get_post' ) ) {
      $page_id = pll_get_post( $page_id );
    }
  
    $page_url = get_permalink( $page_id );
    
    return $page_url;
  }

?>