<aside class="nav">      
  <?php medvoice_get_logo_html( 'nav' ); ?>

  <button class="nav__btn">
    <svg class="nav__btn-arrow" width="6" height="10" viewBox="0 0 6 10" xmlns="http://www.w3.org/2000/svg">
      <path d="M5.79191 9.80328C5.65318 9.93443 5.47977 10 5.28902 10C5.11561 10 4.92486 9.93443 4.78613 9.80328L0.208092 5.47541C0.0693641 5.34426 4.76837e-07 5.18033 4.76837e-07 5C4.76837e-07 4.81967 0.0693641 4.65574 0.208092 4.52459L4.78613 0.196721C5.06358 -0.0655738 5.51445 -0.0655738 5.79191 0.196721C6.06936 0.459016 6.06936 0.885246 5.79191 1.14754L1.71676 5L5.79191 8.85246C6.06936 9.11475 6.06936 9.54098 5.79191 9.80328Z"/>
    </svg>                    
  </button>

  <nav class="nav__wrapper">
    <?php 
      get_template_part( 'templates/menu', 'main' );
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
    
  <?php if ( function_exists( 'pll_the_languages' ) ) : ?>
    <ul style="margin-top: 40px;"><?php pll_the_languages( [ 'show_names' => 0, 'show_flags' => 1 ]);?></ul>
  <?php endif; ?>      
</aside>