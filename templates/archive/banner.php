<?php 
  $title = '';
  $content = '';

  $term = get_queried_object();
  if ( isset($term->taxonomy) && is_tax( 'format' ) ) {
    $title = $term->name;
    $content = term_description();
  } else {
    $catalog_page_id = medvoice_get_special_page( 'catalog', 'id' ) ?? null;

    $title = get_the_title( $catalog_page_id );
    $content = get_the_content( null, false, $catalog_page_id );
  }
?>
<section class="banner banner--catalog" id="banner">
  <h1 class="banner__title">
    <?= $title; ?>
  </h1>
  <div class="banner__description">
    <?= $content; ?>
  </div>
</section>