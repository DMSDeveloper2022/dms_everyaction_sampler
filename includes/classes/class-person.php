<?php

namespace   PJ_Membership_Directory\Includes\Classes;

require_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/api/everyaction/class-people.php';

use PJ_Membership_Directory\Includes\API\EveryAction\People as PeopleAPI;

class Person
{
    // private static $instance = null;
    private $van_id;
    private $person;
    private $membership;
    function __construct($van_id = null)
    {
        if ($van_id) {
            $this->van_id = $van_id;
        }
    }
    private function get_codes()
    {
        $codes = [];
        if ($this->person->codes) {
            foreach ($this->person->codes as $code) {
                $codes[] = $code->name;
            }
        }

        if ($codes) {
            return implode(', ', $codes);
        }
        return '';
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
                if ($address->isPreferred  == true) {
                    $output .= $address->addressLine1 . '<br>';
                    $output .= $address->city . ', ' . $address->stateOrProvince . ' ' . $address->zipOrPostalCode;
                }
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
                    $output = Utilities::format_phone_us($phone->phoneNumber);
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

        $output = '<div class="pj-ea-member-container">';
        $output .= '<div class="pj-ea-member-card">';
        $output .= '<div class="pj-ea-member-card__header">';
        $output .= '<div class="pj-ea-member-card__header__name"><h4>';
        $output .= $this->get_full_name();
        $output .= '</h4></div>';

        //comment out ar run time
        $output .= '<div class="pj-ea-member-card__header__vanid">';
        $output .= $this->van_id;
        $output .= '</div>';

        $output .= '<div class="pj-ea-member-card__header_codes">';
        $output .= $this->get_codes();
        $output .= '</div>';
        //end comment out
        $output .= '</div>';


        $output .= '<div class="pj-ea-member-card__body">';

        $output .= '<div class="pj-ea-member-card__body__address">';
        $output .= $this->format_address();
        $output .= '</div>';

        $output .= '<div class="pj-ea-member-card__body__phone">';
        $output .= $this->format_phone();
        $output .= '</div>';
        $output .= '<div class="pj-ea-member-card__body__email">';
        $output .= $this->format_email();
        $output .= '</div>';
        //comment out ar run time
        $output .= '<div class="pj-ea-member-card__header_codes">';
        $output .= $this->get_codes();
        $output .= '</div>';
        //end comment out
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';


        return $output;
    }
    static function add_shortcodes()
    {
        add_shortcode(PJ_MEM_DIR_PREFIX . 'person_card', [__CLASS__, 'get_card_from_shortcode']);
    }
    private function set_from_ea()
    {
        $params = [];
        $params['$expand'] = 'phones,emails,addresses,codes';
        $this->person = PeopleAPI::get_person($this->van_id, $params);
    }
    private function set_membership_from_ea()
    {

        $this->membership = PeopleAPI::get_membership($this->van_id);
    }
    private function set_person($person)
    {
        $this->van_id = $person->vanId;
        $this->person = $person;
    }
    static function get_card_from_shortcode($atts)
    {
        extract(shortcode_atts(array(
            'van_id' => '',
        ), $atts));

        $output = '<div class="pj-ea-card-container">';
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

        $p->set_membership_from_ea();


        return $p->format_directory_card();
    }
    // static function get_card_from_person($person)
    // {
    //     $p = new static();
    //     $p->set_person($person);

    //     return $p->format_directory_card();
    // }
}
