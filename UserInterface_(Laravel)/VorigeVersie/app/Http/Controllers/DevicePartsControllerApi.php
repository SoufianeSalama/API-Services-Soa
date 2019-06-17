<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SOAP\PartsOfDevice;
use Artisaninweb\SoapWrapper\SoapWrapper;

class DevicePartsControllerApi extends Controller
{
    protected $sBaseUrlAWS = "http://soacloud-soapwebservice.us-east-1.elasticbeanstalk.com/SoapWebService.asmx?WSDL";
    protected $sBaseUrlLocal = "http://localhost:.../SoapWebService.asmx?WSDL";
    /**
     * De onderdelen van een toestel ophalen via SOAP
     *
     * @param  int  $sDeviceSN
     * @return \Illuminate\Http\Response
     */
    public function show($sDeviceSN)
    {
        $oSoapWrapper = new SoapWrapper();
        $oSoapWrapper->add('DevicesPartsService', function ($oService){
           $oService
                ->wsdl($this->sBaseUrlAWS)
                ->trace(true)
                ->classmap([
                    PartsOfDevice::class
                ]);
        });

        $oResponse = $oSoapWrapper->call('DevicesPartsService.PartsOfDevice',
            [
                new PartsOfDevice($sDeviceSN)
            ]);

        $aParts = ($oResponse->PartsOfDeviceResult->DevicePart);

        echo json_encode($aParts);

    }

}

