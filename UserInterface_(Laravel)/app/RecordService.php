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
            $oRecord->sClientinfo = $aR->clientinfo ;
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
}
