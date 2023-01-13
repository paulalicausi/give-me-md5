<?php /*
Plugin Name: Give me MD5
Plugin URI: http://wwww.paulalicausi.com
Description: Simple plugin to check if MD5 is correct or not.
Version: 1.0.0
Author: Paula Licausi
Author URI: http://wwww.paulalicausi.com
License: GPL
*/

defined('ABSPATH') or die("Bye :)");
define('GIVEME_MD5_ROUTE', plugin_dir_path(__FILE__));
include(GIVEME_MD5_ROUTE . 'includes/functions.php');

function gm_md5_activation()
{
  global $wpdb;
  $table = $wpdb->prefix . "giveme_md5";
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table (
          id bigint(20) NOT NULL AUTO_INCREMENT,
          gm_md5_id varchar(20) NOT NULL,
          gm_md5_name varchar(50) NOT NULL,
          gm_md5_hash varchar(32) NOT NULL,
          PRIMARY KEY (id)
        ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}
register_activation_hook(__FILE__, 'gm_md5_activation');

if ( !function_exists('gm_md5_addAdmin')) {
  function gm_md5_addAdmin()
  {
   add_menu_page('Give me MD5', 'Give me MD5', 'manage_options', GIVEME_MD5_ROUTE . '/admin/check-it.php');
  }
}
add_action( 'admin_menu', 'gm_md5_addAdmin' );


if (!function_exists('gm_md5_add_style')) {
  function gm_md5_add_style()
  {
    wp_enqueue_style( 'giveme_md5_style', plugins_url( '/admin/css/style.css', __FILE__ )  );
    wp_enqueue_style( 'giveme_md5_icons', plugins_url( '/admin/css/icons.min.css', __FILE__ )  );
  }
}
add_action( 'admin_enqueue_scripts', 'gm_md5_add_style' );
?>
