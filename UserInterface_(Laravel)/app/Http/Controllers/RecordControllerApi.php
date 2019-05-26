<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecordService;


class RecordControllerApi extends Controller
{
    /*
    **
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $oRecordService = new RecordService();
        $aData = $oRecordService->getRecords();
        echo json_encode($aData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
