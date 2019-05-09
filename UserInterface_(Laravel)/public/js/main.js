$(document).ready(function(){



});


function btnModalRecordInfo(sord, devicebrand, devicesn, complaint, clientinfo, statuskey, diagnose){

    $('#modelRecordInfoHeader').text("Dossier Info: SORD " + sord);

    $('#frmRecordDeviceBrand').val(devicebrand);
    $('#frmRecordDeviceSN').val(devicesn);
    $('#frmRecordComplaint').val(complaint);
    $('#frmRecordClientInfo').val(clientinfo);
    $('#frmRecordDiagnose').val(diagnose);
    $('#frmRecordStatus').val(statuskey);

    $('#modalRecordInfo').modal('show');
}