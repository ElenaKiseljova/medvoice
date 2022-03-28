<section class="lection">
  <div class="lection__head">
    <?php 
      get_template_part( 'templates/video/breadcrumb' );
    ?>

    <button class="bookmarks">
      <svg width="16" height="20">
        <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#bookmark-2"></use>
      </svg>
    </button>
  </div>

  <h1 class="lection__title">
    <?= get_the_title(  ); ?>
  </h1>

  <div class="lection__video">
    <div class="lection__img">
        <img src="<?= get_template_directory_uri(  ); ?>/assets/img/card-1.jpg" alt="hospital">
    </div>
    <div class="lection__btn">
        <svg width="33" height="40">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#play"></use>
        </svg>
    </div>
  </div>

  <?php 
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