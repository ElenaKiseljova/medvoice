<button class="button button--filter">
  <?= __( 'Фильтры', 'medvoice' ); ?>
  <svg width="7" height="12">
    <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#filter-arrow"></use>
  </svg>
</button>

<div class="catalog__amount hidden">
  <span class="catalog__results"></span>
 
  <button class="catalog__x">
    <svg class="catalog__x-icon" width="14" height="14">
      <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#x-icon"></use>
    </svg>
  </button>  
</div>