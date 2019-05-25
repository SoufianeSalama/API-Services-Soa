var flag = 0;

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
    $('#frmRecordSord').val(sord);


    $('#modalRecordInfo').modal('show');
}

function btnmodalRecordDeviceParts(devicebrand, devicesn) {

    $('#modalRecordDevicePartsHeader').text("Onderdelenlijst: " + devicebrand  + " (" + devicesn + ")" );

    $('#modalRecordDeviceParts').modal('show');


    if (flag==0){
        flag = 1;
        var ApiURL = "/api/deviceParts/" + devicesn;
        $.get(ApiURL, function(data, status){
            var parts = jQuery.parseJSON(data);
            $("#loader").css("display", "none");
            parts.forEach(function (part) {

                $('#devicePartsTable').append('<tr> ' +
                    '<td>' + part["description"] + '</td>' +
                    '<td>' + part["serialnumber"] + '</td>' +
                    '<td> €' + part["price"] + '</td>' +
                    '<td>' + part["availability"] + '</td>' +
                    '</tr>')
            })

        }).fail(function() {
            $("#loader").css("display", "none");
            alert('Verbindings problemen met de server');
        });

    }
}

function btnActivateForm() {
    // Remove 'readonly' attribute of some inputs
    /*frmRecordDeviceBrand
    frmRecordDeviceSN
    frmRecordComplaint
    frmRecordClientInfo
    frmRecordDiagnose
    frmRecordStatus*/

    $("#btnFormOpslaan").css("display", "block");
    $("#frmRecordDiagnose").attr("readonly", false);
    $("#frmRecordStatus").attr("readonly", false);
}

function btnSendForm(){
    var sord = $("#frmRecordSord").val();
    var diagnose  = $("#frmRecordDiagnose").val();
    var recordstatus  = $("#frmRecordStatus").val();
    var ApiURL = "/api/records/" + sord;

    sendData = {
        "frmRecordDiagnose": diagnose,
        "frmRecordStatuskey": recordstatus
    };
    $.ajax({
        url: ApiURL,
        type: 'PUT',
        data:  sendData,
        success: function () {
            alert("data succesfull updated");
        }
    });
}
