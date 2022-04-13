<?php 
  global $video_id;
  
  $video_id = get_the_ID(  );

  if ( !isset($video_id) ) {
    return;
  }

  $authors = wp_get_post_terms( $video_id, 'authors' ) ?? [];

  if ( empty($authors) ) {
    return;
  }

  $author = $authors[0];

  if ( !is_a( $author, 'WP_Term' ) ) {
    return;
  }

  $author_name = $author->name;
  $author_url = get_term_link( $author );
  
  $author_short_description = get_field( 'short_description', $author );
  $author_avatar = get_field( 'avatar', $author );
  $author_specialization = get_field( 'specialization', $author );
?>
<div class="creator">
  <h3 class="creator__title"><?= __( 'Автор', 'medvoice' ); ?></h3>

  <div class="creator__block">
    <div class="creator__avatar">
      <?php if ( $author_avatar ) : ?>
        <img class="creator__avatar-img" src="<?= $author_avatar; ?>" alt="<?= $author_name; ?>">
      <?php else : ?>
        <img class="creator__avatar-img" src="<?= get_template_directory_uri(  ); ?>/assets/img/avatar-default.svg" alt="<?= $author_name; ?>">
      <?php endif; ?> 
    </div>

    <div class="creator__info">
      <p class="creator__name"><?= $author_name; ?></p>
      <p class="creator__special"><?= $author_specialization; ?></p>
    </div>
  </div>

  <p class="creator__description">
    <?= $author_short_description; ?>
  </p>

  <a class="creator__link" href="<?= $author_url; ?>">
    <?= __( 'Об авторе', 'medvoice' ); ?>
  </a>
</div>