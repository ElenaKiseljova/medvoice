<div class="catalog">
  <div class="catalog__head">
    <div class="catalog__icon-box">
      <svg class="catalog__icon-row" width="25" height="20">
        <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#row"></use>
      </svg>

      <svg class="catalog__icon-grid active" width="20" height="20">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#grid"></use>
      </svg>
    </div>
  </div>

  <?php 
    get_template_part( 'templates/cards' );
  ?>
</div>