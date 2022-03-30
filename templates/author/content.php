<?php 
  global $author;

  if ( $author instanceof WP_Term ) {
    # code...
  } else {
    return;
  }
 
  $author_description = term_description();
?>
<div class="author__content">
  <?= $author_description; ?>
</div>