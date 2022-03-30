<?php 
  global $author;

  if ( $author instanceof WP_Term ) {
    # code...
  } else {
    return;
  }

  $author_name = $author->name;  

  $author_avatar = get_field( 'avatar', $author );
  $author_specialization = get_field( 'specialization', $author );
?>
<section class="banner banner--author" id="banner">
  <div class="banner__info">
    <div class="banner__avatar">
      <?php if ( $author_avatar ) : ?>
        <img class="banner__avatar-img" src="<?= $author_avatar; ?>" alt="<?= $author_name; ?>">
      <?php else : ?>
        <img class="banner__avatar-img" src="<?= get_template_directory_uri(  ); ?>/assets/img/avatar-default.svg" alt="<?= $author_name; ?>">
      <?php endif; ?> 
    </div>

    <div class="banner__text">
      <h1 class="banner__user"><?= $author_name; ?></h1>
      <p class="banner__special"><?= $author_specialization; ?></p>
    </div>
  </div>

  <ul class="banner__list">
    <li class="banner__item active"><?= __( 'Об авторе', 'medvoice' ); ?></li>
    <li class="banner__item"><?= __( 'Список лекций', 'medvoice' ); ?></li>
  </ul>
</section>