<?php

namespace PJ_EA_Membership\Includes\Classes;

require_once PJ_EA_PLUGIN_PATH . 'includes/classes/class-people.php';
require_once PJ_EA_PLUGIN_PATH . 'includes/classes/class-person.php';

use PJ_EA_Membership\Includes\Classes\People as People;
use PJ_EA_Membership\Includes\Classes\Person as Person;

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
        wp_enqueue_style('pj-ea-sampler-front-end', PJ_EA_PLUGIN_URL . 'assets/css/public.css', array(), PJ_EA_VERSION, 'all');
    }


    public function enqueue_scripts()
    {
        wp_enqueue_script('pj-ea-sampler-front-end', PJ_EA_PLUGIN_URL . 'assets/js/front-end-min.js', array('jquery'), PJ_EA_VERSION, false);
        $params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('pj_ea_ajax_nonce'),
        );
        wp_localize_script('pj-ea-sampler-front-end', 'ajax_object', $params);
    }


    static function get_instance()
    {

        if (null == self::$instance) {

            self::$instance = new self;
        }

        return self::$instance;
    }
}
