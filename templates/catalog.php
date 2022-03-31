<?php 
  $posts_per_page = get_query_var( 'posts_per_page' ) ? (int) get_query_var( 'posts_per_page' ) : 10;

  // Поиск
  $is_search_page = is_search(  );

  $search_query = '';
  $posts_found = 0;
  if ( $is_search_page ) {
    global $wp_query;
 
    $posts_found = $wp_query->found_posts ?? 0;
    $search_query = get_search_query(  );
  }  

  // Каталог
  $is_archive_videos = is_post_type_archive( 'videos' );

  // Вебинары/Курсы/Лекции и т.д.
  $term = get_queried_object();
  $is_taxonomy_format_archive = isset($term->taxonomy) && $term->taxonomy === 'format';

  $taxonomies = '';
  if ( $is_taxonomy_format_archive ) {
    $taxonomies = [
      $term->taxonomy => $term->term_id,
    ];

    $taxonomies = json_encode( $taxonomies );
  }

  // Закладки
  $is_bookmarks_page = is_page( medvoice_get_special_page( 'bookmarks', 'id' ) );

  // Контроль тега, чтобы всё красиво в разметке было
  $tag_html = 'div';
  if ( $is_taxonomy_format_archive || $is_archive_videos || $is_search_page || $is_bookmarks_page ) {
    $tag_html = 'section';
  }
?>

<<?= $tag_html; ?> class="catalog" id="catalog">
  <?php if ( $is_taxonomy_format_archive || $is_archive_videos || $is_search_page || $is_bookmarks_page ) : ?>
    <script>
      // Глобальные переменные для фильтров и пагинации
      window.postPerpage = <?= $posts_per_page; ?>;
      window.taxonomies = '<?= $taxonomies; ?>';
      window.s = '<?= $search_query; ?>';
      window.bookmarks = <?= $is_bookmarks_page ? 1 : 0; ?>;
    </script>
  <?php endif; ?>

  <div class="catalog__head <?= ($is_search_page || $is_bookmarks_page) ? 'catalog__head--search' : ''; ?>">
    <?php if ( $is_search_page ) : ?>
      <h1 class="catalog__title">
        <?= 
          sprintf( __( 'Результаты поиска «%s»', 'medvoice' ), $search_query );
        ?>        
      </h1>

      <h3 class="catalog__link">
        <?= 
          sprintf( __( '%s совпадений', 'medvoice' ), $posts_found );
        ?> 
      </h3>
    <?php elseif ( $is_bookmarks_page ) : ?>
      <h1 class="catalog__title">
        <?= 
          get_the_title(  );
        ?>        
      </h1>
    <?php else : ?>
      <?php 
        if ( $is_taxonomy_format_archive || $is_archive_videos ) {
          get_template_part( 'templates/archive/filters', 'head' );
        }
      ?>
      <div class="catalog__icon-box">
        <svg class="catalog__icon-row" width="25" height="20">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#row"></use>
        </svg>

        <svg class="catalog__icon-grid active" width="20" height="20">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#grid"></use>
        </svg>
      </div>
    <?php endif; ?>
  </div>
  
  <?php if ( $is_taxonomy_format_archive || $is_archive_videos || $is_search_page || $is_bookmarks_page ) : ?>
    <div class="catalog__wrapper">
      <?php 
        if ( ($is_taxonomy_format_archive || $is_archive_videos) && !$is_search_page ) {
          get_template_part( 'templates/archive/filters' ); 
        }
      ?>

      <div class="catalog__results" id="catalog-ajax">
        <?php 
          if ( $is_taxonomy_format_archive && !$is_search_page ) {
            medvoice_videos_cards_html( $taxonomies, $posts_per_page );
          } else if ( $is_archive_videos && !$is_search_page ) {
            medvoice_videos_cards_html( '', $posts_per_page );
          } else if ( $is_search_page ) {
            medvoice_videos_cards_html( '', $posts_per_page, 1, $search_query );
          } else if ( $is_bookmarks_page ) {
            medvoice_videos_cards_html( '', $posts_per_page, 1, '', 1 );
          }
        ?> 
      </div>
    </div>
  <?php else : ?>
    <?php 
      get_template_part( 'templates/cards' ); 
    ?>
  <?php endif; ?>   
</<?= $tag_html; ?>>