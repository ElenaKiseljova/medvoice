<?php 
  $author = get_queried_object();

  $content = get_field( 'content', $author ); 
?>
<div class="author__content">
  <?= $content; ?>
</div>