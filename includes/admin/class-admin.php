<?php

namespace PJ_Membership_Directory\Includes\Admin;

class Admin
{
    private static $instance = null;
    public function __construct()
    {
        require_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/admin/class-cron.php';
    }

    public function enqueue_styles()
    {
        wp_enqueue_style('pj-ea-sampler-admin', PJ_MEM_DIR_PLUGIN_URL . 'assets/css/pj-ea-sampler-admin.css', array(), PJ_MEM_DIR_VERSION, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('pj-ea-sampler-admin', PJ_MEM_DIR_PLUGIN_URL . 'assets/js/pj-ea-sampler-admin.js', array('jquery'), PJ_MEM_DIR_VERSION, false);
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
