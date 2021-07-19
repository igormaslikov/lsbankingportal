var tableCardInfo;
var clear = false;
var users = null;
var selectedUser = null;
$(document).ready(function () {

    // Setup - add a text input to each footer cell
    $.fn.dataTable.ext.buttons.deleteUsers = {
        className: 'buttons-delete btn-danger',

        action: function (e, dt, node, config) {
            var count = tableCardInfo.rows({ selected: true }).count();
            showDeletePopup();
        }
    };

    $.fn.dataTable.ext.buttons.addUsers = {
        className: 'buttons-add btn-primary',


        action: function (e, dt, node, config) {
            //var count = table.rows({ selected: true }).count();
            editRowCard("")
        }
    };


    tableCardInfo = $('#tbl_card_info').DataTable({
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
                targets: [6],
                data: null,
                defaultContent: "<div style='display:flex;justify-content:space-between; align-items:center'><div><i id='editBtnCard' class='fa fa-pencil-square' style='color:orange'></i></div>"+
                                "<div><i id='removeBtnCard' class='fa fa-trash' style='color:red'></i></div></div>"          
            }
        ],
    });

    $('#tbl_card_info tbody').on('click', 'i#removeBtnCard', function () {
        showDeletePopup();

        //var data = table.row($(this).parents('tr')).data();
        //removeUser(event, data["WWID"], data["UserName"])
        //table.row($(this).parents('tr')).remove();
       //table.draw(false);
    });

    $('#tbl_card_info tbody').on('click', 'i#editBtnCard', function () {
        var data = tableCardInfo.row($(this).parents('tr')).data();
        editRowCard(data[0]);
    });

    //table.on('responsive-resize', function (e, datatable, columns) {
    //    columns.reduce(function (a, b, index) {
    //        var displayCol = b === false ? "none" : "";
    //        document.getElementById("filter" + index).style.display = displayCol;
    //    }, 0)
    //});

    //$('#container').css('display', 'block');
    tableCardInfo.columns.adjust().draw();
});


function checkCardInput() {
    Init();
    var valid = true;
    if (document.getElementById("lblTypeOfCard").value == '') {
        document.getElementById("lblTypeOfCard").style.borderColor = "red";
        valid = false;
    }

    if (document.getElementById("lblCardNumber").value == '') {
        document.getElementById("lblCardNumber").style.borderColor = "red";
        valid = false;
    }
    if (document.getElementById("lblMonth").value == '') {
        document.getElementById("lblMonth").style.borderColor = "red";
        valid = false;
    }
    if (document.getElementById("lblYear").value == '') {
        document.getElementById("lblYear").style.borderColor = "red";
        valid = false;
    }
    if (document.getElementById("lblCVV").value == '' || document.getElementById("lblCVV").value.length != 3) {
        document.getElementById("lblCVV").style.borderColor = "red";
        valid = false;
    }
    return valid;
}

function updateCardInfo() {

    if (!checkCardInput()) {
        document.getElementById("lblError").innerHTML = "Please enter valid data!!";
        document.getElementById("error_row_card").hidden = false;
        return;
    }

    cardInfoModal.hide();

    var url = 'functions_commercial_loan.php';
    // projectName = "SPVL"
    
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            'func':"UpdateCardInfo",
            'userId':document.getElementById("idUserId").getAttribute("value"),
            'cardInfoId':document.getElementById("lblCardInfoId").value,
            'typeOfCard': document.getElementById("lblTypeOfCard").value,
            'cardNumber': document.getElementById("lblCardNumber").value,
            'expirationDate': document.getElementById("lblMonth").value+"/"+document.getElementById("lblYear").value,
            'cvv': document.getElementById("lblCVV").value,
            'status': document.getElementById("idisActiveCardInfo").checked,
            'newCardInfo': document.getElementById("newCardInfo").innerText
        },
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
    document.getElementById("lblTypeOfCard").style.removeProperty("border");
    document.getElementById("lblCardNumber").style.removeProperty("border");
    document.getElementById("lblMonth").style.removeProperty("border");
    document.getElementById("lblYear").style.removeProperty("border");
    document.getElementById("lblCVV").style.removeProperty("border");
    document.getElementById("error_row_card").hidden = true;
}

function editRowCard(cardId) {
    Init();
    
    document.getElementById('btnInsertUpdateCardInfo').innerText = 'Add';
    document.getElementById("type_alert_title_card").innerText = "Add new card info";
    document.getElementById("lblCardInfoId").value = "";
    document.getElementById("lblTypeOfCard").value = "";
    document.getElementById("lblCardNumber").value = "";
    document.getElementById("lblMonth").value = "";
    document.getElementById("lblYear").value = "";
    document.getElementById("lblCVV").value = "";
    document.getElementById("idisActiveCardInfo").checked = true;
    document.getElementById("newCardInfo").innerText = "true";
    cardInfo = tableCardInfo.data()
    for (var i = 0; i < cardInfo.length; i++) {
        if (cardId == cardInfo[i][0]) {
            document.getElementById('btnInsertUpdateCardInfo').innerText = 'Update';
            document.getElementById("type_alert_title_card").innerText = "Edit card info: " + cardInfo[i][1] +" "+ cardInfo[i][2]+ " "+ cardInfo[i][3] + " " + cardInfo[i][4];
            document.getElementById("lblCardInfoId").value = cardInfo[i][0];
            document.getElementById("lblTypeOfCard").value = cardInfo[i][1];
            document.getElementById("lblCardNumber").value = cardInfo[i][2];
            var exp_date = cardInfo[i][3].split("/");
            document.getElementById("lblMonth").value = exp_date[0];
            document.getElementById("lblYear").value = exp_date[1];
            document.getElementById("lblCVV").value = cardInfo[i][4];
            var isActive = cardInfo[i][5] == "Active";
            document.getElementById("idisActiveCardInfo").checked = isActive;
            document.getElementById("newCardInfo").innerText = "false";
        }
    }
    cardInfoModal.show();

}



