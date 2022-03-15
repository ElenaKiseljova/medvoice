<?php 
  /* ==============================================
  ********  //Переопределяю шаблон формы поиска
  =============================================== */
  add_filter('get_search_form', 'medvoice_search_form');

  function medvoice_search_form( $form ) {
    $form = '
        <form class="header__form" action="' . home_url( '/' ) . '" method="get" role="search">
          <input class="header__search" autocomplete="off" type="text" 
            name="s" 
            value="' . get_search_query() . '" 
            id="s" 
            placeholder="' . __( 'Поиск...', 'medvoice' ) . '"            
          />          

          <input type="hidden" name="post_type" value="post" />
        </form>';

    return $form;
  }
?>