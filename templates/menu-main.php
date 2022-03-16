<?php
  $menu_name = 'main';
  $locations = get_nav_menu_locations();
  
  if( $locations && isset( $locations[ $menu_name ] ) ){
  
    // получаем элементы меню
    $menu_items = wp_get_nav_menu_items( $locations[ $menu_name ] );
  }
?>

<?php if ($menu_items && !empty($menu_items) && !is_wp_error( $menu_items )) : ?>  
  <ul class="nav__list">
    <?php foreach ( (array) $menu_items as $key => $menu_item ) : ?>
      <?php 
        // Compare menu object with current page menu object
        $current = ( $menu_item->object_id == get_queried_object_id() ) ? 'nav__item--active' : '';  
        
        // SVG sufix
        $svg_sufix = $menu_item->classes[0] ?? '';

        // Проверка пользователя
        $medvoice_user = null;

        if ( is_user_logged_in(  ) ) {
          $medvoice_user = wp_get_current_user(  );
        }
      ?>
      <li class="nav__item <?= $current; ?> <?= (is_null($medvoice_user) && ($svg_sufix === 'profile' || $svg_sufix === 'bookmarks'))  ? 'nav__item--disabled' : ''; ?>">
        <a class="nav__item-link" href="<?= $menu_item->url; ?><?= (isset($medvoice_user) && ($svg_sufix === 'profile' || $svg_sufix === 'bookmarks'))  ? ('?user=' . $medvoice_user->ID) : ''; ?>">
          <svg aria-labelledby="<?= $menu_item->title; ?>" class="nav__icon" width="24" height="24">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#<?= $svg_sufix; ?>"></use>            
          </svg>  
          <p class="nav__text"><?= $menu_item->title; ?></p>      
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>