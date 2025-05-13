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

use EasyCommerce\API\Order;
require_once __DIR__ . '/vendor/autoload.php';

class Google_Sheets_Sync {

    public function __construct() {
        add_filter( 'easycommerce_settings_menus', array( $this, 'add_settings_menu' ) );
        add_action('easycommerce_after_order', [ $this, 'sync_order_info' ], 10, 1 );
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

    public function sync_order_info( $order_id ) {
        
        $enable_sync = get_option('enable_sync');
    
        if ($enable_sync !== 'on') {
            return;
        }
    
        $spreadsheet_id = get_option('spreadsheet_id');
        $range_name     = get_option('range-name');
        $private_key    = str_replace("\\n", "\n", get_option('private-key'));
        // $private_key    = get_option('private-key');
        $client_email   = get_option('client-email');
    
        // Get order details
        $order = new Order($order_id);
        $order_data = [
            $order->get_id(),
            $order->get_customer_name(),
            $order->get_total(),
            $order->get_status(),
            date('Y-m-d H:i:s')
        ];
    
        // Send data to Google Sheets
        $this->send_to_google_sheets($spreadsheet_id, $range_name, $order_data, $private_key, $client_email);
    }

    private function send_to_google_sheets( $spreadsheet_id, $range_name, $values, $private_key, $client_email ) {
        try {
            $client = new \Google_Client();
            $client->setApplicationName('EasyCommerce Sheets Sync');
            $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
            $client->setAuthConfig([
                'type' => 'service_account',
                'client_email' => $client_email,
                'private_key' => $private_key,
            ]);
            $service = new \Google_Service_Sheets($client);
        
            $body = new \Google_Service_Sheets_ValueRange([
                'values' => [ $values ]
            ]);
        
            $params = ['valueInputOption' => 'RAW'];
            $service->spreadsheets_values->append($spreadsheet_id, $range_name, $body, $params);
        }catch (Exception $e) {
            error_log('Google Sheets Sync Error: ' . $e->getMessage());
        }
        
    }
  
}

new Google_Sheets_Sync();


?>