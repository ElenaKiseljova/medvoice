<?php 
  /* ==============================================
  ********  //Переопределяю шаблон формы поиска
  =============================================== */
  add_filter('get_search_form', 'medvoice_search_form');

  function medvoice_search_form( $form ) 
  {
    $form = '
        <form class="header__form" action="' . home_url( '/' ) . '" method="get" role="search">
          <input class="header__field" autocomplete="off" type="text" 
            name="s" 
            placeholder="' . __( 'Поиск...', 'medvoice' ) . '"            
          /> 
          
          <input type="hidden" name="post_type" value="videos" />
        </form>';

    return $form;
  }

  if( wp_doing_ajax() ) {
    add_action('wp_ajax_medvoice_ajax_sub_category_list', 'medvoice_ajax_sub_category_list');
    add_action('wp_ajax_nopriv_medvoice_ajax_sub_category_list', 'medvoice_ajax_sub_category_list'); 

    add_action('wp_ajax_medvoice_ajax_search_list', 'medvoice_ajax_search_list');
    add_action('wp_ajax_nopriv_medvoice_ajax_search_list', 'medvoice_ajax_search_list'); 

    add_action('wp_ajax_medvoice_ajax_videos_cards_html', 'medvoice_ajax_videos_cards_html');
    add_action('wp_ajax_nopriv_medvoice_ajax_videos_cards_html', 'medvoice_ajax_videos_cards_html'); 
  }

  function medvoice_ajax_sub_category_list()
  {
    try {
      // Первым делом проверяем параметр безопасности
      check_ajax_referer('additional-script.js_nonce', 'security');

      $taxonomy = $_POST['taxonomy'] ? htmlspecialchars($_POST['taxonomy']) : '';
      $terms = $_POST['terms'] ? htmlspecialchars($_POST['terms']) : '';

      if ( empty($taxonomy) ) {
        wp_send_json_error( [
          'message' => 'Нет таксономии',
        ] );
      }

      $response = [
        // 'post' => $_POST,
      ];

      ob_start();

      medvoice_sub_category_list( $taxonomy, $terms );
  
      $response['content'] = ob_get_contents();
  
      ob_clean();
  
      wp_send_json_success( $response );
    } catch (Throwable $th) {
      wp_send_json_error( $th );
    } 

    die();
  }

  function medvoice_sub_category_list( $taxonomy = 'sections', $terms = '' )
  {
    $terms = explode(',', $terms);

    if ( !empty($terms) && is_array($terms) && !is_wp_error( $terms ) ) {
      foreach ($terms as $key => $term_id) {
        $term_children_ids = get_term_children( $term_id, $taxonomy );

        if ( !is_wp_error( $term_children_ids ) && !empty($term_children_ids) ) {
          $i = 1;
          foreach ($term_children_ids as $key => $term_child_id) {
            $term_child = get_term_by( 'id', $term_child_id, $taxonomy );

            if ( is_a($term_child, 'WP_Term') ) {
              ?>
                <li class="dropdown__item">
                  <input class="dropdown__check" type="checkbox" 
                    id="<?= $taxonomy . '-sub-' . $term_child_id; ?>" 
                    name="<?= $taxonomy; ?>-sub"
                    value="<?= $term_child_id; ?>">
                  <label class="dropdown__label" for="<?= $taxonomy . '-sub-' . $term_child_id; ?>"><?= $term_child->name; ?></label>
                </li>
              <?php
            }

            $i++;
          }
        }
      }
    } else {
      return;
    }    
  }

  function medvoice_ajax_search_list()
  {
    try {
      // Первым делом проверяем параметр безопасности
      check_ajax_referer('additional-script.js_nonce', 'security');

      $s = $_POST['s'] ? htmlspecialchars($_POST['s']) : '';

      $posts_per_page = (int) $_POST['posts_per_page'];
      $paged = (int) $_POST['paged'];

      $response = [
        // 'post' => $_POST,
      ];

      ob_start();

      medvoice_search_list_html( $posts_per_page, $paged, $s );
  
      $response['content'] = ob_get_contents();
  
      ob_clean();
  
      wp_send_json_success( $response );
    } catch (Throwable $th) {
      wp_send_json_error( $th );
    } 

    die();
  }

  function medvoice_search_list_html( $posts_per_page = 3, $paged = 1, $s = '' )
  {
     // Каталог
     $args = [
      'post_type' => 'videos',
      'post_status' => 'publish',
      'order' => 'ASC',
      'orderby' => 'menu_order',
      'posts_per_page' => $posts_per_page,
      'paged' => $paged,
      's' => $s,
    ];

    $query = new WP_Query( $args ); 

    if ( !$query->have_posts() ) {
      $query = medvoice_smart_search( $args, $s );
    }

    if ( $query->have_posts() ) {
      ?>
        <ul class="results__list">
          <?php 
            global $video_id;

            while ( $query->have_posts() ) {
              $query->the_post();
              
              // Данные о видео для карточки
              $video_id = get_the_ID(  );
              
              get_template_part( 'templates/card', 'search' );
            }
          ?> 
        </ul>
  
        <a href="<?= get_home_url(  ) . '?s=' . $s . '&post_type=videos'; ?>" class="results__button button">
          <?= __( 'Смотреть больше', 'medvoice' ); ?>
        </a>
      <?php    

      wp_reset_postdata();
    } else {
      ?>
        <p class="results__empty">
          <?= __( 'По вашему запросу результатов не найдено', 'medvoice' ); ?>
        </p>
      <?php
    } 
  }

  function medvoice_ajax_videos_cards_html()
  {
    try {
      // Первым делом проверяем параметр безопасности
      check_ajax_referer('additional-script.js_nonce', 'security');

      $count = 0;

      $taxonomies = $_POST['taxonomies'] ?? '';
      $sub_tax = $_POST['sub_tax'] ?? '';

      $s = $_POST['s'] ? htmlspecialchars($_POST['s']) : '';

      $posts_per_page = $_POST['posts_per_page'] ? (int) $_POST['posts_per_page'] : 8;
      $paged = $_POST['paged'] ? (int) $_POST['paged'] : 1;

      $bookmarks = $_POST['bookmarks'] ? (int) $_POST['bookmarks'] : 0;

      $results = $_POST['results'] ? (int) $_POST['results'] : 0;

      $response = [
        'post' => $_POST,
      ];

      ob_start();

      $count = medvoice_videos_cards_html( $taxonomies, $posts_per_page, $paged, $s, $bookmarks, $sub_tax );
  
      $response['content'] = ob_get_contents();
  
      ob_clean();

      if ( $results === 1 ) {
        $response['results'] = medvoice_filter_results_text( $count );
      }      
  
      wp_send_json_success( $response );
    } catch (Throwable $th) {
      wp_send_json_error( $th );
    }  

    die();
  }

  function medvoice_filter_results_text( $count = 0 )
  {
    $results = medvoice_pluralize($count, __('результат', 'medvoice'), __('результата', 'medvoice'),
      __('результатов', 'medvoice'));

    return $results;
  }

  /**
   * $taxonomies = '[['slug1' => '1,2,3'], ...]';
   */
  function medvoice_videos_cards_html( $taxonomies = '', $posts_per_page = 8, $paged = 1, $s = '', $bookmarks = 0, $sub_tax = '' ) 
  {
    $count = 0;

    // Каталог
    $args = [
      'post_type' => 'videos',
      'post_status' => 'publish',
      'order' => 'ASC',
      'orderby' => 'menu_order',
      'posts_per_page' => $posts_per_page,
      'paged' => $paged,
    ];

    // Закладки
    if ( $bookmarks === 1 ) {
      $ids = medvoice_get_user_bookmarks();

      $args['post__in'] = $ids;

      if ( empty($ids) ) {
        echo __( 'Вы пока ничего не добавили в закладки', 'medvoice' );

        return;
      }
    }

    // Категории
    if ( $taxonomies !== '' ) {
      $taxonomies = json_decode( stripcslashes($taxonomies), true );
      
      if ( is_array($taxonomies) && !empty($taxonomies) ) {
        if ( $sub_tax !== '' ) {
          $sub_tax = json_decode( stripcslashes($sub_tax), true );
        }

        $args['tax_query'] = [];

        foreach ($taxonomies as $taxonomy => $terms) {
          if ( !empty($sub_tax) && isset($sub_tax[$taxonomy]) ) {
            $terms = $sub_tax[$taxonomy];
          } 

          if ( !empty($terms) ) {
            $args['tax_query'][] = [
              'taxonomy' => $taxonomy,
              'field' => 'term_id',
              'terms' => $terms,
            ];
          } else {
            $args['tax_query'][] = [
              'taxonomy' => $taxonomy,
              'operator' => 'EXISTS',
            ];
          }        
        }
      }      
    }

    // Поиск
    if ( !empty($s) ) {
      $args['s'] = $s;
    }

    $query = new WP_Query( $args ); 

    if ( !$query->have_posts() ) {
      $query = medvoice_smart_search( $args, $s );
    }    

    if ( $query->have_posts() ) {      
      $count = $query->found_posts;

      $max_num_pages = (int) $query->max_num_pages;

      global $video, $place;

      // Тип отображения карточки
      $place = 'list';
      ?>
        <div class="catalog__cards">
          <?php 
            while ( $query->have_posts() ) {
              $query->the_post();
              
              // Данные о видео для карточки
              $video = $query->post;
              
              get_template_part( 'templates/card' );
            }
          ?>  
        </div>
      <?php      
      
      if ( $max_num_pages > 1 ) {
        $attr = [
          'show' => 10,
          'left' => 7,
          'center' => 5,
          'right' => 7,
        ];

        medvoice_get_pagination_html( $max_num_pages, $paged, $attr );
      }   

      wp_reset_postdata();
    } else {
      echo __( 'По вашему запросу результатов не найдено', 'medvoice' );
    } 

    return $count;
  } 
  
  function medvoice_get_pagination_html( $max_num_pages, $paged, $attr ) 
  {
    $show = isset($attr['show']) ? (int) $attr['show'] : 5;
    $left = isset($attr['left']) ? (int) $attr['left'] : 3;
    $center = isset($attr['center']) ? (int) $attr['center'] : 3;
    $right = isset($attr['right']) ? (int) $attr['right'] : 4;
    ?>          
      <div class="pagination">
        <ul class="pagination__list">
          <li class="pagination__item pagination__item--prev">
            <a href="#catalog-ajax" class="pagination__button pagination__button--prev <?= ((int) $paged === 1) ? 'disabled' : ''; ?>"  data-paged="<?= $paged - 1; ?>">
              <svg width="9" height="14">
                <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#pagination-prev"></use>
              </svg>

              <?= __( 'Назад', 'medvoice' ); ?>
            </a>
          </li>

          <!-- Мобильная пагинация - Старт -->
          <li class="pagination__item pagination__item--mobile pagination__item--slash">
            <a href="#catalog-ajax" class="pagination__button">
              <?= $paged; ?>
            </a>
          </li>
          <li class="pagination__item pagination__item--mobile">
            <a href="#catalog-ajax" class="pagination__button">
              <?= $max_num_pages; ?>
            </a>
          </li>
          <!-- Мобильная пагинация - Конец -->

          <?php 
            if ($max_num_pages <= $show) {
              for ($i=1; $i <= $max_num_pages; $i++) { 
                ?>
                  <li class="pagination__item">
                    <a href="#catalog-ajax" class="pagination__button pagination__button--page <?= ((int) $i === 1) ? 'first' : ((int) $i === (int) $max_num_pages ? 'last' : ''); ?> <?= ((int) $i === (int) $paged) ? 'current' : ''; ?>" data-paged="<?= $i; ?>">
                      <?= $i; ?>
                    </a>
                  </li>
                <?php
              }
            } else if ($max_num_pages > $show) {
              if ($paged <= $left) {
                for ($i=1; $i <= $left; $i++) {                  
                  ?>
                    <li class="pagination__item">
                      <a href="#catalog-ajax" class="pagination__button pagination__button--page <?= ((int) $i === 1) ? 'first' : ''; ?> <?= ((int) $i === (int) $paged) ? 'current' : ''; ?>" data-paged="<?= $i; ?>">
                        <?= $i; ?>
                      </a>
                    </li>
                  <?php
                }
                ?>
                  <li class="pagination__item pagination__item--separate">
                    ...
                  </li>
                  <li class="pagination__item">
                    <a href="#catalog-ajax" class="pagination__button pagination__button--page last" data-paged="<?= $max_num_pages; ?>">
                      <?= $max_num_pages; ?>
                    </a>
                  </li>
                <?php
              } else if ($paged > $left && $paged <= ($max_num_pages - $right)) {
                ?>
                  <li class="pagination__item">
                    <a href="#catalog-ajax" class="pagination__button pagination__button--page" data-paged="1">
                      1
                    </a>
                  </li>
                  <li class="pagination__item pagination__item--separate">
                    ...
                  </li>
                <?php
                $center_half = floor($center/2);
                for ($i= ($paged - $center_half); $i <= ($paged + $center_half); $i++) {                  
                  ?>
                    <li class="pagination__item">
                      <a href="#catalog-ajax" class="pagination__button pagination__button--page <?= ((int)$i === (int) $paged) ? 'current' : ''; ?>" data-paged="<?= $i; ?>">
                        <?= $i; ?>
                      </a>
                    </li>
                  <?php
                }
                ?>
                  <li class="pagination__item pagination__item--separate">
                    ...
                  </li>
                  <li class="pagination__item">
                    <a href="#catalog-ajax" class="pagination__button pagination__button--page" data-paged="<?= $max_num_pages; ?>1">
                      <?= $max_num_pages; ?>
                    </a>
                  </li>                    
                <?php
              } else if ($paged > $left && $paged > ($max_num_pages - $right)) {
                ?>
                <li class="pagination__item">
                  <a href="#catalog-ajax" class="pagination__button pagination__button--page" data-paged="1">
                    1
                  </a>
                </li>
                <li class="pagination__item pagination__item--separate">
                  ...
                </li>
                <?php
                for ($i= ($max_num_pages - $right + 1); $i <= $max_num_pages; $i++) {                  
                  ?>
                    <li class="pagination__item">
                      <a href="#catalog-ajax" class="pagination__button pagination__button--page <?= ((int) $i === (int) $max_num_pages) ? 'last' : ''; ?> <?= ((int) $i === (int) $paged) ? 'current' : ''; ?>" data-paged="<?= $i; ?>">
                        <?= $i; ?>
                      </a>
                    </li>
                  <?php
                }
              }                
            }              
          ?>
          
          <li class="pagination__item pagination__item--next">
            <a href="#catalog-ajax" class="pagination__button pagination__button--next <?= ((int) $paged === (int) $max_num_pages) ? 'disabled' : ''; ?>" data-paged="<?= $paged + 1; ?>">
              <?= __( 'Вперёд', 'medvoice' ); ?>  
              <svg width="9" height="14">
                <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#pagination-next"></use>
              </svg>
            </a>
          </li>
        </ul>
      </div>          
    <?php
  }

  function medvoice_search_replace( $s ) 
  {
    $s = strtr($s, [
      'q' => 'й',
      'w' => 'ц',
      'e' => 'у',
      'r' => 'к',
      't' => 'е',
      'y' => 'н',
      'u' => 'г',
      'i' => 'ш',
      'o' => 'щ',
      'p' => 'з',
      '[' => 'х',
      ']' => 'ъ',
      'a' => 'ф',
      's' => 'ы',
      'd' => 'в',
      'f' => 'а',
      'g' => 'п',
      'h' => 'р',
      'j' => 'о',
      'k' => 'л',
      'l' => 'д',
      ';' => 'ж',
      '\'' => 'э',
      'z' => 'я',
      'x' => 'ч',
      'c' => 'с',
      'v' => 'м',
      'b' => 'и',
      'n' => 'т',
      'm' => 'ь',
      ',' => 'б',
      '.' => 'ю',
      '`' => 'ё',
      
      'й' =>  'q',
      'ц' =>  'w',
      'у' =>  'e',
      'к' =>  'r',
      'е' =>  't',
      'н' =>  'y',
      'г' =>  'u',
      'ш' =>  'i',
      'щ' =>  'o',
      'з' =>  'p',
      'х' =>  '[',
      'ъ' =>  ']',
      'ф' =>  'a',
      'ы' =>  's',
      'в' =>  'd',
      'а' =>  'f',
      'п' =>  'g',
      'р' =>  'h',
      'о' =>  'j',
      'л' =>  'k',
      'д' =>  'l',
      'ж' =>  ';',
      'э' => '\'',
      'я' =>  'z',
      'ч' =>  'x',
      'с' =>  'c',
      'м' =>  'v',
      'и' =>  'b',
      'т' =>  'n',
      'ь' =>  'm',
      'б' =>  ',',
      'ю' =>  '.',
      'ё' =>  '`',
    ]);

    return $s; // возвращаем результат
  }

  function medvoice_smart_search( $args, $s, $post_type = 'videos' )
  {
    $s = (string) $s; // преобразуем в строковое значение
    $s = trim($s); // убираем пробелы в начале и конце строки
    
    $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
    
    $args['s'] = medvoice_search_replace( $s );

    $query = new WP_Query( $args ); 

    // Если всё ещё пусто - ищем в названиях терминов таксономий
    if ( !$query->have_posts()  ) {
      $videos_taxs = get_taxonomies( ['object_type' => [$post_type]] ) ?? [];

      if ( $videos_taxs && !empty($videos_taxs) && !is_wp_error( $videos_taxs ) ) {
        $videos_terms = get_terms([ 'taxonomy' => $videos_taxs ]) ?? [];

        if ( $videos_terms && !empty($videos_terms) && !is_wp_error( $videos_terms ) ) {
          $taxonomies = [];

          foreach ($videos_terms as $key => $videos_term) {
            $term_taxonomy = $videos_term->taxonomy;

            $term_id = $videos_term->term_id;

            $term_name = $videos_term->name;
            $term_name = $term_name ? (function_exists('mb_strtolower') ? mb_strtolower($term_name) : strtolower($term_name)) : '';

            if ( str_contains( $term_name, $args['s'] ) || str_contains( $term_name, $s ) ) {
              $taxonomies[$term_taxonomy][] = $term_id;
            }
          }

          if ( !empty($taxonomies) ) {
            $args['s'] = '';

            foreach ($taxonomies as $tax => $terms) {
              $args['tax_query'][] = [
                'taxonomy' => $tax,
                'field' => 'term_id',
                'terms' => $terms,
              ];
            }
          }
          
          $query = new WP_Query( $args );           
        }
      }
    }

    return $query;
  }
?>