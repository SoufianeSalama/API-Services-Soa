<?php

namespace App\SOAP;


class PartsOfDevice{

    /**
     * @var double
     */
    protected $deviceSN;

    public function __construct($sDeviceSN){
        $this->deviceSN = $sDeviceSN;
    }

    public function getInch(){
        return $this->deviceSN;

    }
}