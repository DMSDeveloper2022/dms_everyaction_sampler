<?php

namespace DMS_EA_Sampler\Includes\Admin;

class Admin
{
    public function __construct()
    {
    }

    public function enqueue_styles()
    {
        wp_enqueue_style('dms-ea-sampler-admin', DMS_EA_PLUGIN_URL . 'assets/css/dms-ea-sampler-admin.css', array(), DMS_EA_VERSION, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('dms-ea-sampler-admin', DMS_EA_PLUGIN_URL . 'assets/js/dms-ea-sampler-admin.js', array('jquery'), DMS_EA_VERSION, false);
    }
}
