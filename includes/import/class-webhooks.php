<?php

namespace PJ_Membership_Directory\Includes\Import;

require_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/import/class-reconciliation-table.php';

use   PJ_MEM_DIR_Membership\Includes\Import\Reconciliation_Table as Reconciliation_Table;

require_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/import/class-updates-table.php';

use   PJ_MEM_DIR_Membership\Includes\Import\Update_Contacts_Table as Update_Contacts_Table;


class Webhooks
{
    const ACTIVE_MEMBERS_WEBHOOK = 'ea-webhook-active-members';
    const UPDATED_MEMBERS_WEBHOOK = 'ea-webhook-updated-members';

    function __construct()
    {
    }

    private static function register_MEM_DIR_webhook_endpoint()
    {
        add_rewrite_endpoint(static::ACTIVE_MEMBERS_WEBHOOK, EP_ROOT);

        add_rewrite_endpoint(static::UPDATED_MEMBERS_WEBHOOK, EP_ROOT);
    }
    private static function handle_MEM_DIR_webhook_endpoint()
    {
        if (isset($_GET[static::ACTIVE_MEMBERS_WEBHOOK])) {
            static::handle_MEM_DIR_active_webhook();
        }
        if (isset($_GET[static::UPDATED_MEMBERS_WEBHOOK])) {
            static::handle_MEM_DIR_updated_webhook();
        }
    }

    static function handle_MEM_DIR_active_webhook()
    {


        // Retrieve the payload sent by ea
        $payload = file_get_contents('php://input');

        // Parse the JSON payload into an associative array
        $data = json_decode($payload, true);

        //insert the data  into the reconciliation table 
        Reconciliation_Table::insert($data);

        // Send a response to ea (if required)
        http_response_code(200); // Set an appropriate HTTP response code
        echo 'Webhook received successfully';
        exit;
    }
    static function handle_MEM_DIR_updated_webhook()
    {


        // Retrieve the payload sent by ea
        $payload = file_get_contents('php://input');

        // Parse the JSON payload into an associative array
        $data = json_decode($payload, true);

        $downloadUrl = $data['downloadUrl'];

        $csv = file_get_contents($downloadUrl);

        //insert the data  into the reconciliation table 
        Update_Contacts_Table::insert($csv);

        // Send a response to ea (if required)
        http_response_code(200); // Set an appropriate HTTP response code
        echo 'Webhook received successfully';
        exit;
    }

    static function init()
    {

        add_action('init', [__CLASS__, 'register_MEM_DIR_webhook_endpoint']);
        add_action('parse_request', [__CLASS__, 'handle_MEM_DIR_webhook_endpoint']);
    }
}
