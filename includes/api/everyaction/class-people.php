<?php

namespace PJ_EA_Sampler\Includes\API\EveryAction;

require_once PJ_EA_PLUGIN_PATH . 'includes/api/everyaction/class-api-calls.php';

use PJ_EA_Sampler\Includes\API\EveryAction\API_Calls as API_Calls;


class People
{

    const ENDPOINT = 'people';
    private $vanId;
    private $params = [];


    function __construct($vanId = null, $params= array())
    {
        if ($vanId) {
            $this->vanId = $vanId;
        }
        if($params){
            $this->params = $params;
        }
    }

    private function get_person_ea_by_van_id()
    {

        $person = API_Calls::get(self::ENDPOINT . '/' . $this->vanId);

        return $person;
    }
    private function get_people_ea()
    {

        $people = API_Calls::get(self::ENDPOINT, $this->params);

        return $people;
    }
    static function get_person($vanId)
    {
        $p = new People($vanId);


        return $p->get_person_ea_by_van_id();
    }
    static function get_people($params)
    {
        $p = new People(null, $params);

        return $p->get_people_ea();
    }
}
