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
        // SVG sufix
        $svg_sufix = $menu_item->classes[0] ?? '';

        // Compare menu object with current page menu object
        $current = ( $menu_item->object_id == get_queried_object_id() ||
                     ($menu_item->url === get_post_type_archive_link( 'videos' ) && is_post_type_archive( 'videos' ))
                    ) ? 'nav__item--active' : '';  
        
        // Проверка пользователя
        $medvoice_user = null;

        if ( is_user_logged_in(  ) ) {
          $medvoice_user = wp_get_current_user(  );
        }
      ?>
      <li class="nav__item <?= $current; ?> <?= (is_null($medvoice_user) && ($svg_sufix === 'profile' || $svg_sufix === 'bookmarks'))  ? 'nav__item--disabled' : ''; ?>">
        <a class="nav__item-link" href="<?= $menu_item->url; ?>">
          <svg aria-labelledby="<?= $menu_item->title; ?>" class="nav__icon" width="20" height="20">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#<?= $svg_sufix; ?>"></use>            
          </svg>  
          <p class="nav__text"><?= $menu_item->title; ?></p>      
        </a>

        <span class="nav__flag"><?= $menu_item->title; ?></span>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>