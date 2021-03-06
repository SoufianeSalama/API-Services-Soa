@extends('layouts.master')
@section('title', 'Records Overview')
@section('inhoud')
    <script>
        var API_URL = '{{ env('APP_URL') }}';
        localStorage.setItem('API_URL', API_URL);
    </script>
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
                    <div class="form-group">
                        <input type="text" id="searchInput" class="form-control" onkeyup="searchInputFunction()" placeholder="Zoek naar dossiers...">
                    </div>

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
                                    <td> {{$r->sBrand}} </td>
                                    <td> {{$r->sDevicesn}} </td>
                                    <td> {{$r->sComplaint}} </td>
                                    <td> {{$r->sClientinfo}} </td>
                                    <td> {{$r->sStatusDescription}} </td>
                                    <td>
                                        <button type="button" id="btnModalRecordInfo" class="btn btn-sm btn-primary btn-create btn-showform"
                                                onclick="btnModalRecordInfo(
                                                {{$r->sSord}},
                                                '{{$r->sBrand}}',
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
                                                    '{{$r->sBrand}}',
                                                    '{{$r->sDevicesn}}'
                                                )">
                                            Onderdelen
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
                        <input type="hidden" class="form-control" id="frmRecordSord">

                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="text">Merk Toestel:</label>
                                <input type="text" class="form-control" id="frmRecordDeviceBrand" readonly>
                            </div>
                            <div class="form-group">
                                <label for="text">SN Toestel:</label>
                                <input type="text" class="form-control" id="frmRecordDeviceSN" readonly>
                            </div>
                            <div class="form-group">
                                <label for="frmRecordComplaint">Klacht:</label>
                                <textarea class="form-control" id="frmRecordComplaint" readonly></textarea>
                            </div>

                            <div class="form-group">
                                <label for="frmRecordClientInfo">Klant info:</label>
                                <textarea class="form-control" id="frmRecordClientInfo" readonly></textarea>
                            </div>

                            <div class="form-group">
                                <label for="frmRecordDiagnose">Diagnose:</label>
                                <textarea class="form-control" id="frmRecordDiagnose" readonly></textarea>
                            </div>

                            <div class="form-group">
                                <label for="email">Status:</label>
                                <select class="form-control" id="frmRecordStatus" readonly>
                                    <option value="1">Toestel moet opgehaald worden bij de klant.</option>
                                    <option value="2">Toestel staat klaar voor controle.</option>
                                    <option value="3">Toestel is gecontroleerd, wachten op onderdeel.</option>
                                    <option value="4">Toestel is hersteld, moet verstuurd worden naar klant.</option>
                                    <option value="5">Status onbekend.</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                                <button type="button" class="btn btn-lg btn-basic btn-block" onclick="btnActivateForm()" >Wijzigen</button>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6" id="btnFormOpslaan" style="display: none;">
                            <div class="form-group">
                                <button type="button" class="btn btn-lg btn-success btn-block"onclick="btnSendForm()">Opslaan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal: Nieuws Record -->
    <div id="modalNewRecord" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Nieuw dossier toevoegen</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="frmRecordSord">

                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="text">Merk Toestel:</label>
                                <input type="text" class="form-control" id="frmNewRecordDeviceBrand" required>
                            </div>
                            <div class="form-group">
                                <label for="text">SN Toestel:</label>
                                <input type="text" class="form-control" id="frmNewRecordDeviceSN" required>
                            </div>
                            <div class="form-group">
                                <label for="frmRecordComplaint">Klacht:</label>
                                <textarea class="form-control" id="frmNewRecordComplaint" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="frmRecordClientInfo">Klant info:</label>
                                <textarea class="form-control" id="frmNewRecordClientInfo" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="frmRecordClientInfo">Klant adres (Coordinaten):</label>
                                <input type="text" class="form-control" id="frmNewRecordClientAddress" required placeholder="lat,lon">
                            </div>

                            <div class="form-group">
                                <label for="email">Status:</label>
                                <select class="form-control" id="frmNewRecordStatus" required>
                                    <option value="1" selected>Toestel moet opgehaald worden bij de klant.</option>
                                    <option value="2">Toestel staat klaar voor controle.</option>
                                    <option value="5">Status onbekend.</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12" >
                            <div class="form-group">
                                <button type="button" class="btn btn-lg btn-success btn-block"onclick="btnSendNewRecordForm()">Opslaan</button>
                            </div>
                        </div>
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

                        <div class="loader" id="loader" style="margin: auto;"></div>

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
