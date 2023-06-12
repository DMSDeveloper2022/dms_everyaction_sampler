<?php

namespace PJ_EA_Membership\Includes\Admin;

class Cron_Jobs
{
    private static $instance = null;
    public function __construct()
    {
        // add_action('pj_ea_membership_sync_members', array($this, 'sync_members'));
    }
    public function create_sync_members()
    {
        if (!wp_next_scheduled('pj_ea_membership_sync_members')) {
            wp_schedule_event(time(), 'hourly', 'pj_ea_membership_sync_members');
        }
    }
    public function sync_members()
    {
        //  $people = new \PJ_EA_Membership\Includes\Classes\People();
        //  $people->sync_members();
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
