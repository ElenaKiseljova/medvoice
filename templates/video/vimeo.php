<?php 
  $vimeo_id = get_field( 'vimeo_id', $video_id ) ?? '';  

  // $videos = get_posts( ['post_type' => 'videos', 'numberposts' => -1] );

  // foreach ($videos as $key => $video) {
  //   update_field( 'vimeo_id', '679049228', $video->ID );
  // }
?>
<div class="lection__video">
  <div class="lection__vimeo">
    <div style="padding:62.5% 0 0 0;position:relative;">
      <iframe style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>

  <div class="lection__img" data-video-id="<?= $vimeo_id; ?>">
    <?php 
      if ( has_post_thumbnail(  ) ) {
        the_post_thumbnail( 'full' );
      }
    ?>

    <button class="lection__btn">
      <svg width="33" height="40">
          <use xlink:href="<?= get_template_directory_uri(  ); ?>/assets/img/sprite.svg#play"></use>
      </svg>
    </button>
  </div>  
</div>