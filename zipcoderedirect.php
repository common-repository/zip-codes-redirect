<?php

/**
 * Plugin Name: Zip Code Redirect
 * Plugin URI: https://www.zipcode-redirect.com/
 * Description: Zip Code Redirect Will Check A Users Zip Code Or Post Code And Redirect The User To A Pre-determined URL Or Display A Useful Message.
 * Version: 5.2.5
 * Requires at least: 6.3
 * Requires PHP: 7.4
 * Author: Paul Glover
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html

 Zip Code Redirect is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 2 of the License, or
 any later version.
 
 Zip Code Redirect is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with Zip Code Redirect. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
if ( !defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    exit;
}
if ( function_exists( 'zcr_fs' ) ) {
    zcr_fs()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    if ( !function_exists( 'zcr_fs' ) ) {
        // Create a helper function for easy SDK access.
        function zcr_fs() {
            global $zcr_fs;
            if ( !isset( $zcr_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $zcr_fs = fs_dynamic_init( array(
                    'id'             => '7791',
                    'slug'           => 'zip-codes-redirect',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_e114c9d9e3ccacd7707345a340ff3',
                    'is_premium'     => false,
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                        'days'               => 14,
                        'is_require_payment' => false,
                    ),
                    'menu'           => array(
                        'slug' => 'zipcode-redirect',
                    ),
                    'is_live'        => true,
                ) );
            }
            return $zcr_fs;
        }

        // Init Freemius.
        zcr_fs();
        // Signal that SDK was initiated.
        do_action( 'zcr_fs_loaded' );
    }
    // ... Your plugin's main file logic ...
    if ( !class_exists( 'zipcode_redirect' ) ) {
        //class zipcode_Redirect
        class zipcode_redirect {
            public function __construct() {
                define( 'zipcheckdata', plugin_dir_path( __FILE__ ) . "includes/checkdata.php" );
                //global( $myglobal, plugin_dir_path(__file__))  ;
                add_action( 'admin_init', 'zipcode_redirect_settings' );
                add_action( 'admin_menu', 'zipcode_redirect_menu' );
                add_action( 'wp_enqueue_scripts', 'zipcode_scripts' );
                add_action( 'admin_enqueue_scripts', 'admin_redirect_scripts' );
                add_action( 'wp_ajax_zipredirect_ajax_call', 'zip_ajax_call' );
                add_action( 'wp_ajax_nopriv_zipredirect_ajax_call', 'zip_ajax_call' );
                add_shortcode( 'zipcoderedirect', 'zipcode_shortcode' );
                add_shortcode( 'zipcoderedirectplus', 'zipcode_shortcode_plus' );
                register_activation_hook( __FILE__, 'zipcode_activate' );
                zcr_fs()->add_action( 'after_uninstall', 'zcr_fs_uninstall_cleanup' );
                function zipcode_redirect_menu() {
                    // Create WordPress admin menu
                    $page_title = 'Zip Code Redirect Settings';
                    $menu_title = 'Zip Code Redirect';
                    $capability = 'activate_plugins';
                    $menu_slug = 'zipcode-redirect';
                    $function = 'zipcode_redirect_admin';
                    $icon_url = plugin_dir_url( __FILE__ ) . 'images/zipcode.ico';
                    $position = 8;
                    add_menu_page(
                        $page_title,
                        $menu_title,
                        $capability,
                        $menu_slug,
                        $function,
                        $icon_url,
                        $position
                    );
                }

                function zipcode_redirect_settings() {
                    // register default settings these have to be set here
                    register_setting( 'zipcode_redirect_settings', 'zipcodes1' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodes2' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodes3' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodes4' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodes11' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodesask' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodesneg' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodesuse' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodeswait' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodeswrong' );
                    register_setting( 'zipcode_redirect_settings', 'zipcodescheck' );
                    register_setting( 'zipcode_redirect_settings', 'zipsubmitcheck' );
                    register_setting( 'zipcode_redirect_settings', 'zipplaceholder' );
                    register_setting( 'zipcode_redirect_settings', 'ziptitle' );
                    register_setting( 'zipcode_redirect_settings', 'zipsubmittext' );
                }

                function zipcode_redirect_admin() {
                    include plugin_dir_path( __FILE__ ) . "/admin/admin.php";
                }

                function zipcode_activate() {
                    add_filter( 'upload_dir', 'zipcode_redirect' );
                    if ( !file_exists( wp_upload_dir()['path'] ) ) {
                        mkdir( wp_upload_dir['path'], 0755, true );
                    }
                    add_option( 'zipcodes1', "http://www.example.com 001 002 003 004 005 006 007 008 009 010 011 012" );
                    add_option( 'zipcodes2', "Great News We Cover user input. Call 1-800-XXX-000 To Book Your Appointment Now. - 013 014 015 016 017 018 019 020 021 022 023 024" );
                    add_option( 'zipcodesask', "Please Enter Your Full Zip Code." );
                    add_option( 'zipcodesneg', "We Are Sorry But We Cannot Redirect The Zip Code user input." );
                    add_option( 'zipcodesuse', "Use The 5 Digit US System" );
                    add_option( 'zipcodeswait', "Please Wait While We Check The Zip Code user input." );
                    add_option( 'zipcodeswrong', "The Zip Code user input Is Not In The Correct Format. Please Try Again." );
                    add_option( 'zipcodescheck', "5" );
                    add_option( 'zipcodeswon', "" );
                    add_option( 'zipcodeslost', "" );
                    add_option( 'zipsubmitcheck', "" );
                    add_option( 'zipcodestime', "1.000" );
                    add_option( 'zipplaceholder', "" );
                    add_option( 'ziptitle', "" );
                    add_option( 'zipsubmittext', "Submit" );
                    copy( plugin_dir_url( __FILE__ ) . '/includes/ZipCodes.docx', wp_upload_dir()['path'] . "/ZipCodes.docx" );
                    copy( plugin_dir_url( __FILE__ ) . '/includes/PostCodes.docx', wp_upload_dir()['path'] . "/PostCodes.docx" );
                    remove_filter( 'upload_dir', 'zipcode_redirect' );
                }

                function zipcode_redirect(  $uploads  ) {
                    $uploads['path'] = $uploads['basedir'] . '/zipcode-redirect';
                    // change upload path to zipcode_redirect
                    $uploads['url'] = $uploads['baseurl'] . '/zipcode-redirect';
                    // change upload dir to zipcode_redirect
                    return $uploads;
                }

                function zcr_fs_uninstall_cleanup() {
                    add_filter( 'upload_dir', 'zipcode_redirect' );
                    delete_option( 'zipcodes1' );
                    delete_option( 'zipcodes2' );
                    delete_option( 'zipcodes3' );
                    delete_option( 'zipcodes4' );
                    delete_option( 'zipcodes11' );
                    delete_option( 'zipcodesask' );
                    delete_option( 'zipcodesneg' );
                    delete_option( 'zipcodesuse' );
                    delete_option( 'zipcodeswait' );
                    delete_option( 'zipcodeswrong' );
                    delete_option( 'zipcodescheck' );
                    delete_option( 'zipcodeswon' );
                    delete_option( 'zipcodeslost' );
                    delete_option( 'zipsubmitcheck' );
                    delete_option( 'zipcodestime' );
                    delete_option( 'zipplaceholder' );
                    delete_option( 'ziptitle' );
                    delete_option( 'zipsubmittext' );
                    unlink( wp_upload_dir()['path'] . "/ZipCodes.docx" );
                    unlink( wp_upload_dir()['path'] . "/PostCodes.docx" );
                    rmdir( wp_upload_dir()['path'] );
                    remove_filter( 'upload_dir', 'zipcode_redirect' );
                }

                function zipcode_scripts() {
                    wp_enqueue_style(
                        'zipstyle',
                        plugin_dir_url( __FILE__ ) . 'css/style.css',
                        '',
                        '1.4'
                    );
                }

                function admin_redirect_scripts() {
                    wp_enqueue_style(
                        'adminzip_style',
                        plugin_dir_url( __FILE__ ) . 'css/adminstyle.css',
                        '',
                        '1.0'
                    );
                    wp_enqueue_script(
                        'adminzip',
                        plugin_dir_url( __FILE__ ) . 'js/adminzip.js',
                        array(),
                        '1.0',
                        true
                    );
                }

                function zipcode_shortcode_plus() {
                    wp_enqueue_script(
                        'zipplus',
                        plugin_dir_url( __FILE__ ) . 'js/zipplus.js',
                        array('jquery'),
                        '1.0',
                        true
                    );
                    wp_localize_script( 'zipplus', 'ziplisten_vars', array(
                        'ajaxurl'  => admin_url() . "admin-ajax.php",
                        'security' => wp_create_nonce( 'zipcode-security-nonce' ),
                        'zipneg'   => get_option( 'zipcodesneg' ),
                        'zipwait'  => get_option( 'zipcodeswait' ),
                        'zipwrong' => get_option( 'zipcodeswrong' ),
                        'zipuse'   => get_option( 'zipcodesuse' ),
                    ) );
                    ob_start();
                    include plugin_dir_path( __FILE__ ) . "forms/zipformplus.php";
                    $output = ob_get_clean();
                    return $output;
                }

                function zipcode_shortcode() {
                    wp_enqueue_script(
                        'ziplisten',
                        plugin_dir_url( __FILE__ ) . 'js/ziplisten.js',
                        array('jquery'),
                        '1.7',
                        true
                    );
                    wp_localize_script( 'ziplisten', 'ziplisten_vars', array(
                        'ajaxurl'  => admin_url() . "admin-ajax.php",
                        'security' => wp_create_nonce( 'zipcode-security-nonce' ),
                        'zipneg'   => get_option( 'zipcodesneg' ),
                        'zipwait'  => get_option( 'zipcodeswait' ),
                        'zipwrong' => get_option( 'zipcodeswrong' ),
                        'zipuse'   => get_option( 'zipcodesuse' ),
                    ) );
                    ob_start();
                    include plugin_dir_path( __FILE__ ) . "forms/zipform.php";
                    $output = ob_get_clean();
                    return $output;
                }

                function checktime() {
                    // calclate elapsed time
                    $time_end = microtime( true );
                    $time = $time_end - ajax_time_start;
                    $time = round( $time, 3 );
                    update_option( 'zipcodestime', $time );
                    return;
                }

                function zip_ajax_call() {
                    //nonce security
                    check_ajax_referer( 'zipcode-security-nonce', 'security', true );
                    //get start time
                    define( 'ajax_time_start', microtime( true ) );
                    // check user zip for validity
                    include plugin_dir_path( __FILE__ ) . "includes/postcode.php";
                    // get admin url and zipcodes
                    $adminzips = sanitize_text_field( get_option( 'zipcodes1' ) );
                    include plugin_dir_path( __FILE__ ) . "includes/redirect.php";
                    // get admin url and zipcodes
                    $adminzips = sanitize_text_field( get_option( 'zipcodes2' ) );
                    include plugin_dir_path( __FILE__ ) . "includes/redirect.php";
                    $zipcodes = esc_html( get_option( 'zipcodeslost' ) );
                    $userzip = strtoupper( $userzip );
                    $url = esc_html( get_option( 'zipcodesneg' ) );
                    $zipcodes = ( strpos( esc_html( get_option( 'zipcodesneg' ) ), "http" ) === 0 ? $zipcodes . "\n" . "Zip Code " . $userzip . " -Redirect- " . $url : $zipcodes . "\n" . $userzip . " Was Not Redirected " );
                    $zipcodes = explode( "\n", $zipcodes );
                    if ( $check = count( $zipcodes ) > 10 ) {
                        $zipcodes = array_slice( $zipcodes, -10 );
                    }
                    $zipcodes = implode( "\n", $zipcodes );
                    update_option( 'zipcodeslost', $zipcodes );
                    checktime();
                    esc_html_e( "2" );
                    wp_die();
                }

            }

        }

    }
    $zipcoderedirect = new zipcode_redirect();
    // lets get the party started
}