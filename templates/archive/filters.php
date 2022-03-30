<div class="catalog__filter">
  <form class="form form--filter" action="">
    <div class="form__row">
      <input type="search" class="dropdown__field" name="s" placeholder="<?= __( 'Поиск...', 'medvoice' ); ?>">
    </div>

    <?php 
      // Check value exists.
      if( have_rows('filters', 'options') ):

        // Loop through rows.
        while ( have_rows('filters', 'options') ) : the_row();

            // Case: Категории layout.
            if( get_row_layout() == 'sections' ):
              get_template_part( 'templates/archive/filters', 'row' );
            
            // Case: Формат layout.
            elseif( get_row_layout() == 'format' ):
              get_template_part( 'templates/archive/filters', 'row' );
            
            // Case: Автор layout.
            elseif( get_row_layout() == 'authors' ):
              get_template_part( 'templates/archive/filters', 'row' );

            // Case: Теги проблематики layout.
            elseif( get_row_layout() == 'labels' ):
              get_template_part( 'templates/archive/filters', 'row' );

            // Case: Язык layout.
            elseif( get_row_layout() == 'langs' ):
              get_template_part( 'templates/archive/filters', 'row' );
                      
            endif;

        // End loop.
        endwhile;

      // No value.
      else :
        // Do something...
      endif;
    ?> 

    <div class="form__button-box form__button-box--filter">
      <button class="button button--reset">
        <?= __( 'Сбросить', 'medvoice' ); ?>
      </button>
      <button class="button button--apply">
        <?= __( 'Применить', 'medvoice' ); ?>
      </button>
    </div>
  </form>
</div>