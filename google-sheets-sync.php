<?php
/*
 * Plugin Name:       Google Sheets Sync
 * Description:       This plugin used for generate google sheets for orders information.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Bristy
 * Author URI:        https://author.example.com/
 * Text Domain:       google-sheets-sync
 * Domain Path:       /languages
 */

class Google_Sheets_Sync {

    public function __construct() {
        add_filter( 'easycommerce_settings_menus', array( $this, 'add_settings_menu' ) );
    }

    public function add_settings_menu( $easycommerce_settings_menus ) {
        $easycommerce_settings_menus['google_sheets_sync'] = array(
                'label'      => __( 'Google Sheets Sync', 'easycommerce' ),
                'icon'       => plugin_dir_url( __FILE__ ) . 'assets/img/sheets.png',
                'hover-icon' =>  plugin_dir_url( __FILE__ ) . 'assets/img/sheets.png',
                'submenus'   => array(
                    'spreadsheet-info' => array(
                        'sections' => array(
                            array(
                                'fields' => array(

                                    'enable_sync' => array(
                                        'id'    => 'enable_sync',
                                        'type'  => 'switch',
                                        'label' => __( 'Enable Google Sheets Sync', 'easycommerce' ),
                                        'desc'  => __( 'Sync new orders to Google Sheets.', 'easycommerce' ),
                                        'options' => array(
                                            'on'  => __( 'Enabled', 'easycommerce' ),
                                            'off' => __( 'Disabled', 'easycommerce' )
                                        ),
                                        'default' => 'off',
                                    ),
    
                                    // Text field for the spreadsheet_id
                                    'spreadsheet_id'     => array(
                                        'id'          => 'spreadsheet_id',
                                        'type'        => 'text',
                                        'label'       => __( 'Spreadsheet ID', 'easycommerce' ),
                                        'placeholder' => __( 'Enter your Google Spreadsheet ID', 'easycommerce' ),
                                    ),

                                    // Text field for the private-key
                                    'private-key'     => array(
                                        'id'          => 'private-key',
                                        'type'        => 'textarea',
                                        'label'       => __( 'Private Key', 'easycommerce' ),
                                        'placeholder' => __( 'Enter your Google Private Key', 'easycommerce' ),
                                    ),

                                    // Text field for the client-email
                                    'client-email'     => array(
                                        'id'          => 'client-email',
                                        'type'        => 'text',
                                        'label'       => __( 'Client Email', 'easycommerce' ),
                                        'placeholder' => __( 'Enter your Google Client Email', 'easycommerce' ),
                                    ),

                                    // Text field for the client-id
                                    'client-id'     => array(
                                        'id'          => 'client-id',
                                        'type'        => 'text',
                                        'label'       => __( 'Client ID', 'easycommerce' ),
                                        'placeholder' => __( 'Enter your Google Client ID', 'easycommerce' ),
                                    ),

                                     // Text field for the range-name
                                     'range-name'     => array(
                                        'id'          => 'range-name',
                                        'type'        => 'text',
                                        'label'       => __( 'Range Name', 'easycommerce' ),
                                        'placeholder' => __( 'Enter your Google Range Name', 'easycommerce' ),
                                    ),
                                )
                            )
                        )
                    )
                )  
                                
            );

        return $easycommerce_settings_menus;
    }
   
}

new Google_Sheets_Sync();


?>