<?php

namespace   PJ_EA_Membership\Includes\Classes;

require_once PJ_EA_PLUGIN_PATH . 'includes/api/everyaction/class-people.php';

use PJ_EA_Membership\Includes\API\EveryAction\People as PeopleAPI;

class Person
{
    // private static $instance = null;
    private $van_id;
    private $person;
    function __construct($van_id = null)
    {
        if ($van_id) {
            $this->van_id = $van_id;
        }
    }
    private function get_full_name()
    {
        if (!empty($this->person->middleName)) {
            return $this->person->firstName . ' ' . substr($this->person->middleName, 0, 1) . '. ' . $this->person->lastName;
        }
        return $this->person->firstName . ' ' . $this->person->lastName;
    }
    private function format_address()
    {
        $output = '';
        if ($this->person->addresses) {
            foreach ($this->person->addresses as $address) {
                $output = $address->addressLine1 . '<br>';
                $output .= $address->city . ', ' . $address->stateOrProvince . ' ' . $address->zipOrPostalCode;
            }
        }

        return $output;
    }
    private function format_email()
    {
        $output = '';
        if ($this->person->emails) {
            foreach ($this->person->emails as $email) {
                if ($email->isPreferred  == true) {
                    $output = '<a href="mailto:' . $email->email . '">' . $email->email . '</a><br>';
                }
            }
        }

        return $output;
    }
    private function format_phone()
    {
        $output = '';
        if ($this->person->phones) {
            foreach ($this->person->phones as $phone) {

                if ($phone->isPreferred) {
                    $output = $phone->phoneNumber;
                    if ($phone->ext) {
                        $output .= ' ' . $phone->ext;
                    }
                }
            }
        }

        return $output;
    }
    private function format_directory_card()
    {

        $output = '<div class="pj-ea-sampler-container">';
        $output .= '<div class="pj-ea-sampler-card">';
        $output .= '<div class="pj-ea-sampler-card__header">';
        $output .= '<div class="pj-ea-sampler-card__header__name"><h4>';
        $output .= $this->get_full_name();
        $output .= '</h4></div>';
        $output .= '</div>';
        $output .= '<div class="pj-ea-sampler-card__body">';

        $output .= '<div class="pj-ea-sampler-card__body__address">';
        $output .= $this->format_address();
        $output .= '</div>';

        $output .= '<div class="pj-ea-sampler-card__body__phone">';
        $output .= $this->format_phone();
        $output .= '</div>';
        $output .= '<div class="pj-ea-sampler-card__body__email">';
        $output .= $this->format_email();
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
    static function add_shortcodes()
    {
        add_shortcode(PJ_EA_PREFIX . 'person_card', [__CLASS__, 'get_card_from_shortcode']);
    }
    private function set_from_ea()
    {

        $this->person = PeopleAPI::get_person($this->van_id);
    }
    private function set_person($person)
    {
        $this->person = $person;
    }
    static function get_card_from_shortcode($atts)
    {
        extract(shortcode_atts(array(
            'van_id' => '',
        ), $atts));

        $output = '<div class="pj-ea-sampler-container">';
        if (!empty($van_id)) {

            $person = static::get_card_from_van_id($van_id);
            $output .= $person;
        } else {
            $output .= __('Person not found');
        }
        $output .= '</div">';
        return $output;
    }
    static function get_card_from_van_id($van_id)
    {
        $p = new static($van_id);
        $p->set_from_ea();

        return $p->format_directory_card();
    }
    static function get_card_from_person($person)
    {
        $p = new static();
        $p->set_person($person);

        return $p->format_directory_card();
    }
}
