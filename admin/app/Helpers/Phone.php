<?php
namespace App\Helper;



class Phone {

    public $country = '';
    public $area = '';
    public $prefix = '';
    public $number = '';
    public $ext = '';

    public function __construct($country='1', $area, $prefix, $number, $ext='')
    {
        $this->country = $country;
        $this->area = $area;
        $this->prefix = $prefix;
        $this->number = $number;
        $this->ext = $ext;
    }

    public function __toString()
    {
        return $this->country . $this->area . $this->prefix . $this->number . $this->ext;
    }

    public function format($format)
    {
        return str_replace('{country}', $this->country,
            str_replace('{area}', $this->area,
                str_replace('{prefix}', $this->prefix,
                    str_replace('{number}', $this->number,
                        str_replace('{ext}', $this->ext, $format)))));
    }
}