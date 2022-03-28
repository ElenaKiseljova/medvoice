<?php 
  global $video_id;

  if ( !isset($video_id) ) {
    return;
  }

  $author_id = get_the_author_ID();

  if ( !isset($author_id) ) {
    return;
  }

  $author_firstname = get_the_author_meta( 'user_firstname', $author_id ) ?? '';
  $author_lastname = get_the_author_meta( 'user_lastname', $author_id ) ?? '';

  $author_name = ( !empty($author_firstname) && !empty($author_lastname) ) ? 
                 ($author_firstname . ' ' . $author_lastname) :
                 get_the_author_meta( 'nickname', $author_id );

  $author_description = get_the_author_meta( 'description', $author_id ) ?? '';

  $author_specialization = get_the_author_meta( 'specialization', $author_id ) ?? '';

  $author_url = get_author_posts_url( $author_id ) ?? '';
?>
<div class="creator">
  <h3 class="creator__title"><?= __( 'Автор', 'medvoice' ); ?></h3>

  <div class="creator__block">
    <div class="creator__avatar">
      <?php if ( medvoice_have_user_avatar( $author_id ) ) : ?>
        <img class="creator__avatar-img" src="<?= medvoice_get_user_avatar(  ); ?>" alt="<?= $author_name; ?>">
      <?php else : ?>
        <img class="creator__avatar-img" src="<?= get_template_directory_uri(  ); ?>/assets/img/avatar-default.svg" alt="<?= $author_name; ?>">
      <?php endif; ?> 
    </div>

    <div class="creator__info">
      <p class="creator__name"><?= $author_name; ?></p>
      <p class="creator__special"><?= medvoice_get_specialization_label( $author_specialization ); ?></p>
    </div>
  </div>

  <p class="creator__description">
    <?= $author_description; ?>
  </p>

  <a class="creator__link" href="<?= $author_url; ?>">
    <?= __( 'Об авторе', 'medvoice' ); ?>
  </a>
</div>