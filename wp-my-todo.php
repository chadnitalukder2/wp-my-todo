<?php
if( !defined( constant_name: 'ABSPATH')){
    die(' You are not allowed to call this page directly');
}

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
    var_dump('activate');
    // add_action('wp_todo_plugin_activated', 'hello');
}
register_deactivation_hook(
    __FILE__,
    'my_todo_deactivation_pluginprefix'
);

function my_todo_deactivation_pluginprefix()
{
    var_dump('deactivation');
    exit();
}

register_uninstall_hook(
    __FILE__,
    'wp_todo_plugin_register_uninstall'
);

function wp_todo_plugin_register_uninstall(){
    //var_dump('uninstall');
    //exit();
}

//=========================Action Hoke===========================
add_action('save_post', 'wp_todo_plugin_our_custom_action_to_update_post');

function wp_todo_plugin_our_custom_action_to_update_post(){
    // return('save_post');
    // exit();
}

add_action('wp_todo_plugin_activated', 'wp_todo_plugin_create_table');

function wp_todo_plugin_create_table($data){
    var_dump('table created');
    var_dump($data);
    exit();
}







?>



