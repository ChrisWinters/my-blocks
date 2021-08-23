<?php
/**
 * Plugin Name: My Blocks
 * Plugin URI: https://localhost/
 * Description: My Blocks
 * Author:Me
 * Author URI: https://localhost/lol
 * Version: 2.2.2
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: my-blocks
 */

define( 'MYBLOCK_DIR', __DIR__ );
define( 'MYBLOCK_FILE', __FILE__ );
define( 'MYBLOCK_PLUGIN_DIR', dirname( __FILE__ ) );


function enqueue_frontend_assets() {
    wp_enqueue_style(
        'my-block-styles',
        plugins_url( '/css/frontend.css', MYBLOCK_FILE ),
        array(),
        '0.0.0'
    );
}

add_action( 'enqueue_block_assets', 'enqueue_frontend_assets' );


function enqueue_assets() {
    $asset_file = include( plugin_dir_path( MYBLOCK_FILE ) . 'build/index.asset.php');
 
    wp_register_script(
        'my-block',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );
 
    wp_register_style(
        'my-block-editor',
        plugins_url( 'src/editor.css', __FILE__ ),
        array( 'wp-edit-blocks' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'src/editor.css' )
    );
 
    wp_register_style(
        'my-block-style',
        plugins_url( 'src/style.css', __FILE__ ),
        array( ),
        filemtime( plugin_dir_path( __FILE__ ) . 'src/style.css' )
    );
 
    wp_style_add_data( 'my-block-inline', 'path', dirname( __FILE__ ) . '/build/style.css' );

    register_block_type( 'my-blocks/my-block', array(
        'api_version' => 2,
        'editor_script' => 'my-block',
        'editor_style' => 'my-block-editor',
        'style' => 'my-block-style',
    ) );
}

add_action( 'init', 'enqueue_assets' );




