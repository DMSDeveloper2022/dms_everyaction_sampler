<?php

namespace PJ_EA_Membership\Includes\Admin;

class Admin
{
    private static $instance = null;
    public function __construct()
    {
        require_once PJ_EA_PLUGIN_PATH . 'includes/admin/class-cron-jobs.php';
    }

    public function enqueue_styles()
    {
        wp_enqueue_style('dms-ea-sampler-admin', PJ_EA_PLUGIN_URL . 'assets/css/dms-ea-sampler-admin.css', array(), PJ_EA_VERSION, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('dms-ea-sampler-admin', PJ_EA_PLUGIN_URL . 'assets/js/dms-ea-sampler-admin.js', array('jquery'), PJ_EA_VERSION, false);
    }
    static function get_instance()
    {

        if (null == self::$instance) {

            self::$instance = new self;
        }

        return self::$instance;
    }
}
namespace\Admin::get_instance();
