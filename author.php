<?php 
  get_header(  );
?>

<?php 
  global $video_arr;

  $author = get_queried_object();

  if ( $author instanceof WP_User ) {
    $author_id = $author->ID;

    $args = [
      'author' => $author_id,
      'post_type' => 'videos',
      'numberposts' => -1,
    ];
  
    $video_arr = get_posts( $args );
  } else {
    return;
  } 
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