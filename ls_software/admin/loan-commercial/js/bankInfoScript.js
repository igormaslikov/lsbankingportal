var table;
var clear = false;
var users = null;
var selectedUser = null;
$(document).ready(function () {

    // Setup - add a text input to each footer cell
    $.fn.dataTable.ext.buttons.deleteUsers = {
        className: 'buttons-delete btn-danger',

        action: function (e, dt, node, config) {
            var count = table.rows({ selected: true }).count();
            showDeletePopup();
        }
    };

    $.fn.dataTable.ext.buttons.addUsers = {
        className: 'buttons-add btn-primary',


        action: function (e, dt, node, config) {
            //var count = table.rows({ selected: true }).count();
            editBankRow("");
        }
    };


    table = $('#tbl_bank_info').DataTable({
        orderCellsTop: true,
         fixedHeader: true,
         pagingType: 'full_numbers',
        deferRender: true,
         autoWidth: true,
         info: true,
        saveState: true,
        keys: true,
         responsive: true,
         select:{
             bluerable: true
    
        },
         
        // scrollX: true,
        searchPanes: {

        },
        dom:"<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12'p>>" +
            "<'row'<'col-lg-3'l><'col-lg-6 text-center'B><'col-lg-3'f>>" +
            "<'row'<'col-lg-12'tr>>" +
            "<'row'<'col-lg-3'i>>",
        buttons: [
            {
                extend: 'addUsers', text: "<i class='fa fa-plus'></i>Add New"
            }
        ],
        language: {
            buttons: {
                selectAll: "Select all users",
                selectNone: "Select none"
            }
        },
        columnDefs: [
            {
                targets: 'no-sort',
                orderable: false,
            },
            { 
                targets: [5],
                data: null,
                defaultContent: "<div style='display:flex;justify-content:space-between; align-items:center'><div><i id='editBtn' class='fa fa-pencil-square' style='color:orange'></i></div>"+
                                "<div><i id='removeBtn' class='fa fa-trash' style='color:red'></i></div></div>"          
            }
        ],
    });

    $('#tbl_bank_info tbody').on('click', 'i#removeBtn', function () {
        showDeletePopup();

    });

    $('#tbl_bank_info tbody').on('click', 'i#editBtn', function () {
        var data = table.row($(this).parents('tr')).data();
        editBankRow(data[0]);
    });

    //$('#container').css('display', 'block');
    table.columns.adjust().draw();
});


function checkInput() {
    Init();
    var valid = true;
    if (document.getElementById("lblBankName").value == '') {
        document.getElementById("lblBankName").style.borderColor = "red";
        valid = false;
    }

    if (document.getElementById("lblAccountNumber").value == '') {
        document.getElementById("lblAccountNumber").style.borderColor = "red";
        valid = false;
    }
    if (document.getElementById("lblRoutingNumber").value == '') {
        document.getElementById("lblRoutingNumber").style.borderColor = "red";
        valid = false;
    }
    return valid;
}

function updateBankInfo() {

    if (!checkInput()) {
        document.getElementById("lblError").innerHTML = "Please enter valid data!!";
        document.getElementById("error_row").hidden = false;
        return;
    }

    var url = 'functions_commercial_loan.php';
    // projectName = "SPVL"
    
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            'func':"UpdateBankInfo",
            'userId':document.getElementById("idUserId").getAttribute("value"),
            'bankInfoId':document.getElementById("lblBankInfoId").value,
            'bankName': document.getElementById("lblBankName").value,
            'accountNumber': document.getElementById("lblAccountNumber").value,
            'routingNumber': document.getElementById("lblRoutingNumber").value,
            'status': document.getElementById("idisActiveBankInfo").checked,
            'newBankInfo': document.getElementById("newBankInfo").innerText
        },
        async: false,
        success: function (data) {
            
            if (data[0].status != "ok") {
                alert(data[0].message);
            }

            //alert(data[0].message);
            window.location.reload(); 
        },
        error: function (err) {
            if (err.responseText == "") {
                alert(err.responseText);
            }
            else {
                alert(err.responseText);
            }
            window.location.reload();
        }
    });
    
}

function Init() {
    document.getElementById("lblBankName").style.removeProperty("border");
    document.getElementById("lblAccountNumber").style.removeProperty("border");
    document.getElementById("lblRoutingNumber").style.removeProperty("border");
    document.getElementById("error_row").hidden = true;
}

function editBankRow(bankId) {
    Init();
    
    document.getElementById('btnInsertUpdateBankInfo').innerText = 'Add';
    document.getElementById("type_alert_title").innerText = "Add new bank info";
    document.getElementById("lblBankInfoId").value = "";
    document.getElementById("lblBankName").value = "";
    document.getElementById("lblAccountNumber").value = "";
    document.getElementById("lblRoutingNumber").value = "";
    document.getElementById("idisActiveBankInfo").checked = true;
    document.getElementById("newBankInfo").innerText = "true";
    bankInfo = table.data()
    for (var i = 0; i < bankInfo.length; i++) {
        if (bankId == bankInfo[i][0]) {
            document.getElementById('btnInsertUpdateBankInfo').innerText = 'Update';
            document.getElementById("type_alert_title").innerText = "Edit bank info: " + bankInfo[i][1] +" "+ bankInfo[i][2]+ " "+ bankInfo[i][3];
            document.getElementById("lblBankInfoId").value = bankInfo[i][0];
            document.getElementById("lblBankName").value = bankInfo[i][1];
            document.getElementById("lblAccountNumber").value = bankInfo[i][2];
            document.getElementById("lblRoutingNumber").value = bankInfo[i][3];
            var isActive = bankInfo[i][4] == "Active";
            document.getElementById("idisActiveBankInfo").checked = isActive;
            document.getElementById("newBankInfo").innerText = "false";
        }
    }

    bankInfoModal.show();
 

}



