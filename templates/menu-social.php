<?php
  $menu_name = 'social';
  $locations = get_nav_menu_locations();
  
  if( $locations && isset( $locations[ $menu_name ] ) ){
  
    // получаем элементы меню
    $menu_items = wp_get_nav_menu_items( $locations[ $menu_name ] );
  }
?>

<?php if ($menu_items && !empty($menu_items) && !is_wp_error( $menu_items )) : ?>
  <ul class="social__list">
    <?php foreach ( (array) $menu_items as $key => $menu_item ) : ?>
      <li class="social__link">
        <a class="social__icon-box" href="<?= $menu_item->url; ?>">
          <svg aria-labelledby="<?= $menu_item->title; ?>" class="social__icon" width="24" height="24">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#<?= mb_strtolower($menu_item->title); ?>"></use>            
          </svg>        
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>