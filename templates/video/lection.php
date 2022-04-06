<?php 
  global $video_id;

  $video_id = get_the_ID(  );
?>
<section class="lection">
  <div class="lection__head">
    <?php 
      get_template_part( 'templates/video/breadcrumb' );
    ?>

    <?php 
      get_template_part( 'templates/bookmarks' );
    ?>
  </div>

  <h1 class="lection__title">
    <?= get_the_title(  ); ?>
  </h1>

  <?php
    get_template_part( 'templates/video/vimeo' );

    get_template_part( 'templates/video/tags' );
  ?>

  <div class="lection__description">
    <p class="lection__description-text">
      <?= __( 'Описание', 'medvoice' ); ?>
    </p>
  </div>

  <div class="lection__info">
    <div class="lection__content">
      <?= get_the_content(  ); ?>
    </div>

    <?php 
      get_template_part( 'templates/video/author' );
    ?>
  </div>
</section>