<?php 
  $title = '';
  $content = '';
  $class = '';

  $gradient = [];

  $term = get_queried_object();
  if ( isset($term->taxonomy) && is_tax( 'format' ) ) {
    $title = $term->name;
    $content = term_description();

    $class = 'banner--courses';

    $gradient = get_field( 'gradient', $term );
  } else {
    $catalog_page_id = medvoice_get_special_page( 'catalog', 'id' ) ?? null;

    $title = get_the_title( $catalog_page_id );
    $content = get_the_content( null, false, $catalog_page_id );

    $class = 'banner--catalog';

    $gradient = get_field( 'gradient' );
  }
?>
<section class="banner <?= $class; ?>" id="banner" <?= !empty($gradient) ? 'style="background: linear-gradient(95.01deg,' . $gradient['start'] . ' 0,' . $gradient['center'] . ' 48.37%,' . $gradient['end'] . ' 100%);"' : ''; ?>>
  <h1 class="banner__title">
    <?= $title; ?>
  </h1>
  <div class="banner__description">
    <?= $content; ?>
  </div>
</section>