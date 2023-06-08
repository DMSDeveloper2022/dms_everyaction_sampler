<?php

namespace DMS_EA_Sampler\Vendor;

class ACF
{
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
}
