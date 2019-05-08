<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordService extends Model
{
    protected $sBaseUrl = "http://127.0.0.1:5000/api/";

    public function getRecords(){
        $sUrl = $this->sBaseUrl . "all";
        $aRecords = $this->getDataWithCurl();


        return $aRecords;
    }


    private function getDataWithCurl($sUrl, $aAuthData){
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
