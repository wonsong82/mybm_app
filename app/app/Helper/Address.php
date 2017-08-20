<?php
namespace App\Helper;



class Address {

    const SHORT = 'address_short';
    const LONG = 'address_long';
    const ASSOC = 'address_assoc';
    const ASSOCR = 'address_assoc_reverse';
    
    public $street = '';
    public $city = '';
    public $state = '';
    public $zip = '';
    

    private static $_states = [
        'AL'=>'Alabama',
        'AK'=>'Alaska',
        'AZ'=>'Arizona',
        'AR'=>'Arkansas',
        'CA'=>'California',
        'CO'=>'Colorado',
        'CT'=>'Connecticut',
        'DE'=>'Delaware',
        'DC'=>'District of Columbia',
        'FL'=>'Florida',
        'GA'=>'Georgia',
        'HI'=>'Hawaii',
        'ID'=>'Idaho',
        'IL'=>'Illinois',
        'IN'=>'Indiana',
        'IA'=>'Iowa',
        'KS'=>'Kansas',
        'KY'=>'Kentucky',
        'LA'=>'Louisiana',
        'ME'=>'Maine',
        'MD'=>'Maryland',
        'MA'=>'Massachusetts',
        'MI'=>'Michigan',
        'MN'=>'Minnesota',
        'MS'=>'Mississippi',
        'MO'=>'Missouri',
        'MT'=>'Montana',
        'NE'=>'Nebraska',
        'NV'=>'Nevada',
        'NH'=>'New Hampshire',
        'NJ'=>'New Jersey',
        'NM'=>'New Mexico',
        'NY'=>'New York',
        'NC'=>'North Carolina',
        'ND'=>'North Dakota',
        'OH'=>'Ohio',
        'OK'=>'Oklahoma',
        'OR'=>'Oregon',
        'PA'=>'Pennsylvania',
        'RI'=>'Rhode Island',
        'SC'=>'South Carolina',
        'SD'=>'South Dakota',
        'TN'=>'Tennessee',
        'TX'=>'Texas',
        'UT'=>'Utah',
        'VT'=>'Vermont',
        'VA'=>'Virginia',
        'WA'=>'Washington',
        'WV'=>'West Virginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming',
    ];

    private static $_canada_provinces = [
        'AB'=>'Alberta',
        'BC'=>'British Columbia',
        'MB'=>'Manitoba',
        'NB'=>'New Brunswick',
        'NL'=>'Newfoundland and Labrador',
        'NS'=>'Nova Scotia',
        'ON'=>'Ontario',
        'PE'=>'Prince Edward Island',
        'QC'=>'Quebec',
        'SK'=>'Saskatchewan'
    ];



    public static function states($type = self::SHORT)
    {
        if($type == self::ASSOC){
            return self::$_states;
        }

        else if($type == self::ASSOCR){
            $arr = [];
            foreach(self::$_states as $key => $value){
                $arr[$value] = $key;
            }
            return $arr;

        }

        else if($type == self::SHORT){
            return array_keys(self::$_states);
        }

        else if($type == self::LONG){
            return array_values(self::$_states);
        }
    }

    public static function canadaProvinces($type = self::SHORT)
    {
        if($type == self::ASSOC){
            return self::$_canada_provinces;
        }

        else if($type == self::ASSOCR){
            $arr = [];
            foreach(self::$_canada_provinces as $key => $value){
                $arr[$value] = $key;
            }
            return $arr;

        }

        else if($type == self::SHORT){
            return array_keys(self::$_canada_provinces);
        }

        else if($type == self::LONG){
            return array_values(self::$_canada_provinces);
        }
    }



    public function __construct($street, $city, $state, $zip)
    {
        $this->state = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    public function __toString()
    {
        return "{$this->street}, {$this->city}, {$this->state} {$this->zip}";
    }

    public function format($format)
    {
        return
            str_replace('{street}', $this->street,
                str_replace('{city}', $this->city,
                    str_replace('{state}', $this->state,
                        str_replace('{zip}', $this->zip, $format))));
    }
    
    




}