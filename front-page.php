<?php 
  /**
   * Template Name: Главная
   */
?>

<?php 
  get_header(  );
?>

<?php 
  //sections, authors, labels
  $terms = get_terms( array(
    'taxonomy' => ['sections', 'authors', 'labels'],
    'hide_empty' => false,
  ) );

  // var_dump($terms);
  $langs = pll_languages_list( ['hide_empty' => false]);

  foreach ($terms as $key => $term) {
    $translates = pll_get_term_translations($term->term_id);
    $translates_keys = array_keys($translates);

    var_dump($translates);
    echo '<br><br><br><br>';

    if (count($translates_keys) < count($langs)) {
      echo $term->name;

      foreach ($langs as $key => $lang) {
        if (array_search($lang, $translates_keys) === false) {
          
          $term_insert = wp_insert_term( $term->name . '-' . $lang, $term->taxonomy );
        
          if ( !is_wp_error($term_insert) ) {
            $new_term_id = $term_insert['term_id'];

            pll_set_term_language($new_term_id, $lang);

            $translates_new = [$lang => $new_term_id ];

            $translates = array_merge($translates, $translates_new);
          }
        }  
      }

      pll_save_term_translations($translates);
    }
  }
?>


<main class="main"> 
  <?php 
    // Check value exists.
    if( have_rows('content') ):

      // Loop through rows.
      while ( have_rows('content') ) : the_row();

          // Case: Banner layout.
          if( get_row_layout() == 'banner' ):
              get_template_part( 'templates/front/banner' );
          
          // Case: Slider layout.
          elseif( get_row_layout() == 'slider' ):
            get_template_part( 'templates/front/slider' );   
                    
          endif;

      // End loop.
      endwhile;

    // No value.
    else :
      // Do something...
    endif;
  ?>  
</main>

<?php 
  get_footer(  );
?>