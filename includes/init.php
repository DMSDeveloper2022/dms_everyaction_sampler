<?php

namespace PJ_EA_Membership\Includes;

use PJ_EA_Membership\Includes\Admin\Admin as Admin;
use PJ_EA_Membership\Includes\Classes\FrontEnd as FrontEnd;

if (!defined('ABSPATH')) {
    exit;
}

class Init
{
    private static $instance = null;

    public function __construct()
    {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies()
    {

        include_once PJ_EA_PLUGIN_PATH . 'includes/admin/dependencies.php';
        include_once PJ_EA_PLUGIN_PATH . 'includes/classes/dependencies.php';
    }

    private function define_admin_hooks()
    {
        $plugin_admin = new Admin();
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts'));
    }

    private function define_public_hooks()
    {
        $plugin_public = new FrontEnd();
        add_action('wp_enqueue_scripts', array($plugin_public, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($plugin_public, 'enqueue_scripts'));
    }
    public static function get_instance()
    {

        if (null == self::$instance) {

            self::$instance = new self;
        }

        return self::$instance;
    }
}
namespace\Init::get_instance();
