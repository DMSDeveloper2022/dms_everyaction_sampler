<?php

namespace DMS_EA_Sampler\Includes;

class FrontEnd
{
    public function __construct()
    {
    }

    public function enqueue_styles()
    {
        wp_enqueue_style('dms-ea-sampler-front-end', DMS_EA_PLUGIN_URL . 'assets/css/front-end.css', array(), DMS_EA_VERSION, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('dms-ea-sampler-front-end', DMS_EA_PLUGIN_URL . 'assets/js/front-end.js', array('jquery'), DMS_EA_VERSION, false);
    }
}
