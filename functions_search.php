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
            id="s" 
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

      $reset = $_POST['reset'] ? (int) $_POST['reset'] : 0;

      $response = [
        'post' => $_POST,
      ];

      ob_start();

      $count = medvoice_videos_cards_html( $taxonomies, $posts_per_page, $paged, $s, $bookmarks, $sub_tax );
  
      $response['content'] = ob_get_contents();
  
      ob_clean();

      if ( $reset === 0 ) {
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

    // print_r( ['bookmarks' => $bookmarks, 'ids' => $ids] );
    // return;

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
        ?>
          <div class="pagination">
            <ul class="pagination__list">
              <li class="pagination__item pagination__item--prev">
                <a href="#catalog-ajax" class="pagination__button pagination__button--prev <?= ($paged === 1) ? 'disabled' : ''; ?>"  data-paged="<?= $paged - 1; ?>">
                  <svg width="9" height="14">
                    <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#pagination-prev"></use>
                  </svg>

                  <?= __( 'Назад', 'medvoice' ); ?>
                </a>
              </li>

              <?php 
                if ($max_num_pages <= 5) {
                  for ($i=1; $i <= $max_num_pages; $i++) { 
                    ?>
                      <li class="pagination__item">
                        <a href="#catalog-ajax" class="pagination__button pagination__button--page <?= ($i === 1) ? 'first' : ($i === $max_num_pages ? 'last' : ''); ?> <?= ($i === $paged) ? 'current' : ''; ?>" data-paged="<?= $i; ?>">
                          <?= $i; ?>
                        </a>
                      </li>
                    <?php
                  }
                } else if ($max_num_pages > 5) {
                  if ($paged <= 4) {
                    for ($i=1; $i <= 4; $i++) {                  
                      ?>
                        <li class="pagination__item">
                          <a href="#catalog-ajax" class="pagination__button pagination__button--page <?= ($i === 1) ? 'first' : ''; ?> <?= ($i === $paged) ? 'current' : ''; ?>" data-paged="<?= $i; ?>">
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
                  } else if ($paged > 4 && $paged < ($max_num_pages - 3)) {
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
                    for ($i= ($paged - 1); $i <= ($paged + 1); $i++) {                  
                      ?>
                        <li class="pagination__item">
                          <a href="#catalog-ajax" class="pagination__button pagination__button--page <?= ($i === $paged) ? 'current' : ''; ?>" data-paged="<?= $i; ?>">
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
                  } else if ($paged > 4 && $paged >= ($max_num_pages - 3)) {
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
                    for ($i= ($max_num_pages - 3); $i <= $max_num_pages; $i++) {                  
                      ?>
                        <li class="pagination__item">
                          <a href="#catalog-ajax" class="pagination__button pagination__button--page <?= ($i === $max_num_pages) ? 'last' : ''; ?> <?= ($i === $paged) ? 'current' : ''; ?>" data-paged="<?= $i; ?>">
                            <?= $i; ?>
                          </a>
                        </li>
                      <?php
                    }
                  }                
                }              
              ?>
              
              <li class="pagination__item pagination__item--next">
                <a href="#catalog-ajax" class="pagination__button pagination__button--next <?= ($paged === $max_num_pages) ? 'disabled' : ''; ?>" data-paged="<?= $paged + 1; ?>">
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

      wp_reset_postdata();
    } else {
      echo __( 'По вашему запросу результатов не найдено', 'medvoice' );
    } 

    return $count;
  }  
?>