<?php 
  get_header(  );
?>

<?php 
  global $video_arr, $author;

  $author = get_queried_object();
  
  if ( $author instanceof WP_Term ) {
    # code...
  } else {
    return;
  }

  $author_id = $author->term_id ?? null;

  if ( !isset($author_id) ) {
    return;
  }

  $args = [
    'post_type' => 'videos',
    'numberposts' => -1,
    'tax_query' => [
      [
        'taxonomy' => $author->taxonomy,
        'field'    => 'id',
        'terms'    => $author_id
    ]
    ]
  ];

  $video_arr = get_posts( $args );
?>

<main class="main">
  <?php 
    get_template_part( 'templates/author/banner' );
  ?>

  <section class="author">
    <div class="author__tab author__tab--active">
      <?php 
        get_template_part( 'templates/author/content' );
      ?>
    </div>

    <div class="author__tab">
      <?php 
        get_template_part( 'templates/catalog' );
      ?>
    </div>
  </section>
</main>

<?php 
  get_footer(  );
?>