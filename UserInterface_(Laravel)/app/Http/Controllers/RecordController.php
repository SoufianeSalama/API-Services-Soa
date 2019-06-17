<?php

namespace App\Http\Controllers;

use App\Record;
use App\RecordService;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //return view('records.index')->with('items', Record::all());
        $oRecordService = new RecordService();

        $aData = $oRecordService->getRecords();
        return view('records.index')->with('aRecords', $aData);
    }

}
