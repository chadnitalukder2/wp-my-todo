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
    var_dump(__FILE__) ,
     'my_todo_active_pluginprefix'
    );

function my_todo_active_pluginprefix(){
    // var_dump('activate');
    // exit();
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

?>