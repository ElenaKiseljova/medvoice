<?php 
  get_template_part( 'templates/head' );
?>
  <div class="container">
    <?php 
      get_template_part( 'templates/aside' );
    ?> 
    
    <div class="content">
      <header class="header">  
        <?php 
          global $is_nav;

          $is_nav = false;
          
          get_template_part( 'templates/search' );

          get_template_part( 'templates/profile' );
        ?>         
      </header>

  