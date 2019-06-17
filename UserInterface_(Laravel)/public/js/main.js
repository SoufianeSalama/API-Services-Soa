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



    var ApiURL =  localStorage.getItem('API_URL')  + "/deviceParts/" + devicesn;
    /*$.get(ApiURL, function(data, status){
        var parts = jQuery.parseJSON(data);
        $("#loader").css("display", "none");
        parts.forEach(function (part) {

            $("#devicePartsTable tr").remove();
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
    */

    $.ajax({
        url: ApiURL,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            var parts = jQuery.parseJSON(data);
            $("#loader").css("display", "none");
            $("#devicePartsTable tr").remove();
            parts.forEach(function (part) {
                $('#devicePartsTable').append('<tr> ' +
                    '<td>' + part["description"] + '</td>' +
                    '<td>' + part["serialnumber"] + '</td>' +
                    '<td> €' + part["price"] + '</td>' +
                    '<td>' + part["availability"] + '</td>' +
                    '</tr>')

            })
        }
    });


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

    var ApiURL =  localStorage.getItem('API_URL')  + "/updateRecord/" + sord;

    sendData = {
        "frmRecordDiagnose": diagnose,
        "frmRecordStatuskey": recordstatus
    };
    $.ajax({
        url: ApiURL,
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:  sendData,
        success: function () {
            alert("Record succesvol aangepast");
        }
    });
}

function btnSendNewRecordForm(){
    var brand  = $("#frmNewRecordDeviceBrand").val();
    var devicesn  = $("#frmNewRecordDeviceSN").val();
    var complaint  = $("#frmNewRecordComplaint").val();
    var clientinfo  = $("#frmNewRecordClientInfo").val();
    var clientaddress  = $("#frmNewRecordClientAddress").val();
    var statuskey  = $("#frmNewRecordStatus").val();

    var ApiURL =  localStorage.getItem('API_URL')  + "/newRecord";


    sendData = {
        "frmNewRecordDeviceBrand": brand,
        "frmNewRecordDeviceSN" : devicesn,
        "frmNewRecordComplaint" : complaint,
        "frmNewRecordClientInfo": clientinfo,
        "frmNewRecordClientAddress": clientaddress,
        "frmNewRecordStatus" : statuskey
    };
    $.ajax({
        url: ApiURL,
        type: 'POST',
        data:  sendData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {
            alert("Record succesvol toegevoegd");
            $('#modalNewRecord').modal('hide');
        },
        error: function(){
            alert('Verbindingsproblemen met server \nProbeer later opnieuw');
        }
    });
}

function searchInputFunction() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("recordsTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
