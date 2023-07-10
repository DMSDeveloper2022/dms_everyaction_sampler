<?php

namespace PJ_EA_Membership\Includes\Admin;

include_once PJ_EA_PLUGIN_PATH . 'includes/import/class-import.php';

use    PJ_EA_Membership\Includes\Import\Import;

class Cron_Jobs
{
    private static $instance = null;
    public function __construct()
    {
    }

    public function create_sync_members()
    {
        if (!wp_next_scheduled('pj_ea_membership_sync_members')) {
            wp_schedule_event(time(), 'hourly', 'pj_ea_membership_sync_members');
        }
    }
    public function sync_members()
    {
        Import::import_members();
    }
    public function delete_sync_members()
    {
        wp_clear_scheduled_hook('pj_ea_membership_sync_members');
    }
    public static function get_instance()
    {

        if (null == self::$instance) {

            self::$instance = new self;
        }

        return self::$instance;
    }
}
namespace\Cron_Jobs::get_instance();
