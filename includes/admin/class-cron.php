<?php

namespace PJ_Membership_Directory\Includes\Admin;

include_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/import/class-import.php';

use    PJ_MEM_DIR_Membership\Includes\Import\Import;

class Cron_Jobs
{
    private static $instance = null;
    public function __construct()
    {
    }

    public function create_sync_members()
    {
        if (!wp_next_scheduled('pj_MEM_DIR_membership_sync_members')) {
            wp_schedule_event(time(), 'hourly', 'pj_MEM_DIR_membership_sync_members');
        }
    }
    public function sync_members()
    {
        Import::import_members();
    }
    public function delete_sync_members()
    {
        wp_clear_scheduled_hook('pj_MEM_DIR_membership_sync_members');
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
