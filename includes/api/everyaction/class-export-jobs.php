<?php

namespace PJ_EA_Membership\Includes\API\EveryAction;

require_once PJ_EA_PLUGIN_PATH . 'includes/api/import/class-webhooks.php';

use PJ_EA_Membership\Includes\Import\Webhooks as Webhooks;

class Export_Jobs
{

    /*{
  "surveyQuestions": null,
  "activistCodes": null,
  "customFields": null,
  "districtFields": null,
  "canvassFileRequestId": 9196,
  "exportJobId": 9196,
  "canvassFileRequestGuid": "8aec985e-8766-5651-4508-f959cb06ec52",
  "exportJobGuid": "8aec985e-8766-5651-4508-f959cb06ec52",
  "savedListId": 511547,
  "webhookUrl": "https://webhook.example.org/completedExportJobs",
  "downloadUrl": "https://ngpvan.blob.core.windows.net:443/canvass-files-savedlistexport/8aec985e-8766-5651-4508-f959cb06ec52_1_2023-06-21T15:28:02.5779748-04:00.csv",
  "status": "Completed",
  "type": 4,
  "dateExpired": "2023-06-21T22:28:02.7909919Z",
  "errorCode": null
}
    */
    const ENDPOINT = 'exportJobs';

    private $active_members_saved_list_id;

    private $environment;

    private $webhook_url;

    function __construct($which = 'members')
    {

        if ($which == 'members') {

            $this->webhook_url = Webhooks::ACTIVE_MEMBERS_WEBHOOK;
        } else {
        }


        $this->set_environment();

        $this->export_active_users();
    }
    function set_environment()
    {
        if (function_exists('get_field')) {

            $this->environment = get_field('pj_ea_select_environment', 'option');

            $field_name = 'pj_ea_' . $this->environment . '_api';

            $this->set_values($field_name);
        }
    }
    private function export_active_users()
    {

        $params = [
            'savedListId' => $this->active_members_saved_list_id,
            'type' => '4',
            'webhookUrl' => $this->webhook_url
        ];

        $export_jobs = API_Calls::post(self::ENDPOINT, $params);

        return $export_jobs;
    }

    private function set_values($field_name)
    {

        if (function_exists('have_rows')) {

            if (have_rows($field_name, 'option')) :

                while (have_rows($field_name, 'option')) : the_row();

                    $this->folder_id = get_sub_field('member_folder');

                    $this->active_members_saved_list_id = get_sub_field('active_members_saved_list_id');

                    $this->lapsed_members_saved_list_id = get_sub_field('lapsed_members_saved_list_id');

                endwhile;
            endif;
        }
    }
}
