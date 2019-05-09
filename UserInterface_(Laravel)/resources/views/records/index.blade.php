@extends('layouts.master')
@section('title', 'Records Overview')
@section('inhoud')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Dossiers</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <button type="button" class="btn btn-sm btn-primary btn-create btn-showform"  data-toggle="modal" data-target="#modalNewRecord">Nieuw dossier</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-striped custab" id="recordsTable">
                            <thead>
                            <tr>
                                <th>SORD</th>
                                <th>Merk toestel</th>
                                <th>SN toestel</th>
                                <th>Klacht</th>
                                <th>Klant</th>
                                <th>Status</th>
                                <th>Opties</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($aRecords as $r)
                                <tr>
                                    <td> {{$r->sSord}} </td>
                                    <td>NOG TOEVOEGEN</td>
                                    <td> {{$r->sDevicesn}} </td>
                                    <td> {{$r->sComplaint}} </td>
                                    <td> {{$r->sClientinfo}} </td>
                                    <td> {{$r->sStatusDescription}} </td>
                                    <td>
                                        <button type="button" id="btnModalRecordInfo" class="btn btn-sm btn-primary btn-create btn-showform"
                                                onclick="btnModalRecordInfo(
                                                {{$r->sSord}},
                                                'Merk nog Toevoegen aan DB',
                                                '{{$r->sDevicesn}}',
                                                '{{$r->sComplaint}}',
                                                '{{$r->sClientinfo}}',
                                                {{$r->iStatuskey}},
                                                '{{$r->sDiagnose}}'
                                                )">
                                            Meer info
                                        </button>
                                    </td>

                                    <td>
                                        <button type="button" id="btnmodalRecordDeviceParts" class="btn btn-sm btn-primary btn-create btn-showform"
                                                onclick="btnmodalRecordDeviceParts(
                                                    'Merk nog Toevoegen aan DB',
                                                    '{{$r->sDevicesn}}'
                                                )">
                                            Meer info
                                        </button>
                                    </td>

                                </tr>
                             @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal: Record Meer info/wijzigen -->
    <div id="modalRecordInfo" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modelRecordInfoHeader"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="text">Merk Toestel:</label>
                            <input type="text" class="form-control" id="frmRecordDeviceBrand">
                        </div>
                        <div class="form-group">
                            <label for="text">SN Toestel:</label>
                            <input type="text" class="form-control" id="frmRecordDeviceSN">
                        </div>
                        <div class="form-group">
                            <label for="frmRecordComplaint">Klacht:</label>
                            <textarea class="form-control" id="frmRecordComplaint"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="frmRecordClientInfo">Klant info:</label>
                            <textarea class="form-control" id="frmRecordClientInfo"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="frmRecordDiagnose">Diagnose:</label>
                            <textarea class="form-control" id="frmRecordDiagnose"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="email">Status:</label>
                            <select class="form-control" id="frmRecordStatus">
                                <option value="1">Toestel moet opgehaald worden bij de klant.</option>
                                <option value="2">Toestel staat klaar voor controle.</option>
                                <option value="3">Toestel is gecontroleerd, wachten op onderdeel.</option>
                                <option value="4">Toestel is hersteld, moet verstuurd worden naar klant.</option>
                                <option value="5">Status onbekend.</option>
                            </select>
                        </div>


                        </div>

                        <!--<div class="col-sm-6 col-md-6 col-lg-6">
                            <h4>Toestel onderdelen</h4>
                        </div>-->

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal: Toestel onderdelen opvragen -->
    <div id="modalRecordDeviceParts" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modalRecordDevicePartsHeader"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="loader"></div>

                        <div class="table-responsive">
                            <table class="table table-striped custab" id="devicePartsTable">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>SN</th>
                                    <th>Prijs</th>
                                    <th>Beschikbaarheid</th>
                                </tr>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@stop
