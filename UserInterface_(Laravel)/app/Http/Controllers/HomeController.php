<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecordService;
use Artisaninweb\SoapWrapper\SoapWrapper;
use App\SOAP\PartsOfDevice;

class HomeController extends Controller
{
    protected $sBaseUrlAWS = "http://soacloud-soapwebservice.us-east-1.elasticbeanstalk.com/SoapWebService.asmx?WSDL";
    protected $sBaseUrlLocal = "http://localhost:.../SoapWebService.asmx?WSDL";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $oRecordService = new RecordService();
        $aData = $oRecordService->getRecords();

        return view('dashboard.records.index')->with('aRecords', $aData);
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

    public function deviceParts($id){
        $sDeviceSN=$id;
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

    public function allRecords(){
        // Alle records met status 1 (Ophalen) en 4 (leveren
        $oRecordService = new RecordService();
        $aData = $oRecordService->getRouteRecords();
        echo json_encode($aData);
    }
}
