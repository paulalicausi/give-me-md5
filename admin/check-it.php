<?php
if (! current_user_can ('manage_options')) wp_die (__ ('You dont have access to this page'));
?>
<div class="check_md5_container">
  <div class="wrap">
    <h2><?php _e( 'Give me MD5 <i class="fas fa-hand-sparkles"></i>', 'Give me MD5' ) ?></h2>
    <p>Welcome to "Give me MD5". A simple plugin to check if an MD5 is correct or not.<br>
      Using it is very easy. You only have to enter in the field below the list of MD5 you want to check.<br>
    </p>
  </div>
  <div class="check_md5_main">
    <form class="check_md5_form" action="" method="post">
      <label for="string">Enter in the following format ID + NAME + MD5. One per line.</label>
      <textarea name="string" rows="8" cols="80" placeholder="E.g.: 001 srvmail bddac79424b4fad646d7fe56a8b5af77"></textarea>
      <button type="submit" name="button">Check MD5</button>
      <?php if (isset($gm_md5_response)) {
        echo $gm_md5_response;
      } ?>
    </form>
  </div>
</div>
