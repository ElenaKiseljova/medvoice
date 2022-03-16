<?php 
  $logo_large = get_theme_mod( 'logo_large' ) ?? '';
?>
<a href="<?= get_bloginfo( 'url' ); ?>" class="logo logo--user">
  <img class="logo__img" src="<?= $logo_large; ?>" alt="<?= get_bloginfo( 'name' ); ?>">
</a>