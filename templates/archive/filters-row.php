<?php 
  $taxonomy_slug = get_row_layout();
  $taxonomy = get_taxonomy( $taxonomy_slug );

  if ( !$taxonomy || !is_a( $taxonomy, 'WP_Taxonomy' ) ) {
    return;
  }

  $taxonomy_name = $taxonomy->label;

  $terms = get_terms( $taxonomy_slug, [
    'hide_empty' => false,
    'parent' => false,
  ]);

  $sub_terms_ids = [];
?>
<div class="form__row">
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
            
            $term_children = get_term_children( $term_id, $taxonomy_slug );
            if ( empty($sub_terms_ids) && !empty($term_children) && !is_wp_error( $term_children ) ) {
              $sub_terms_ids = $term_children;

              $checked = true;
            }
          ?>
          <li class="dropdown__item">
            <input class="dropdown__check" <?= $checked ? 'checked' : ''; ?> type="checkbox" 
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
    <div class="dropdown">
      <div class="dropdown__header">
        <span class="dropdown__name"><?= __( 'Подкатегория', 'medvoice' ); ?></span>
        <svg class="dropdown__icon" width="12" height="8">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#select-arrow"></use>
        </svg>
      </div>

      <ul class="dropdown__body">
        <?php foreach ($sub_terms_ids as $key => $sub_terms_id) : ?>
          <?php           
            $term = get_term_by( 'id', $sub_terms_id, $taxonomy_slug );
            
            if ( !is_a( $term, 'WP_Term') ) {
              continue;
            }

            $term_name = $term->name;
          ?>
          <li class="dropdown__item">
            <input class="dropdown__check" type="checkbox" 
              id="<?= $taxonomy_slug . '-' . $key; ?>" 
              name="<?= $taxonomy_slug; ?>"
              value="<?= $sub_terms_id; ?>">
            <label class="dropdown__label" for="<?= $taxonomy_slug . '-' . $key; ?>"><?= $term_name; ?></label>
          </li>
        <?php endforeach; ?>        
      </ul>
    </div>
  </div>
<?php endif; ?>
