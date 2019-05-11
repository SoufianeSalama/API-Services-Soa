<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SOAP\PartsOfDevice;
use Artisaninweb\SoapWrapper\SoapWrapper;

class DevicePartsControllerApi extends Controller
{
    /*
    **
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sDeviceSN)
    {
        $oSoapWrapper = new SoapWrapper();
        $oSoapWrapper->add('DevicesPartsService', function ($oService){
           $oService
                ->wsdl('http://localhost:50442/SoapWebService.asmx?WSDL')
                ->trace(true)
                ->classmap([
                    PartsOfDevice::class
                ]);
        });

        $oResponse = $oSoapWrapper->call('DevicesPartsService.PartsOfDevice',
            [
                new PartsOfDevice($sDeviceSN)
            ]);

        print_r($oResponse);
        //$aPartList = $oResponse->
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
       //

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

