<?php

namespace DMS_EA_Sampler\Includes\Classes;

require_once DMS_EA_PLUGIN_PATH . 'includes/classes/class-people.php';
require_once DMS_EA_PLUGIN_PATH . 'includes/classes/class-person.php';

use DMS_EA_Sampler\Includes\Classes\People as People;
use DMS_EA_Sampler\Includes\Classes\Person as Person;

class FrontEnd
{
    private static $instance = null;
    public function __construct()
    {
        Person::add_shortcodes();
        People::add_shortcodes();
    }


    public function enqueue_styles()
    {
        wp_enqueue_style('dms-ea-sampler-front-end', DMS_EA_PLUGIN_URL . 'assets/css/front-end.css', array(), DMS_EA_VERSION, 'all');
    }


    public function enqueue_scripts()
    {
        wp_enqueue_script('dms-ea-sampler-front-end', DMS_EA_PLUGIN_URL . 'assets/js/front-end.js', array('jquery'), DMS_EA_VERSION, false);
    }


    static function get_instance()
    {

        if (null == self::$instance) {

            self::$instance = new self;
        }

        return self::$instance;
    }
}
