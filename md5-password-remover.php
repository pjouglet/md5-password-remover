<?php
/*
Plugin Name: MD5 Password Remover
Plugin URI: https://github.com/pjouglet/md5-password-remover
Description: Remove the backward compatibility with MD5 hash for passwords
Version: 1.0.0
Author: Pierre JOUGLET
Author URI: https://pierrejouglet.com/
*/

define('WP_MD5_PASSWORD_REMOVED_PLUGIN_DIR', plugin_dir_path(__FILE__));
require_once(WP_MD5_PASSWORD_REMOVED_PLUGIN_DIR . 'Md5PasswordRemover.php' );
add_action('init', array('Md5PasswordRemover', 'init'));
