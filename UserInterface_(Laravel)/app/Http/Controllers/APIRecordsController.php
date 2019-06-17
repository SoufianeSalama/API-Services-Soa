<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecordService;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
class APIRecordsController extends Controller
{

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }


    public function allRecords(){
        $oRecordService = new RecordService();
        $aData = $oRecordService->getRecords();
        echo json_encode($aData);
    }
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