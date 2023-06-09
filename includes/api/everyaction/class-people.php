<?php

namespace DMS_EA_Sampler\Includes\API\EveryAction;

require_once DMS_EA_PLUGIN_PATH . 'includes/api/everyaction/class-api-calls.php';

use DMS_EA_Sampler\Includes\API\EveryAction\API_Calls as API_Calls;


class People
{

    const ENDPOINT = 'people';
    private $vanId;
    private $params;

    function __construct($vanId = null)
    {
        if ($vanId) {
            $this->vanId = $vanId;
            $this->params = [];
        }
    }

    private function get_person_ea($expand = true)
    {
        if ($expand) {
            array_push($this->params, '$expand=phones,emails,addresses');
            $person = API_Calls::get(self::ENDPOINT . '/' . $this->vanId, $this->params);
        } else {
            $person = API_Calls::get(self::ENDPOINT . '/' . $this->vanId);
        }


        return $person;
    }
    private function get_people_ea()
    {

        $people = API_Calls::get(self::ENDPOINT, $this->params);



        return $people;
    }
    static function get_person($vanId, $expand = true)
    {
        $p = new People($vanId);

        if ($expand) {
            $p->params = ['$expand' => 'phones,emails,addresses'];
        }

        return $p->get_person_ea();
    }
    static function get_people($params, $expand = true)
    {
        $p = new People();
        $p->params = $params;
        if ($expand) {
            array_push($p->params, '$expand=phones,emails,addresses');
        }

        return $p->get_people_ea();
    }
}
