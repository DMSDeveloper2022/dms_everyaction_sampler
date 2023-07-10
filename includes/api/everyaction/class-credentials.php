<?php

namespace PJ_EA_Membership\Includes\API\EveryAction;

//class that handles the credentials for the EveryAction API credentials stored in the 2 ACF fields in the EveryAction Settings page, one for the API key and one for the API secret
class   Credentials
{
    private $environment;
    private $api_key;
    private $api_secret;

    function __construct()
    {
    }
    private function set_values()
    {

        if (function_exists('get_field')) {

            $this->environment = get_field('pj_ea_select_environment', 'option');

            $field_name = 'pj_ea_' . $this->environment . '_api';

            $this->set_key_values($field_name);
        }
    }
    private function set_key_values($field_name)
    {

        if (function_exists('have_rows')) {

            if (have_rows($field_name, 'option')) :

                while (have_rows($field_name, 'option')) : the_row();

                    $this->api_key = get_sub_field('api_key');
                    $this->api_secret = get_sub_field('api_secret');
                endwhile;
            endif;
        }
    }

    //private function that base64 encodes the API key and API secret and returns the encoded string
    private function encode_credentials()
    {
        $this->set_values();

        $credentials = $this->api_key . ':' . $this->api_secret;

        $encoded_credentials = base64_encode($credentials);

        return $encoded_credentials;
    }
    private function get_credentials()
    {
        $this->set_values();

        return $this->api_key . ':' . $this->api_secret;
    }
    //static function that returns the encoded credentials
    public static function get_encoded_credentials()
    {
        $credentials = new Credentials();


        return $credentials->encode_credentials();
    }
}
