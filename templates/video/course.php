<section class="course">
  <div class="course__tab course__tab--active">
    <?php 
      get_template_part( 'templates/catalog' );
    ?>
  </div>

  <div class="course__tab">
    <div class="course__about">
      <div class="course__info">
        <?php 
          get_template_part( 'templates/video/tags' );
        ?>

        <div class="course__content">
          <?= get_the_content(  ); ?>
        </div>
      </div>

      <?php 
        get_template_part( 'templates/video/author' );
      ?>
    </div>
  </div>
</section>