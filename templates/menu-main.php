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
                     (isset($_GET['type']) && $_GET['type'] === $svg_sufix)
                    ) ? 'nav__item--active' : '';  
        
        // Проверка пользователя
        $medvoice_user = null;

        if ( is_user_logged_in(  ) ) {
          $medvoice_user = wp_get_current_user(  );
        }
      ?>
      <li class="nav__item <?= $current; ?> <?= (is_null($medvoice_user) && ($svg_sufix === 'profile' || $svg_sufix === 'bookmarks'))  ? 'nav__item--disabled' : ''; ?>">
        <a class="nav__item-link" href="<?= $menu_item->url; ?>">
          <svg aria-labelledby="<?= $menu_item->title; ?>" class="nav__icon" width="24" height="24">
            <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#<?= $svg_sufix; ?>"></use>            
          </svg>  
          <p class="nav__text"><?= $menu_item->title; ?></p>      
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php 
// $current = ( $menu_item->object_id == get_queried_object_id() ) ? 'nav__item--active' : ''; 
$menu_main = [
  'main' => [
    'label' => __( 'Главная', 'medvoice' ),
    'url' => home_url(  ),
    'private' => false,
    'current' => false,
  ],
  'courses' => [
    'label' => __( 'Курсы', 'medvoice' ),
    'url' => get_post_type_archive_link( 'courses' ),
    'private' => false,
    'current' => false,
  ],  
  'webinars' => [
    'label' => __( 'Вебинары', 'medvoice' ),
    'url' => get_post_type_archive_link( 'webinars' ),
    'private' => false,
    'current' => false,
  ],
  'catalog' => [
    'label' => __( 'Каталог', 'medvoice' ),
    'url' => medvoice_get_special_page( 'catalog', 'url' ),
    'private' => false,
    'current' => false,
  ],
  'profile' => [
    'label' => __( 'Профиль', 'medvoice' ),
    'url' => medvoice_get_special_page( 'profile', 'url' ),
    'private' => true,
    'current' => false,
  ],
  'bookmarks' => [
    'label' => __( 'Закладки', 'medvoice' ),
    'url' => medvoice_get_special_page( 'bookmarks', 'url' ),
    'private' => true,
    'current' => false,
  ],
]; 
?>
<!-- <ul class="nav__list">
  <?php foreach ($menu_main as $key => $menu_item) : ?>
    <li class="nav__item <?= $menu_item['current'] ? 'nav__item--active' : ''; ?> <?= ($menu_item['private'] && !is_user_logged_in(  )) ? 'nav__item--disabled' : ''; ?>">
      <a class="nav__item-link" href="<?= $menu_item['url']; ?>">
        <svg aria-labelledby="<?= $menu_item['label']; ?>" class="nav__icon" width="24" height="24">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#<?= $key; ?>"></use>            
        </svg>  
        <p class="nav__text"><?= $menu_item['label']; ?></p>      
      </a>
    </li>
  <?php endforeach; ?>  
</ul> -->