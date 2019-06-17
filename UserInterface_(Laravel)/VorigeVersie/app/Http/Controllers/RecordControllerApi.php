<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecordService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RecordControllerApi extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }


    public function getAllRecords()
    {
        $oRecordService = new RecordService();
        $aData = $oRecordService->getRecords();
        echo json_encode($aData);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newRecord(Request $request)
    {
        $aFormData = array(
            "diagnose"  => "/",
            "statuskey" => $request->input('frmNewRecordStatus'),
            "brand"     => $request->input('frmNewRecordDeviceBrand'),
            "devicesn"  => $request->input('frmNewRecordDeviceSN'),
            "complaint" => $request->input('frmNewRecordComplaint'),
            "clientinfo"    => $request->input('frmNewRecordClientInfo'),
            "clientaddress" => $request->input('frmNewRecordClientAddress'),
            "userid" => 1
        );

        $oRecordService = new RecordService();
        $bResult = $oRecordService->newRecord($aFormData);

        if ($bResult)
            return "ok";
        else
            return "nok";
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRecord(Request $request, $id)
    {
        $aFormData = array(
            "diagnose" => $request->input('frmRecordDiagnose'),
            "statuskey" => $request->input('frmRecordStatuskey')
        );
        $oRecordService = new RecordService();
        $bResult = $oRecordService->updateRecord($id, $aFormData);

        if ($bResult)
            return "ok";
        else
            return "nok";
    }

}
