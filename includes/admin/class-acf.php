<?php

namespace PJ_EA_Sampler\Includes\Admin;

class ACF
{
    private static $instance = null;
    public function __construct()
    {
    }
    //a function that creates an ACF option page
    public function create_acf_options_page()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => 'EveryAction Settings',
                'menu_title' => 'EveryAction Settings',
                'menu_slug' => 'everyaction-settings',
                'capability' => 'manage_options',
                'redirect' => false
            ));
        }
    }
    public static function get_instance()
    {

        if (null == self::$instance) {

            self::$instance = new self;
        }

        return self::$instance;
    }
}
namespace\ACF::get_instance()->create_acf_options_page();
