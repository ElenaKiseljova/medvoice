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
  wp_enqueue_style('swiper-style', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css');

  wp_enqueue_style('medvoice-style', get_stylesheet_uri());    
}

// Scripts theme
add_action('wp_enqueue_scripts', 'medvoice_scripts', 5);
function medvoice_scripts () 
{  
  wp_enqueue_script('swiper-script', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', $deps = array(), $ver = null, $in_footer = true );
 
  if ( !is_page( medvoice_get_special_page( 'forms', 'id'  ) ) && !is_page( medvoice_get_special_page( 'tariffs', 'id'  ) ) ) {
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/script.js', $deps = array(), $ver = null, $in_footer = true );
  }

  wp_enqueue_script('cookie-edit-script', get_template_directory_uri() . '/assets/js/cookie-edit.js', $deps = array(), $ver = null, $in_footer = true );
  wp_enqueue_script('files-script', get_template_directory_uri() . '/assets/js/files.js', $deps = array(), $ver = null, $in_footer = true );
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
    'forms' => medvoice_get_special_page( 'forms', 'url' ) ?? get_home_url(  ),
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

// After_setup_theme
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
    /* Видео (карточка) */
    add_image_size( 'video_card', 245, 160, false);

    add_image_size( 'video_side', 140, 80, false);

    /* Видео (постер) */
    add_image_size( 'video_poster', 655, 380, false);
  }
endif;

// Init
add_action( 'init', 'medvoice_init_function' );
  
if (!function_exists('medvoice_init_function')) :
  function medvoice_init_function () 
  {
    /* ==============================================
    ********  //Регистрация кастомных типов постов
    =============================================== */
    function register_custom_post_types () 
    {
      // Видео
      register_post_type( 'videos', [
        'label'  => null,
        'labels' => [
          'name'               => 'Видео', // основное название для типа записи
          'singular_name'      => 'Видео', // название для одной записи этого типа
          'add_new'            => 'Добавить видео', // для добавления новой записи
          'add_new_item'       => 'Добавление видео', // заголовка у вновь создаваемой записи в админ-панели.
          'edit_item'          => 'Редактирование видео', // для редактирования типа записи
          'new_item'           => 'Новое видео', // текст новой записи
          'view_item'          => 'Показать видео', // для просмотра записи этого типа.
          'search_items'       => 'Искать видео', // для поиска по этим типам записи
          'not_found'          => 'Видео не найдено', // если в результате поиска ничего не было найдено
          'not_found_in_trash' => 'Видео не найдено в корзине', // если не было найдено в корзине
          'parent_item_colon'  => 'Родительское видео', // для родителей (у древовидных типов) [P.S.ЧЕРТОВА СТРОЧКА РЕАЛЬНО ВАЖНАЯ!!]
          'menu_name'          => 'Видео', // название меню
        ],
        'description'         => 'Это наши видео',
        'public'              => true,
        'publicly_queryable'  => true, // зависит от public
        'exclude_from_search' => true, // зависит от public
        'show_ui'             => true, // зависит от public
        'show_in_nav_menus'   => true, // зависит от public
        'show_in_menu'        => true, // показывать ли в меню адмнки
        'show_in_admin_bar'   => true, // зависит от show_in_menu
        'show_in_rest'        => true, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-playlist-video',
        'hierarchical'        => true,
        'supports'            => [ 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields', 'author' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => [ 'sections', 'labels', 'format', 'authors', 'langs' ],
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'katalog','with_front' => false ],
        'query_var'           => true,
      ] );
    }       
    
    register_custom_post_types();
    
    /* ==============================================
    ********  //Регистрация кастомных таксономий 
    =============================================== */
    function register_custom_taxonomy () 
    {
      // Категории
      register_taxonomy( 'sections', [ 'videos' ], [
        'label'                 => __( 'Категория', 'medvoice' ), // определяется параметром $labels->name
        'labels'                => [
          'name'              => __( 'Категория', 'medvoice' ),
          'singular_name'     => 'Категория',
          'search_items'      => 'Найти категорию',
          'all_items'         => 'Все категории',
          'view_item '        => 'Посмотреть категорию',
          'parent_item'       => 'Родительская категория',
          'parent_item_colon' => 'Родительская категория:',
          'edit_item'         => 'Редактировать категорию',
          'update_item'       => 'Обновить категорию',
          'add_new_item'      => 'Добавить новую категорию',
          'new_item_name'     => 'Название новой категории',
          'menu_name'         => 'Категории',
        ],
        'description'           => 'Категории видео', // описание таксономии
        'public'                => false,
        'publicly_queryable'    => false, // равен аргументу public
        'show_ui'               => true, // равен аргументу public
        'show_in_menu'          => true, // равен аргументу show_ui
        'show_in_rest'          => true,
        'hierarchical'          => true,
        'rewrite'               => true,
      ] );

      // Теги
      register_taxonomy( 'labels', [ 'videos' ], [
        'label'                 => __( 'Теги проблематики', 'medvoice' ), // определяется параметром $labels->name
        'labels'                => [
          'name'              => __( 'Теги проблематики', 'medvoice' ),
          'singular_name'     => 'Тег',
          'search_items'      => 'Найти тег',
          'all_items'         => 'Все теги',
          'view_item '        => 'Посмотреть тег',
          'parent_item'       => 'Родительский тег',
          'parent_item_colon' => 'Родительский тег:',
          'edit_item'         => 'Редактировать тег',
          'update_item'       => 'Обновить тег',
          'add_new_item'      => 'Добавить новый тег',
          'new_item_name'     => 'Название нового тега',
          'menu_name'         => 'Теги',
        ],
        'description'           => 'Теги видео', // описание таксономии
        'public'                => false,
        'publicly_queryable'    => false, // равен аргументу public
        'show_ui'               => true, // равен аргументу public
        'show_in_menu'          => true, // равен аргументу show_ui
        'show_in_rest'          => true, 
        'hierarchical'          => false,
        'rewrite'               => true,
      ] );

      // Формат
      register_taxonomy( 'format', [ 'videos' ], [
        'label'                 => __( 'Формат', 'medvoice' ),  // определяется параметром $labels->name
        'labels'                => [
          'name'              => __( 'Формат', 'medvoice' ),
          'singular_name'     => 'Формат',
          'search_items'      => 'Найти формат',
          'all_items'         => 'Все форматы',
          'view_item '        => 'Посмотреть формат',
          'parent_item'       => 'Родительский формат',
          'parent_item_colon' => 'Родительский формат:',
          'edit_item'         => 'Редактировать формат',
          'update_item'       => 'Обновить формат',
          'add_new_item'      => 'Добавить новый формат',
          'new_item_name'     => 'Название нового формата',
          'menu_name'         => 'Форматы',
        ],
        'description'           => 'Форматы видео', // описание таксономии
        'public'                => true,
        'publicly_queryable'    => true, // равен аргументу public
        'show_ui'               => true, // равен аргументу public
        'show_in_menu'          => true, // равен аргументу show_ui
        'show_in_rest'          => true, 
        'hierarchical'          => true,
        'rewrite'               => true,
      ] );

      // Автор
      register_taxonomy( 'authors', [ 'videos' ], [
        'label'                 => __( 'Автор', 'medvoice' ), // определяется параметром $labels->name
        'labels'                => [
          'name'              => __( 'Автор', 'medvoice' ),
          'singular_name'     => 'Автор',
          'search_items'      => 'Найти автора',
          'all_items'         => 'Все авторы',
          'view_item '        => 'Посмотреть автора',
          'parent_item'       => 'Родительский автор',
          'parent_item_colon' => 'Родительский автор:',
          'edit_item'         => 'Редактировать автора',
          'update_item'       => 'Обновить автора',
          'add_new_item'      => 'Добавить нового автора',
          'new_item_name'     => 'Название нового автора',
          'menu_name'         => 'Авторы',
        ],
        'description'           => 'Авторы видео', // описание таксономии
        'public'                => true,
        'publicly_queryable'    => true, // равен аргументу public
        'show_ui'               => true, // равен аргументу public
        'show_in_menu'          => true, // равен аргументу show_ui
        'show_in_rest'          => true, 
        'hierarchical'          => true,
        'rewrite'               => true,
      ] );

      // Языки
      register_taxonomy( 'langs', [ 'videos' ], [
        'label'                 => __( 'Язык', 'medvoice' ), // определяется параметром $labels->name
        'labels'                => [
          'name'              => __( 'Язык', 'medvoice' ),
          'singular_name'     => 'Язык',
          'search_items'      => 'Найти язык',
          'all_items'         => 'Все языки',
          'view_item '        => 'Посмотреть язык',
          'parent_item'       => 'Родительский язык',
          'parent_item_colon' => 'Родительский язык:',
          'edit_item'         => 'Редактировать язык',
          'update_item'       => 'Обновить язык',
          'add_new_item'      => 'Добавить новый язык',
          'new_item_name'     => 'Название нового языка',
          'menu_name'         => 'Языки',
        ],
        'description'           => 'Языки видео', // описание таксономии
        'public'                => false,
        'publicly_queryable'    => false, // равен аргументу public
        'show_ui'               => true, // равен аргументу public
        'show_in_menu'          => true, // равен аргументу show_ui
        'show_in_rest'          => true, 
        'hierarchical'          => true,
        'rewrite'               => true,
      ] );

      // Убираю Категории продуктов из карты сайта
      unregister_taxonomy( 'product_cat' );  
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
          'position' => 23,
          'redirect'		=> false,
        ));
      }    
    }

    medvoice_create_acf_pages();
  }  
endif;

/* ==============================================
  ********  //Фильтр polylang для добавления 
  ********  //перевоыдов непубликуемым таксономиям
  =============================================== */

  add_filter( 'pll_get_taxonomies', 'add_tax_to_pll', 10, 2 );
  
  function add_tax_to_pll( $taxonomies, $is_settings ) {
      if ( $is_settings ) {
        
      } else {
        $taxonomies['sections'] = 'sections';
        $taxonomies['labels'] = 'labels';
        $taxonomies['format'] = 'format';
        $taxonomies['authors'] = 'authors';
      }

      return $taxonomies;
  }

/* ==============================================
  ********  //ACF редактирование набора инструментов редактора
  =============================================== */

add_filter( 'acf/fields/wysiwyg/toolbars' , 'medvoice_acf_custom_toolbars'  );
function medvoice_acf_custom_toolbars( $toolbars )
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

  if( ($query->is_singular && $cur_query['post_type'] === 'product') || is_category(  ) ) {
    wp_redirect( home_url() );

    exit;
  }
}

/* ==============================================
  ********  //Фильтры ссылок
  =============================================== */
add_filter( 'register_url', 'medvoice_register_urf_filter' );
function medvoice_register_urf_filter( $register ){
	return  medvoice_get_special_page( 'forms', 'url'  ) . '?action=register';
}

add_filter( 'login_url', 'medvoice_login_url_filter', 10, 3 );
function medvoice_login_url_filter( $login_url, $redirect, $force_reauth ){
	return medvoice_get_special_page( 'forms', 'url'  ) . '?action=login';
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
		'. __( 'Вход:', 'medvoice' ) .' <a href="' . medvoice_get_special_page( 'forms', 'url'  ) . '?action=login">' . __( 'перейти на страницу логирования', "medvoice" ) . '</a>';
	
	return $wp_new_user_notification_email;
}

/* ==============================================
  ********  //Получение ссылок на спецстраницы
  =============================================== */
  /**
   * $type: forms, catalog, profile, tariffs, bookmarks
   */
  function medvoice_get_special_page( $type = 'forms', $format = 'url' )
  {
    $page_name = $type . '_page_id';

    $page_id = get_field( $page_name, 'options' ) ?? null;
    
    if ( function_exists( 'pll_get_post' ) ) {
      $page_id = pll_get_post( $page_id ) ?? $page_id;
    }

    if ( $format === 'id') {
      return $page_id;
    }

    if ( $format === 'url') {
      $page_url = get_permalink( $page_id );
    
      return $page_url;
    }
  
    return;
  }

  /* ==============================================
  ********  //Получение Логотипов
  =============================================== */
  /**
   * $place: nav, user, tariff
   */
  function medvoice_get_logo_html( $place = 'nav' )
  {
    $logo_large = get_theme_mod( 'logo_large' ) ?? '';
    $logo_narrow = get_theme_mod( 'logo_narrow' ) ?? '';

    ?>
      <a href="<?= get_bloginfo( 'url' ); ?>" class="logo logo--<?= $place; ?>">
        <img class="logo__img" src="<?= $logo_large; ?>" alt="<?= get_bloginfo( 'name' ); ?>">

        <?php if ( $place === 'nav' ) : ?>
          <img class="logo__img--short hidden" src="<?= $logo_narrow; ?>" alt="<?= get_bloginfo( 'name' ); ?>">
        <?php endif; ?>        
      </a>
    <?php
  }

  /* ==============================================
  ********  //Правильные окончания для слов
  =============================================== */
  function medvoice_pluralize($string, $ch1, $ch2, $ch3)
  {
      $ff = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

      if (substr($string, -2, 1) == 1 and strlen($string) > 1) {
        $ry = array("0 $ch3", "1 $ch3", "2 $ch3", "3 $ch3", "4 $ch3", "5 $ch3", "6 $ch3", "7 $ch3", "8 $ch3", "9 $ch3");
      } else {
        $ry = array(
          "0 $ch3",
          "1 $ch1",
          "2 $ch2",
          "3 $ch2",
          "4 $ch2",
          "5 $ch3",
          "6 $ch3",
          "7 $ch3",
          "8 $ch3",
          "9 $ch3"
        );
      }

      $string1 = substr($string, 0, -1) . str_replace($ff, $ry, substr($string, -1, 1));

      return $string1;
  }

  /* ==============================================
  ********  //Получение единичного названия Формата видео
  =============================================== */
  /**
   * $what: [ name, link ]
   */
  function medvoice_get_single_format_video_arr( $video_id = null, $what = ['name'], $single = true )
  {
    if ( isset($video_id) ) {
      $video_format = [
        'name' => '',
        'link' => ''
      ];
      
      $video_format_terms = wp_get_post_terms( $video_id, 'format' ) ?? [];
      $video_format_term = ( !is_wp_error( $video_format_terms ) && !empty($video_format_terms) ) ? $video_format_terms[0] : null;
      
      if ( isset($video_format_term) && $video_format_term instanceof WP_Term ) {
        if ( in_array( 'name', $what ) ) {
          if ( $single ) {
            $video_format_name = get_field( 'single', $video_format_term ) ?? $video_format_term->name;

            $video_format['name'] = $video_format_name ?? '';
          } else {
            $video_format['name'] = $video_format_term->name ?? '';
          }
        }

        if ( in_array( 'link', $what ) ) {
          $video_format['link'] = get_term_link( $video_format_term ) ?? '';
        }  
      }
      
      return $video_format;
    }

    return false;
  }

  /* ==============================================
  ********  //Получение массива ИД с переводами поста
  =============================================== */
  function medvoice_get_post_languages_arr( $post_id = null )
  {
    $post_ids = [];

    if ( isset($post_id) ) {
      $args = [
        'hide_empty' => 0,
        'fields' => 'slug',
      ];
    
      $languages = pll_languages_list($args) ?? [];

      foreach ($languages as $key => $language) {
        $post_ids[] = pll_get_post( $post_id, $language );
      }
    }

    return $post_ids; 
  }
?>