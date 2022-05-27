<?php 
  // Инициализация ф-й
  //$terms_names = ['sections', 'authors', 'labels']
  function custom_poly_lang_set_translation_terms( $terms_names = [] )
  {
    if ( !empty($terms_names) ) {      
      $terms = get_terms( array(
        'taxonomy' => $terms_names,//sections, authors, labels
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
    }
  }

  function custom_poly_lang_set_translation_terms_group( $terms_names = [] )
  {
    if ( !empty($terms_names) ) {      
      $terms = get_terms( array(
        'taxonomy' => $terms_names,//sections, authors, labels
        'hide_empty' => false,
      ) );

      // var_dump($terms);
      $langs = pll_languages_list( ['hide_empty' => false]);

      foreach ($terms as $key => $term) {
        $translates = pll_get_term_translations($term->term_id);
        
        if ( $translates && is_array($translates) && !is_wp_error($translates) ) {
          $string = $term->term_id . '_' . time();
          $translation_terms_group = 'pl_t_' . wp_hash( $string );

          foreach ($translates as $key => $translate) { 
            if ( get_term_meta( $translate, 'translation_terms_group' ) === false || get_term_meta( $translate, 'translation_terms_group' ) === []) {
              update_term_meta( $translate, 'translation_terms_group', $translation_terms_group );
            } 
            // update_term_meta( $translate, 'translation_terms_group', $translation_terms_group ); 

            // var_dump(get_term_meta( $translate, 'translation_terms_group' ));
          }           

          // echo '<br><br>';
        }          
      }
    }
  }
  
  // Вызов
  // custom_poly_lang_set_translation_terms_group( ['sections'] );
  // custom_poly_lang_set_translation_terms('authors');
?>