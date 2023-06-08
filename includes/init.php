<?php

namespace DMS_EA_Sampler\Includes;

if (!defined('ABSPATH')) {
    exit;
}

class Init
{
    public function __construct()
    {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies()
    {
        require_once DMS_EA_PLUGIN_PATH . 'includes/class-admin.php';
        require_once DMS_EA_PLUGIN_PATH . 'includes/class-front-end.php';
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
}
