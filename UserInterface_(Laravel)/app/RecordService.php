<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordService extends Model
{
    protected $sBaseUrl = "http://127.0.0.1:5000/api/";

    public function getRecords(){
        $sUrl = $this->sBaseUrl . "records";
        $aRecords = json_decode($this->getDataWithCurl($sUrl));
        $oRecordList = [];
        foreach ($aRecords as $aR){
            $oRecord = new Record();
            $oRecord->sSord = $aR->sord;
            $oRecord->sDevicesn = $aR->devicesn;
            $oRecord->sBrand = $aR->brand;
            $oRecord->sClientinfo = $aR->clientinfo ;
            $oRecord->sClientaddress= $aR->clientaddress ;
            $oRecord->sComplaint = $aR->complaint;
            $oRecord->sDiagnose = $aR->diagnose;
            $oRecord->iStatuskey = $aR->statuskey;
            switch ($aR->statuskey){
                case 1:
                    $oRecord->sStatusDescription = "Toestel moet opgehaald worden bij de klant.";
                    break;
                case 2:
                    $oRecord->sStatusDescription = "Toestel staat klaar voor controle.";
                    break;
                case 3:
                    $oRecord->sStatusDescription = "Toestel is gecontroleerd, wachten op onderdeel.";
                    break;
                case 4:
                    $oRecord->sStatusDescription = "Toestel is hersteld, moet verstuurd worden naar klant.";
                    break;
                default:
                    $oRecord->sStatusDescription = "Status onbekend.";
                    break;

            }
            $oRecord->iUserid = $aR->userid;
            array_push($oRecordList, $oRecord);
        }
        return $oRecordList;
    }


    public function updateRecord($iId, $aFormData){
        $sUrl = $this->sBaseUrl . "records/" . $iId;
        echo $sUrl;
        //$sUrl = "https://soufiane.free.beeceptor.com";
        $this->postDataWithCurl($sUrl, $aFormData);
    }


    private function getDataWithCurl($sUrl){
        $curl = curl_init($sUrl);
        /*$curl_post_data =a$aAuthData;*/
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_POST, true);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json'
        ));

        curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, 20);

        $curl_response = curl_exec($curl);
        curl_close($curl);

        // Controleer op errors van curl (http code)

        return $curl_response;
    }

    private function postDataWithCurl($sUrl, $aPostData){
        $curl = curl_init($sUrl);
        $curl_post_data = $aPostData;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_PUT, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        /*curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json'
        ));*/

        $curl_response = curl_exec($curl);
        // Controleer op errors van curl (http code)

        // also get the error and response code
        //$errors = curl_error($curl);
        $response = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        //var_dump($errors);
        var_dump($response);

        return $curl_response;
    }
}
