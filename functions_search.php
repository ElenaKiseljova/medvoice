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
    add_action('wp_ajax_medvoice_ajax_videos_cards_html', 'medvoice_ajax_videos_cards_html');
    add_action('wp_ajax_nopriv_medvoice_ajax_videos_cards_html', 'medvoice_ajax_videos_cards_html'); 

    add_action('wp_ajax_medvoice_ajax_search_list', 'medvoice_ajax_search_list');
    add_action('wp_ajax_nopriv_medvoice_ajax_search_list', 'medvoice_ajax_search_list'); 
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
        'post' => $_POST,
      ];

      ob_start();

      medvoice_search_list_html( $posts_per_page, $paged, $s );
  
      $response['content'] = ob_get_contents();
  
      ob_clean();
  
      wp_send_json_success( $response );
    } catch (Throwable $th) {
      wp_send_json_error( $th );
    } 
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
      echo __( 'По вашему запросу результатов не найдено', 'medvoice' );
    } 
  }

  function medvoice_ajax_videos_cards_html()
  {
    try {
      // Первым делом проверяем параметр безопасности
      check_ajax_referer('additional-script.js_nonce', 'security');

      $taxonomies = $_POST['taxonomies'] ? htmlspecialchars($_POST['taxonomies']) : '';
      $s = $_POST['s'] ? htmlspecialchars($_POST['s']) : '';

      $posts_per_page = (int) $_POST['posts_per_page'];
      $paged = (int) $_POST['paged'];

      $bookmarks = (int) $_POST['bookmarks'];

      $response = [
        'post' => $_POST,
        'bkms' => (int) $_POST['bookmarks']
      ];

      ob_start();

      medvoice_videos_cards_html( $taxonomies, $posts_per_page, $paged, $s, $bookmarks );
  
      $response['content'] = ob_get_contents();
  
      ob_clean();
  
      wp_send_json_success( $response );
    } catch (Throwable $th) {
      wp_send_json_error( $th );
    }  
  }

  /**
   * $taxonomies = '[['slug' => 'slug1', 'terms' => '1,2,3'], ...]';
   */
  function medvoice_videos_cards_html( $taxonomies = '', $posts_per_page = 8, $paged = 1, $s = '', $bookmarks = 0 ) 
  {
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
    }

    

    // Категории
    if ( !empty($taxonomies) ) {
      $taxonomies = json_decode( $taxonomies, true );

      $args['tax_query'] = [];

      foreach ($taxonomies as $key => $taxonomy) {
        if ( !empty($taxonomy['terms']) ) {
          $args['tax_query'][] = [
            'taxonomy' => $taxonomy['slug'],
            'field' => 'term_id',
            'terms' => $taxonomy['terms'],
          ];
        } else {
          $args['tax_query'][] = [
            'taxonomy' => $taxonomy['slug'],
            'operator' => 'EXISTS',
          ];
        }        
      }
    }

    // Поиск
    if ( !empty($s) ) {
      $args['s'] = $s;
    }

    $query = new WP_Query( $args ); 

    if ( $query->have_posts() ) {
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
  }  
?>