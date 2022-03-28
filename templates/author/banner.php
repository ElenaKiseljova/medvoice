<?php 
  $author = get_queried_object();

  $author_id = $author->ID;

  $author_firstname = get_the_author_meta( 'user_firstname', $author_id ) ?? '';
  $author_lastname = get_the_author_meta( 'user_lastname', $author_id ) ?? '';

  $author_name = ( !empty($author_firstname) && !empty($author_lastname) ) ? 
              ($author_firstname . ' ' . $author_lastname) :
              get_the_author_meta( 'nickname', $author_id );

  $author_specialization = get_the_author_meta( 'specialization', $author_id ) ?? '';
?>
<section class="banner banner--author" id="banner">
  <div class="banner__info">
    <div class="banner__avatar">
      <?php if ( medvoice_have_user_avatar( $author_id ) ) : ?>
        <img class="banner__avatar-img" src="<?= medvoice_get_user_avatar(  ); ?>" alt="<?= $author_name; ?>">
      <?php else : ?>
        <img class="banner__avatar-img" src="<?= get_template_directory_uri(  ); ?>/assets/img/avatar-default.svg" alt="<?= $author_name; ?>">
      <?php endif; ?> 
    </div>

    <div class="banner__text">
      <h1 class="banner__user"><?= $author_name; ?></h1>
      <p class="banner__special"><?= medvoice_get_specialization_label( $author_specialization ); ?></p>
    </div>
  </div>

  <ul class="banner__list">
    <li class="banner__item active"><?= __( 'Об авторе', 'medvoice' ); ?></li>
    <li class="banner__item"><?= __( 'Список лекций', 'medvoice' ); ?></li>
  </ul>
</section>