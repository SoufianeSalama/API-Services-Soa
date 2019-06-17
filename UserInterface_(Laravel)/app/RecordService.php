<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordService extends Model
{
    protected $sBaseUrlAWS = "http://soacloud-restwebservice.us-east-1.elasticbeanstalk.com/api/";
    protected $sBaseUrlLocal = "http://soacloud-restwebservice.us-east-1.elasticbeanstalk.com/api/";

    public function getRecords(){
        $sUrl = $this->sBaseUrlLocal . "records";
        $aRecords = json_decode($this->getDataWithCurl($sUrl));
        $oRecordList = [];
        if (!empty($aRecords)){

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
        }

        return $oRecordList;
    }
    public function getRouteRecords(){
        $sUrl = $this->sBaseUrlLocal . "records";
        $aRecords = json_decode($this->getDataWithCurl($sUrl));
        $oRecordList = [];
        if (!empty($aRecords)){

            foreach ($aRecords as $aR) {
                if ($aR->statuskey == 1 or $aR->statuskey == 4){
                    $oRecord = new Record();
                    $oRecord->sSord = $aR->sord;
                    $oRecord->sDevicesn = $aR->devicesn;
                    $oRecord->sBrand = $aR->brand;
                    $oRecord->sClientinfo = $aR->clientinfo;
                    $oRecord->sClientaddress = $aR->clientaddress;
                    $oRecord->sComplaint = $aR->complaint;
                    $oRecord->sDiagnose = $aR->diagnose;
                    $oRecord->iStatuskey = $aR->statuskey;
                    switch ($aR->statuskey) {
                        case 1:
                            $oRecord->sStatusDescription = "Toestel moet opgehaald worden bij de klant.";
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
            }
        }

        return $oRecordList;
    }


    public function getRecord($iId){
        $sUrl = $this->sBaseUrlLocal . "records/" . $iId;
        $aRecords = json_decode($this->getDataWithCurl($sUrl));
        $oRecordList = [];
        if (!empty($aRecords)){

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
        }

        return $oRecordList;
    }

    public function updateRecord($iId, $aFormData){
        $sUrl = $this->sBaseUrlLocal . "records/" . $iId;
        //echo $sUrl;
        print_r($aFormData);
        //$sUrl = "https://soufiane.free.beeceptor.com";
        if ($this->putDataWithCurl($sUrl, $aFormData) != 200){
            // als de curl operatie geen HTTP code 200 krijgt is er iets misgelopen
            return false;
        };
        return true;
    }

    public function newRecord($aFormData){
        $sUrl = $this->sBaseUrlLocal . "records";
        if ($this->postDataWithCurl($sUrl, $aFormData) != 200){
            // als de curl operatie geen HTTP code 200 krijgt is er iets misgelopen
            return false;
        };
        return true;
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

    private function putDataWithCurl($sUrl, $aPostData){
        $curl = curl_init($sUrl);
        //$curl = curl_init("salama.free.beeceptor.com");
        $curl_post_data = $aPostData;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($curl_post_data));

        $curl_response = curl_exec($curl);
        // Controleer op errors van curl (http code)

        // also get the error and response code
        //$errors = curl_error($curl);
        $response = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        //print_r($errors);
        //print_r($response);

        return $response;
    }

    private function postDataWithCurl($sUrl, $aPostData){
        $curl = curl_init($sUrl);
        //$curl = curl_init("salama.free.beeceptor.com");
        $curl_post_data = $aPostData;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($curl_post_data));

        $curl_response = curl_exec($curl);
        // Controleer op errors van curl (http code)

        // also get the error and response code
        //$errors = curl_error($curl);
        $response = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        //print_r($errors);
        print_r($response);

        return $response;
    }

}
