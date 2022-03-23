<?php if ( function_exists( 'pll_the_languages' ) ) : ?>
  <?php 
    $langaages = pll_the_languages(array('raw'=>1));   
  ?>
  <ul class="nav__lang-list">
    <?php foreach ($langaages as $key => $langaage) : ?>
      <li class="nav__lang-link <?= $langaage['current_lang'] ? 'nav__lang-link--active' : ''; ?>">
        <a href="<?= $langaage['url']; ?>">
          <?= strtoupper(($langaage['slug'] === 'uk') ? 'ua' : $langaage['slug']) ; ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>   