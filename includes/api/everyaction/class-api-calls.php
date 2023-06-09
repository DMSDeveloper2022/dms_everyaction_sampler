<?php

namespace   DMS_EA_Sampler\Includes\API\EveryAction;

require_once DMS_EA_PLUGIN_PATH . 'includes/api/everyaction/class-credentials.php';

use DMS_EA_Sampler\Includes\API\EveryAction\Credentials as Credentials;

//class that handles communication with the EveryAction API
class   API_Calls
{

    const   API_URL = 'https://api.securevan.com/v4/';
    private $encoded_credentials;

    function __construct()
    {
        $this->encoded_credentials = Credentials::get_encoded_credentials();
    }

    //private function that makes the API call and returns the response
    private function make_api_call($endpoint, $method, $body = null)
    {
        require_once DMS_EA_PLUGIN_PATH . '/vendor/autoload.php';

        $client = new \GuzzleHttp\Client();

        $response = $client->request($method, API_Calls::API_URL . $endpoint, [
            'body' => $body,
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . $this->encoded_credentials,
                'content-type' => 'application/json',
            ],
        ]);

        return $response->getBody();
    }
    private function decode_json($json)
    {
        if ($json == false) {
            return false;
        }
        return json_decode($json);
    }
    static function get($endpoint, $params = null, $output = 'object')
    {
        $api_calls = new API_Calls();

        if ($params) {
            $endpoint .= '?' . http_build_query($params);
        }
        $response = $api_calls->make_api_call($endpoint, 'GET');

        return $output == 'json' ? $response : $api_calls->decode_json($response);
    }
    static function post($endpoint, $body = null)
    {
        $api_calls = new API_Calls();

        $response =  $api_calls->make_api_call($endpoint, 'POST', $body, $output = 'object');

        return $output == 'json' ? $response : $api_calls->decode_json($response);
    }
    static function delete($endpoint)
    {
        $api_calls = new API_Calls();

        return $api_calls->make_api_call($endpoint, 'DELETE');
    }
    static function put($endpoint, $body = null, $output = 'object')
    {
        $api_calls = new API_Calls();

        return $api_calls->make_api_call($endpoint, 'PUT', $body);
    }
}
//RUFERU0uMDAwMDAxLjMzODpiNjUzYjgwZi0zY2M4LTAxNTAtODcyMi0yNmIxM2FhMmQ5OGR8MQ==