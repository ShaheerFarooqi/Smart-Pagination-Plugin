<?php
/**
 * Plugin Name: Smart Pagination PRO
 */

if (!defined('ABSPATH')) exit;

define('SP_PATH', plugin_dir_path(__FILE__));
define('SP_URL', plugin_dir_url(__FILE__));

// includes
require_once SP_PATH . 'includes/cpt.php';
require_once SP_PATH . 'includes/meta-box.php';
require_once SP_PATH . 'includes/shortcode.php';

// enqueue
function sp_enqueue_assets() {
    wp_enqueue_style('sp-css', SP_URL . 'assets/css/sp-pagination.css');
    wp_enqueue_script('sp-js', SP_URL . 'assets/js/sp-pagination.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'sp_enqueue_assets');