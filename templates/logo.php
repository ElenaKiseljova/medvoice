<?php 
  $logo_large = get_theme_mod( 'logo_large' ) ?? '';
  $logo_narrow = get_theme_mod( 'logo_narrow' ) ?? '';
?>
<a href="<?= get_bloginfo( 'url' ); ?>" class="logo logo--nav">
  <img class="logo__img" src="<?= $logo_large; ?>" alt="<?= get_bloginfo( 'name' ); ?>">
  <img class="logo__img--short hidden" src="<?= $logo_narrow; ?>" alt="<?= get_bloginfo( 'name' ); ?>">
</a>