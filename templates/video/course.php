<section class="course">
  <div class="course__tab course__tab--active">
    <div class="catalog">
      <div class="catalog__head">
        <div class="catalog__icon-box">
          <svg class="catalog__icon-row" width="25" height="20">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#row"></use>
          </svg>

          <svg class="catalog__icon-grid" width="20" height="20">
              <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#grid"></use>
          </svg>
        </div>
      </div>

      <?php 
        get_template_part( 'templates/video/cards' );
      ?>
    </div>
  </div>

  <div class="course__tab">
    <div class="course__about">
      <div class="course__info">
        <?php 
          get_template_part( 'templates/video/labels' );
        ?>

        <div class="course__text">
          <?= get_the_content(  ); ?>
        </div>
      </div>

      <?php 
        get_template_part( 'templates/video/author' );
      ?>
    </div>
  </div>
</section>