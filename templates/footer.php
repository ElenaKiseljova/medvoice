    <?php 
      // Показывать попап, если закончился Триал или Подписка
      $subscribe_ended_popup_show = (isset($_COOKIE['subscribe-ended']) && $_COOKIE['subscribe-ended'] !== '1') || ($_COOKIE['subscribe-ended'] === null);
      $subscribe_ended = is_user_logged_in(  ) && !medvoice_user_have_subscribe_trial() && !medvoice_user_have_subscribe();
    ?>
    <?php if ( !isset($_GET['action']) && $subscribe_ended_popup_show && $subscribe_ended ) : ?>
      <div class="popup" data-type="subscribe-ended">
        <button class="popup__close">
          <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.78955 8.76776L6.03931 5.01096L9.76819 1.30693C10.0494 1.02815 10.0494 0.576817 9.76819 0.298747C9.48771 0.0206768 9.0321 0.0206768 8.75161 0.298747L5.02772 3.99779L1.2483 0.211761C0.967814 -0.070587 0.512205 -0.070587 0.23172 0.211761C-0.0487639 0.493396 -0.0487639 0.951142 0.23172 1.23278L4.00545 5.0131L0.210363 8.78273C-0.0701211 9.06151 -0.0701211 9.51284 0.210363 9.79091C0.490848 10.0697 0.946457 10.0697 1.22765 9.79091L5.01775 6.02628L8.77368 9.78806C9.05417 10.0704 9.50978 10.0704 9.79026 9.78806C10.07 9.50714 10.07 9.05011 9.78955 8.76776Z" fill="#007474"/>
          </svg>
        </button>
        <div class="popup__container container">
          <?php 
            get_template_part( 'templates/forms' );
          ?>
        </div>
      </div>
    <?php endif; ?>    
  <?php
    wp_footer();
  ?>
</body>
</html>