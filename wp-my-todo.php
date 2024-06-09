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

 
 register_activation_hook(
    __FILE__ ,
     'my_todo_active_pluginprefix'
    );

function my_todo_active_pluginprefix(){
    // var_dump('activate');
    do_action('wp_todo_plugin_activated', 'hello');
}
register_deactivation_hook(
    __FILE__,
    'my_todo_deactivation_pluginprefix'
);

function my_todo_deactivation_pluginprefix()
{
    // var_dump('deactivation');
    // exit();
}

register_uninstall_hook(
    __FILE__,
    'wp_todo_plugin_register_uninstall'
);

function wp_todo_plugin_register_uninstall(){
    //var_dump('uninstall');
    //exit();
}

add_action('wp_todo_plugin_activated', 'wp_todo_plugin_create_table', 10, 2);
function wp_todo_plugin_create_table($data)
{
    // error_log('table created');
    // error_log($data);
    // exit();
}

//=========================Action Hoke================================================
add_action('save_post', 'wp_todo_plugin_our_custom_action_to_update_post');

function wp_todo_plugin_our_custom_action_to_update_post(){
    // return('save_post');
    // exit();
}


add_action('save_post', function ($postId, $post){
    // var_dump('first');
}, 15, 2);

add_action('save_post', function ($postId, $post) {
    // var_dump('secound');
},10, 2);


//===========================filter Hoke=============================================================

// add_filter('the_title', function($title) {
//     return 'Clean Code With Puja '. $title;
// } ,10 , 1);

function wp_todo_plugin_filter_hook_test(){
    $data = 'Hello World';
    $data = apply_filters('wp_todo_plugin_our_custom_hook_name', $data, 'Puja');
    echo $data;
}

// add_filter('wp_todo_plugin_our_custom_hook_name', function ($data, $name) {
//   return 'modify data ' . $name;
// } ,10 , 2);

add_filter('wp_todo_plugin_our_custom_hook_name', 'wp_todo_plugin_filter_hook_test_2', 10, 2);

function wp_todo_plugin_filter_hook_test_2($data, $name){
    $data = 'modified data ' . $name;
    return $data;

};

remove_filter('wp_todo_plugin_our_custom_hook_name' , 'wp_todo_plugin_filter_hook_test_2', 10);

wp_todo_plugin_filter_hook_test();
// exit();


//===================================Add a Top-Level Menu=================================================

add_action('admin_menu', 'wp_todo_plugin_menu');

function wp_todo_plugin_menu()
{
    add_menu_page(
       'Wp Todo Plugin', // Page title
        'Todos',          // Menu title
        'manage_options', // Capability
        'wp-todo-plugin', // Menu slug
        'wp_todo_plugin_page', // Function to display the page content
        'dashicons-list-view',               // Icon URL (optional)
        10               // Position (optional)
    );
}

function wp_todo_plugin_page(){
    echo ('Hello world');
}


