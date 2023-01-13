<?php
//Function to check if MD5 is valid
if ( !function_exists('gm_md5_isMD5')) {
  function gm_md5_isMD5($md5 = '')
  {
      return preg_match('/^[a-f0-9]{32}$/', $md5);
  }
}

if ( $_SERVER["REQUEST_METHOD"] === "POST") {
  $gm_md5_string = $_POST["string"];

  if (isset($gm_md5_string) && !empty($gm_md5_string)) {

    $gm_md5_string = trim($gm_md5_string, "\t\n\r");
    $gm_md5_string = explode(PHP_EOL, $gm_md5_string);

    //Unsets empty lines
    for ($i=0; $i < sizeof($gm_md5_string); $i++) {
      if (strlen($gm_md5_string[$i]) <= 0) {
        unset($gm_md5_string[$i]);
      }
    }

    foreach ($gm_md5_string as $s) {

      //Remove all whitespaces and invisible characters
      $s = trim($s, "\x20,\xC2,\xA0,/\r|\n/,\t\n\r");
      $s = preg_split("/\s+/", $s);

      $gm_md5_idName = $s[0] . $s[1];
      $gm_md5_hash = $s[2];

      //Check if it really is an MD5
      if (gm_md5_isMD5($gm_md5_hash)) {

        //Check if md5 is right
        if (md5($gm_md5_idName) === $gm_md5_hash) {
          $gm_md5_response .= "<p class='ok'><i class='fas fa-check'></i> The MD5 <i>". $gm_md5_hash ."</i> for <i>" . $gm_md5_idName . "</i> is correct!";
        }else {
          $gm_md5_response .= "<p class='no'><i class='fas fa-times'></i> The MD5 <i>". $gm_md5_hash ."</i> for <i>" . $gm_md5_idName . "</i> is wrong.";
        }

        //Check if exists in db
        global $wpdb;
        $gm_md5_table = $wpdb->prefix . "giveme_md5";
        $gm_md5_getHash = $wpdb->get_results("SELECT * FROM $gm_md5_table WHERE gm_md5_hash = '". $gm_md5_hash ."'");
        if (!empty($gm_md5_getHash)) {
          $gm_md5_response .= " And already <b>exists</b> in the database!</p>";
        }else {
            $wpdb->insert($gm_md5_table, array("gm_md5_id" => $s[0], "gm_md5_name" => $s[1], "gm_md5_hash" => $s[2]));
            $gm_md5_response .= " And we will <b>save</b> it in the database.</p>";
        }

      }else {
        $gm_md5_response .= "<p class='no'><i class='fas fa-times'></i> Please follow the correct format and check if it is a valid <a href='https://en.wikipedia.org/wiki/MD5'>MD5</a></p>";
      }
    }
  }else {
    $gm_md5_response .= "<p class='no'>Plese, enter some text.</p>";
  }
}
?>
