<?php 
  global $video;

  $title = get_sub_field('title') ?? '';
  $videos = get_sub_field('videos') ?? [];

  $archive = get_sub_field('archive') ?? [];

  $format = isset($archive['format']) ? $archive['format'] : get_term_by( 'slug', 'kurs', 'format' );  
?>

<section class="slider" id="<?= $format->slug; ?>">
  <div class="swiper swiper-courses">
    <div class="slider__head">
      <h2 class="slider__title">
         <?= $title; ?>
      </h2>

      <?php if (isset($archive['title']) && !empty($archive['title'])) : ?>
        <a href="<?= get_term_link( $format ); ?>" class="slider__link">
          <?= $archive['title']; ?>
        </a>
      <?php endif; ?>      
    </div>

    <?php if ($videos && !empty($videos) && !is_wp_error( $videos )) : ?>
      <div class="swiper-wrapper">
        <?php foreach ($videos as $key => $video_item) : ?>
          <?php 
            $video = $video_item;

            get_template_part( 'templates/video' );
          ?>
        <?php endforeach; ?>
      </div>

      <div class="slider__btn-box">
        <svg aria-labelledby="<?= __( 'Предыдущий слайд', 'medvoice' ); ?>" class="slider__btn-prev" width="30" height="30">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#prev"></use>            
        </svg> 
        <svg aria-labelledby="<?= __( 'Следующий слайд', 'medvoice' ); ?>" class="slider__btn-next" width="30" height="30">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#next"></use>            
        </svg>
      </div>
    <?php endif; ?>  
  </div>
</section>