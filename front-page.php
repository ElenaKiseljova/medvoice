<?php 
  /**
   * Template Name: Главная
   */
?>

<?php 
  get_header(  );
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