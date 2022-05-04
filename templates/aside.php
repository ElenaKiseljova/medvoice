<aside class="nav">      
  <div class="nav__head">
    <?php medvoice_get_logo_html( 'nav' ); ?>

    <button class="nav__burger">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>
  
  <div class="header header--nav">
    <?php 
      global $is_nav;

      $is_nav = true;
    
      get_template_part( 'templates/search' );

      get_template_part( 'templates/profile' );
    ?>
  </div>

  <button class="nav__btn">
    <svg class="nav__btn-arrow" width="6" height="10">
      <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#nav-arrow"></use>
    </svg>
  </button>

  <nav class="nav__wrapper">
    <?php 
      get_template_part( 'templates/menu', 'main' );

      get_template_part( 'templates/languages' );
    ?>        
  </nav>     

  <div class="social__wrapper">
    <?php if ( function_exists( 'wc_privacy_policy_page_id' ) ) : ?>
      <a class="social__policy" href="<?= get_permalink( wc_privacy_policy_page_id() ); ?>"><?= get_the_title( wc_privacy_policy_page_id() ); ?></a>
    <?php endif; ?>        
    
    <?php 
      get_template_part( 'templates/menu', 'social' );

      get_template_part( 'templates/contact' );
    ?>
  </div>
</aside>