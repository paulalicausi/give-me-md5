<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
global $wpdb;
$gm_md5_table = $wpdb->prefix . "giveme_md5";
$wpdb->query( "DROP TABLE IF EXISTS ". $gm_md5_table."" );
?>
