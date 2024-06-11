<?php

register_activation_hook(
    __FILE__,
    'my_todo_active_pluginprefix'
);

function my_todo_active_pluginprefix()
{
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

function wp_todo_plugin_register_uninstall()
{
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

function wp_todo_plugin_our_custom_action_to_update_post()
{
    // return('save_post');
    // exit();
}


add_action('save_post', function ($postId, $post) {
    // var_dump('first');
}, 15, 2);

add_action('save_post', function ($postId, $post) {
    // var_dump('secound');
}, 10, 2);


//===========================filter Hoke=============================================================

// add_filter('the_title', function($title) {
//     return 'Clean Code With Puja '. $title;
// } ,10 , 1);

function wp_todo_plugin_filter_hook_test()
{
    // $data = 'Hello World';
    // $data = apply_filters('wp_todo_plugin_our_custom_hook_name', $data, 'Puja');
    // echo $data;
}

// add_filter('wp_todo_plugin_our_custom_hook_name', function ($data, $name) {
//   return 'modify data ' . $name;
// } ,10 , 2);

add_filter('wp_todo_plugin_our_custom_hook_name', 'wp_todo_plugin_filter_hook_test_2', 10, 2);

function wp_todo_plugin_filter_hook_test_2($data, $name)
{
    // $data = 'modified data ' . $name;
    // return $data;

};

remove_filter('wp_todo_plugin_our_custom_hook_name', 'wp_todo_plugin_filter_hook_test_2', 10);

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
    // Add submenu page
    add_submenu_page(
        'wp-todo-plugin',     // Parent slug
        'Add New Todo',       // Page title
        'Add New Todo',       // Menu title
        'manage_options',     // Capability
        'wp-todo-plugin-new', // Menu slug
        'wp_todo_plugin_submenu'  // Function to display the page content
    );
    add_users_page(
        __('My Plugin Users', 'textdomain'),
        __('My Plugin', 'textdomain'),
        'manage_options',
        'my-unique-identifier',
        'my_plugin_function'
    );
}

function wp_todo_plugin_page()
{
    echo '<h1> Hello world  </h1>';
}

function wp_todo_plugin_submenu()
{
    echo '<h1> Add New Todo </h1>';
}

function my_plugin_function()
{
    echo 'my plugin user';
}
//=======================Add a Shortcode===============================================

add_shortcode('wp-todo-plugin', 'wp_todo_plugin_shortcode');

function wp_todo_plugin_shortcode($atts = [], $content = null)
{
    // $content .= '<h1>Hello world</h1>';
    $atts = shortcode_atts(
        array(
            'width' => '50',
            'height' => '50',
            'url' => 'https://buffer.com/library/content/images/size/w1200/2023/10/free-images.jpg',
        ),
        $atts,
        'wp-todo-plugin'
    );
    $width = $atts['width'] . 'px';
    $height = $atts['height'] . 'px';
    $url = $atts['url'];
    $content = '<img src="' . $url . '" width =" ' . $height . '" height=" ' . $height . ' ">';
    return  $content;
}


//=====================================Settings api==================================================================

add_action('admin_init', function () {
    register_setting('writing', 'wp_todo_plugin_site_key');
    register_setting('writing', 'wp_todo_plugin_writing_select');

    add_settings_section(
        'wp_todo_settings_section_writing',
        'Site Key',
        'wp_todo_plugin_setting_section_writing',
        'writing',
    );
    add_settings_field(
        'setting_filed_id',
        'Text Input',
        'wp_todo_plugin_setting_filed_writing',
        'writing',
        'wp_todo_settings_section_writing'
    );
    add_settings_field(
        'setting_filed_id_snd',
        'Multiple Select',
        'wp_todo_plugin_setting_filed_writings',
        'writing',
        'wp_todo_settings_section_writing'
    );
});
function wp_todo_plugin_setting_section_writing()
{
}

function wp_todo_plugin_setting_filed_writing()
{
    $site_key = get_option('wp_todo_plugin_site_key');
?>
    <input type="text" name="wp_todo_plugin_site_key" value="<?php echo $site_key; ?>">
<?php
}

function wp_todo_plugin_setting_filed_writings()
{
    $site_key = get_option('wp_todo_plugin_writing_select');
    $value = get_option('wp_todo_plugin_writing_select');
?>

    <select name="wp_todo_plugin_writing_select">
        <option value="one" <?php echo $value === 'one' ? 'selected' : ''; ?>>One</option>
        <option value="two" <?php echo $value === 'two' ? 'selected' : ''; ?>>Two</option>
        <option value="three" <?php echo $value === 'three' ? 'selected' : ''; ?>>Three</option>
    </select>
<?php
}

//=========================Custom Setting Page=============================================================================

/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function wporg_settings_init()
{
    // Register a new setting for "wporg" page.
    register_setting('wporg', 'wporg_options');

    // Register a new section in the "wporg" page.
    add_settings_section(
        'wporg_section_developers',
        __('The Matrix has you.', 'wporg'),
        'wporg_section_developers_callback',
        'wporg'
    );

    // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
    add_settings_field(
        'wporg_field_pill', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Pill', 'wporg'),
        'wporg_field_pill_cb',
        'wporg',
        'wporg_section_developers',
        array(
            'label_for'         => 'wporg_field_pill',
            'class'             => 'wporg_row',
            'wporg_custom_data' => 'custom',
        )
    );
}

/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action('admin_init', 'wporg_settings_init');


/**
 * Custom option and settings:
 *  - callback functions
 */


/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function wporg_section_developers_callback($args)
{
?>
    <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Follow the white rabbit.', 'wporg'); ?></p>
<?php
}

/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function wporg_field_pill_cb($args)
{
    // Get the value of the setting we've registered with register_setting()
    $options = get_option('wporg_options');
?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" data-custom="<?php echo esc_attr($args['wporg_custom_data']); ?>" name="wporg_options[<?php echo esc_attr($args['label_for']); ?>]">
        <option value="red" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'red', false)) : (''); ?>>
            <?php esc_html_e('red pill', 'wporg'); ?>
        </option>
        <option value="blue" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'blue', false)) : (''); ?>>
            <?php esc_html_e('blue pill', 'wporg'); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e('You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg'); ?>
    </p>
    <p class="description">
        <?php esc_html_e('You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg'); ?>
    </p>
<?php
}

/**
 * Add the top level menu page.==========================================================================
 */
function wporg_options_page()
{
    add_menu_page(
        'WPOrg',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html'
    );
}


/**
 * Register our wporg_options_page to the admin_menu action hook.
 */
add_action('admin_menu', 'wporg_options_page');


/**
 * Top level menu callback function
 */
function wporg_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('wporg_messages', 'wporg_message', __('Settings Saved', 'wporg'), 'updated');
    }

    // show error/update messages
    settings_errors('wporg_messages');
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields('wporg');
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections('wporg');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}


//===================================================Custom Post Types==============================================================
add_action('init', 'wp_todo_post_type');


// Register Custom Post Type Wp Todo
function wp_todo_post_type()
{

    $labels = array(
        'name' => _x('Wp Todos', 'Post Type General Name', 'wp-my-todo'),
        'singular_name' => _x('Wp Todo', 'Post Type Singular Name', 'wp-my-todo'),
        'menu_name' => _x('Wp Todos', 'Admin Menu text', 'wp-my-todo'),
        'name_admin_bar' => _x('Wp Todo', 'Add New on Toolbar', 'wp-my-todo'),
        'archives' => __('Wp Todo Archives', 'wp-my-todo'),
        'attributes' => __('Wp Todo Attributes', 'wp-my-todo'),
        'parent_item_colon' => __('Parent Wp Todo:', 'wp-my-todo'),
        'all_items' => __('All Wp Todos', 'wp-my-todo'),
        'add_new_item' => __('Add New Wp Todo', 'wp-my-todo'),
        'add_new' => __('Add New', 'wp-my-todo'),
        'new_item' => __('New Wp Todo', 'wp-my-todo'),
        'edit_item' => __('Edit Wp Todo', 'wp-my-todo'),
        'update_item' => __('Update Wp Todo', 'wp-my-todo'),
        'view_item' => __('View Wp Todo', 'wp-my-todo'),
        'view_items' => __('View Wp Todos', 'wp-my-todo'),
        'search_items' => __('Search Wp Todo', 'wp-my-todo'),
        'not_found' => __('Not found', 'wp-my-todo'),
        'not_found_in_trash' => __('Not found in Trash', 'wp-my-todo'),
        'featured_image' => __('Featured Image', 'wp-my-todo'),
        'set_featured_image' => __('Set featured image', 'wp-my-todo'),
        'remove_featured_image' => __('Remove featured image', 'wp-my-todo'),
        'use_featured_image' => __('Use as featured image', 'wp-my-todo'),
        'insert_into_item' => __('Insert into Wp Todo', 'wp-my-todo'),
        'uploaded_to_this_item' => __('Uploaded to this Wp Todo', 'wp-my-todo'),
        'items_list' => __('Wp Todos list', 'wp-my-todo'),
        'items_list_navigation' => __('Wp Todos list navigation', 'wp-my-todo'),
        'filter_items_list' => __('Filter Wp Todos list', 'wp-my-todo'),
    );
    $args = array(
        'label' => __('Wp Todo', 'wp-my-todo'),
        'description' => __('', 'wp-my-todo'),
        'labels' => $labels,
        'menu_icon' => 'dashicons-list-view',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author', 'comments', 'trackbacks', 'page-attributes', 'post-formats', 'custom-fields'),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('wp-todo-plugin', $args);
}


add_action('init', function () {
    $args = array(
        'post_type'      => 'wp-todo-plugin',
        'posts_per_page' => 10,
    );
    $loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();
    ?>
        <div class="entry-content">
            <?php the_title(); ?>
            <?php the_content(); ?>
        </div>
<?php
    }
});

//=======================================================Taxonomies=====================================================================


function wp_todo_register_taxonomy_course()
{
    $labels = array(
        'name'              => __('Courses'),
        'singular_name'     => __('Course'),
        'search_items'      => __('Search Courses'),
        'all_items'         => __('All Courses'),
        'parent_item'       => __('Parent Course'),
        'parent_item_colon' => __('Parent Course:'),
        'edit_item'         => __('Edit Course'),
        'update_item'       => __('Update Course'),
        'add_new_item'      => __('Add New Course'),
        'new_item_name'     => __('New Course Name'),
        'menu_name'         => __('Course'),
    );
    $args   = array(
        'hierarchical'      => true, // make it hierarchical (like categories)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'course'],
        'show_in_rest'      => true,
    );
    register_taxonomy('course', ['post'], $args);
}
add_action('init', 'wp_todo_register_taxonomy_course');

//================================================User Metadata================================================================

add_action('init', function () {
    //======================================================================================
    //     // echo '<pre></pre>';
    //     // print_r(wp_roles());
    //     // exit();
    //======================================================================================
    //    $user = wp_create_user('chadni', 'password', 'cahdnitalukder2@gmail.com');
    //======================================================================================
    // var_dump(wp_get_current_user());
    // $update_user = wp_update_user([
    //     'ID' => 2,
    //     'user_url' => 'https://chadnitalukder2.com'
    // ]);
    //    var_dump($user);
    //    exit();
    //======================================================================================
    // add_user_meta(
    //     '2',
    //     'wp_todo_key',
    //     'wp_todo_value',
    // );
    //======================================================================================
    // update_user_meta(
    //     '2',
    //     'wp_todo_key',
    //     'wp_todo_value update',
    // );
    //======================================================================================
    //    $data = get_user_meta(
    //         '2',
    //         'wp_todo_key',
    //     );
    //   var_dump($data);
    //======================================================================================
    // echo "<pre>";
    // print_r(get_role('administrator'));
    // exit();
    //======================================================================================
    // add_role(
    //     'simple_role',
    //     'Simple Role',
    //     array(
    //         'read'         => true,
    //         'edit_posts'   => true,
    //         'upload_files' => true,
    //     ),
    // );
    //======================================================================================
    // $role = get_role('simple_role');
    // var_dump($role);
    // $role->add_cap('wp_todo_test', 1);
    // echo '<pre>';
    // print_r($role);
    // exit();
    //==================================================================================================
    // function wp_todo_user_permission_check()
    // {
    //     if (current_user_can('read')) {
    //         echo "permitted";
    //     } else {
    //         echo "not permitted";
    //     }
    // }

    // wp_todo_user_permission_check();
    // exit();

});
//====================================================================================================
