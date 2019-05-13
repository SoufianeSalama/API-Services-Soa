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

    $('#modalRecordInfo').modal('show');
}

function btnmodalRecordDeviceParts(devicebrand, devicesn) {

    $('#modalRecordDevicePartsHeader').text("Onderdelenlijst: " + devicebrand  + " (" + devicesn + ")" );

    $('#modalRecordDeviceParts').modal('show');


    if (flag==0){
        flag = 1;
        var ApiURL = "/api/getDeviceParts/" + devicesn;
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
            $("#loader").style("display", "none");
            alert('Verbindings problemen met de server');
        });

    }
}
