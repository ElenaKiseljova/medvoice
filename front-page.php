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
  $medvoice_user = wp_get_current_user(  );

  // update_metadata( 'user', $medvoice_user->ID, 'bookmarks', '[]' );
  // update_user_meta($medvoice_user->ID, '_new_user', '1');
  // update_user_meta($medvoice_user->ID, 'st', time());
  // delete_metadata( 'user', $medvoice_user->ID, 'subscribed_days' );
  // var_dump( get_user_meta( $medvoice_user->ID ) );
  
  //echo wp_get_session_token();

  // if ( class_exists('WP_Session_Tokens') ) {
  //   $manager = WP_Session_Tokens::get_instance( get_current_user_id() );

  //   var_dump($manager);
  // }
  

  // echo '<br><br>';


  // $wp_sessions = wp_get_all_sessions() ?? [];

  //   foreach ($wp_sessions as $key => $wp_session) {
  //     var_dump($wp_session);
  //     echo '<br><br>';
      
  //     // echo date('Y-m-d H:i:s', utc_to_usertime($wp_session['expiration'])) . '<br>';
  //   }

    // echo medvoice_get_user_subscribe_end_date();
  ?>
  
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