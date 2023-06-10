<?php

namespace DMS_EA_Sampler\Includes\API\EveryAction;

require_once DMS_EA_PLUGIN_PATH . 'includes/api/everyaction/class-api-calls.php';

use DMS_EA_Sampler\Includes\API\EveryAction\API_Calls as API_Calls;


class People
{

    const ENDPOINT = 'people';
    private $vanId;
    private $params = [];


    function __construct($vanId = null, $expand = true)
    {
        if ($vanId) {
            $this->vanId = $vanId;
        }
        if ($expand) {
            $this->params[] = ['$expand' => 'phones,emails,addresses'];
        }
    }

    private function get_person_ea($expand = true)
    {

        $person = API_Calls::get(self::ENDPOINT . '/' . $this->vanId);

        return $person;
    }
    private function get_people_ea()
    {

        $people = API_Calls::get(self::ENDPOINT, $this->params);

        return $people;
    }
    static function get_person($vanId, $expand = true)
    {
        $p = new People($vanId, $expand);


        return $p->get_person_ea();
    }
    static function get_people($params, $expand = true)
    {
        $p = new People(null, $expand);
        $p->params = $params;


        return $p->get_people_ea();
    }
}
