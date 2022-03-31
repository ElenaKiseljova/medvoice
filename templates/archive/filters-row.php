<?php 
  $taxonomy_slug = get_row_layout();
  $taxonomy = get_taxonomy( $taxonomy_slug );

  if ( !$taxonomy || !is_a( $taxonomy, 'WP_Taxonomy' ) ) {
    return;
  }

  // Страница Архива формата Видео
  $is_term_page = false;

  $cur_term = get_queried_object();
  if ( isset($cur_term->taxonomy) && $taxonomy_slug === $cur_term->taxonomy ) {
    $is_term_page = true;
  }

  // Получаем данные о таксономии
  $taxonomy_name = $taxonomy->label;

  $terms = get_terms( $taxonomy_slug, [
    'hide_empty' => false,
    'parent' => false,
  ]);
?>
<div class="form__row <?= $is_term_page ? 'hidden' : ''; ?>">
  <div class="dropdown">
    <div class="dropdown__header">
      <span class="dropdown__name"><?= $taxonomy_name; ?></span>
      <svg class="dropdown__icon" width="12" height="8">
        <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
      </svg>
    </div>
    
    <ul class="dropdown__body">
      <?php if ( $terms && !empty($terms) && !is_wp_error( $terms ) ) : ?>
        <?php foreach ($terms as $key => $term) : ?>
          <?php 
            $checked = false;

            $term_id = $term->term_id;

            $term_name = $term->name;

            if ( $cur_term->term_id === $term->term_id ) {
              $checked = true;
            }
            
            $parent = false;
            $term_children = get_term_children( $term_id, $taxonomy_slug );
            if ( !empty($term_children) && !is_wp_error( $term_children ) ) {
              $parent = true;
            }
          ?>
          <li class="dropdown__item">
            <input class="dropdown__check <?= $parent ? 'dropdown__check--parent' : '';?>" <?= $checked ? 'checked' : ''; ?> type="checkbox" 
              id="<?= $taxonomy_slug . '-' . $key; ?>" 
              name="<?= $taxonomy_slug; ?>" 
              value="<?= $term_id; ?>">
            <label class="dropdown__label" for="<?= $taxonomy_slug . '-' . $key; ?>"><?= $term_name; ?></label>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
</div>

<?php if ( $taxonomy_slug === 'sections' ) : ?>
  <div class="form__row">
    <div class="dropdown dropdown--sub-<?= $taxonomy_slug; ?> disabled">
      <div class="dropdown__header">
        <span class="dropdown__name"><?= __( 'Подкатегория', 'medvoice' ); ?></span>
        <svg class="dropdown__icon" width="12" height="8">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
        </svg>
      </div>

      <ul class="dropdown__body">            
      </ul>
    </div>
  </div>
<?php endif; ?>
