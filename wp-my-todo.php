<?php
defined('ABSPATH') or die;

/*
 * Plugin Name:       Wp My Todo
 * Plugin URI:        https://wordpress.org/plugins/wp-my-todo/
 * Description:       A Plugin to manage your todo list
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Chadni Talukder
 * Author URI:        https://chadnitalukder2.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       wp-my-todo
 * Domain Path:       /languages
 */

 //===========================Enqueue Custom CSS and JS in WP Plugin Development===================================
 define('WP_TODO_PLUGIN_VERSION', '1.0.0');
define('WP_TODO_PLUGIN_FILE', __FILE__);
define('WP_TODO_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_TODO_PLUGIN_DIR', plugin_dir_path(__FILE__));

//include_once 'abcd/abcd.php';

//wwp_enqueue_scripts frontend e load hoy.

add_action('admin_enqueue_scripts', function(){
    wp_register_script('wp_todo_plugin', WP_TODO_PLUGIN_URL . 'js/custom.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('wp_todo_plugin');

    // wp_enqueue_script('wp_todo_plugin', WP_TODO_PLUGIN_URL . 'js/custom.js', array('jquery'), '1.0.0', true);
    //wp_enqueue_script('wp_todo_plugin_test', WP_TODO_PLUGIN_URL . 'js/custom.js', array('wp_todo_plugin','jquery'), '1.0.0', true);

    wp_enqueue_style('wp_todo_plugin', WP_TODO_PLUGIN_URL . 'css/custom.css', [] , '1.0.0', false);

    wp_localize_script(
        'wp_todo_plugin',
        'wp_todo_plugin',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('wp-todo-plugin-nonce'),
            'abcd'     => 'abcd',
        )
    );
});
//====================================AJAX Request========================================================
add_action ('wp_ajax_wp_todo_abc', function(){
//var_dump( $_POST);
if(wp_verify_nonce($_REQUEST['nonce'], 'wp-todo-plugin-nonce') === false){
        wp_send_json_error(array(
            'message' => 'nonce is not valid',
        ));
}
        wp_send_json_success(array(
            'message' => 'success',
            'data'    => $_POST,
        ));

});

//Frontend ajax   ============** nopriv  **=============
add_action('wp_ajax_wp_todo_abc_again', function () {
    //var_dump( $_POST);
    wp_send_json_success(array(
        'message' => 'success again',
        'response'    => [
            'cars' => ['Volvo', 'BMW', 'Toyota']
        ],
    ));
});
