var otherFeeModal = null;
var deleteMod = null;
var table_fees;
$(document).ready(function () {
  deleteMod = new bootstrap.Modal(document.getElementById('deleteModal'), {
    keyboard: false
  });

  otherFeeModal = new bootstrap.Modal(
    document.getElementById("type_alert_fee"),
    {
      keyboard: false,
    }
  );

  $.fn.dataTable.ext.buttons.addFee = {
    className: "buttons-add btn-primary",

    action: function (e, dt, node, config) {
      //var count = table.rows({ selected: true }).count();
      editOtherFee("");
    },
  };

  table_fees = $("#tblOtherFeesId").DataTable({
    orderCellsTop: true,
    fixedHeader: true,
    pagingType: "full_numbers",
    deferRender: true,
    autoWidth: true,
    info: true,
    saveState: true,
    keys: true,
    responsive: true,
    pageLength: 3,
    lengthMenu: [1, 3, 5, 10],
    select: {
      bluerable: true,
    },
    dom:
      "<'row justify-content-between'<'col-lg-4'l><'col-lg-8 d-flex justify-content-end'B>>" +
      "<'row'<'col-lg-12'tr>>" +
      "<'row'<'col-lg-3'i><'col-lg-9'p>>",
    buttons: [
      {
        extend: "addFee",
        text: "<i class='fa fa-plus'></i>Add Fee",
      },
    ],
    language: {
      buttons: {
        selectAll: "Select all users",
        selectNone: "Select none",
      },
    },
    columnDefs: [
      {
        targets: "no-sort",
        orderable: false,
      },
      {
        targets: [5],
        data: null,
        // defaultContent:
        //   "<div style='display:flex;justify-content:space-between; align-items:center'><div><i id='editBtn' class='fa fa-pencil-square' style='color:orange; cursor:pointer'></i></div>" +
        //   "<div><i id='removeBtn' class='fa fa-trash' style='color:red;cursor:pointer'></i></div></div>",
        render: function (data, type, full, meta){
            var btnData = "<div style='display:flex;justify-content:space-between; align-items:center'><div><i id='editBtn' class='fa fa-pencil-square' style='color:orange; cursor:pointer'></i></div>";
            if(data[4] == 0 ){
              btnData += "<div><i id='removeBtn' class='fa fa-trash' style='color:red;cursor:pointer'></i></div></div>";
            }
            return btnData;
        }
      },
    ],
  });

  $("#tblOtherFeesId tbody").on("click", "i#removeBtn", function () {
     showDeletePopup();
  });

  $("#tblOtherFeesId tbody").on("click", "i#editBtn", function () {
    var data = table_fees.row($(this).parents("tr")).data();
    editOtherFee(data[0]);
  });

  table_fees.columns.adjust().draw();
});


function showDeletePopup() {
 
  var title = document.getElementById("deleteTitle");
  document.getElementById("idInformation").value = "fees";
  var info = "Delete permanently other fee";

  title.innerText = info;
  title.innerHTML = info;
  document.getElementById("chkDel").checked = false;
  document.getElementById("btnDel").disabled = true;
  deleteMod.show();
  
}

function showDeleteBtn() {
  if (document.getElementById("chkDel").checked) {

      document.getElementById("btnDel").disabled = false;
  }
  else {
      document.getElementById("btnDel").disabled = true;
  }
}


function deleteFee() {
  let result = null;
  let amount = 0;
  table_fees.rows({ selected: true }).every(function (rowIdx, tableLoop, rowLoop) {
      var data = this.data();
      amount = data[2];
      result = removeItem(data[0]);
  });

  if(result[0]){
    var elem_unpaid_other_fee = document.getElementById("other_fees_unpaid");
    var amount_unpaid = elem_unpaid_other_fee.value.replace("$","") - amount;
    elem_unpaid_other_fee.value = "$" + amount_unpaid;
    
    table_fees.rows({ selected: true }).remove();
    table_fees.draw(false);
  }
  
//not reloading page
  alert(result[1]);
  deleteMod.hide();
  
}


function removeItem(idItem) {
  var url = 'functions_commercial_loan.php';
  let result = null;
  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: {
          'func': "DeleteOtherFee",
          'itemId':idItem
      },
      async: false,
      success: function(response){
          result = [true, response[0].message];
          if(response[0].status != "ok"){
              result = [false, response[0].message];
          }
          
      },
      error: function (err) {
          result = [false, err.responseText];
      }
  });

  return result;
}



function checkInput() {
  InitOtherFee();
  var valid = true;
  if (document.getElementById("lblAmountFee").value == "") {
    document.getElementById("lblAmountFee").style.borderColor = "red";
    valid = false;
  }

  if (document.getElementById("lblTypeOfDescription").value == "") {
    document.getElementById("lblTypeOfDescription").style.borderColor = "red";
    valid = false;
  }

  return valid;
}

function InitOtherFee() {
  document.getElementById("lblAmountFee").style.removeProperty("border");
  document
    .getElementById("lblTypeOfDescription")
    .style.removeProperty("border");
  document.getElementById("error_row").hidden = true;
}

function updateOtherFee(event) {
  if (!checkInput()) {
    document.getElementById("lblError").innerHTML = "Please enter valid data!!";
    document.getElementById("error_row").hidden = false;
    return;
  }

  var otherFeeId = document.getElementById("lblOtherFeeId").value;
  var description = document.getElementById("lblTypeOfDescription").value;
  var number_installment = document.getElementById("lblNumberInstallment").value;
  var amountFee = document.getElementById("lblAmountFee").value;
  var newOtherFee = document.getElementById("newOtherFee").innerText;
  otherFeeModal.hide();
  var url = "functions_commercial_loan.php";
  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: {
      func: "UpdateOtherFee",
      userId: document.getElementById("userId").innerText,
      loanId: document.getElementById("loanId").innerText,
      otherFeeId: otherFeeId,
      description: description,
      amountFee: amountFee,
      number_installment: number_installment,
      newOtherFee: newOtherFee,
    },
    async: true,
    success: function (data) {
      window.location.reload();
    },
    error: function (err) {
      if (err.responseText == "") {
        alert(err.responseText);
      } else {
        alert(err.responseText);
      }
      window.location.reload();
    },
  });
}

function editOtherFee(otherFeeId) {
  InitOtherFee();

  document.getElementById("btnInsertUpdateOtherFee").innerText = "Add";
  document.getElementById("type_alert_fee_title").innerText =
    "Add new other fee";
  document.getElementById("lblOtherFeeId").value = "";
  document.getElementById("lblAmountFee").value = "";
  document.getElementById("lblTypeOfDescription").value = "";
  document.getElementById("lblNumberInstallment").value = "";
  document.getElementById("newOtherFee").innerText = "true";

  let otherFee = table_fees.data();
  for (var i = 0; i < otherFee.length; i++) {
    if (otherFeeId == otherFee[i][0]) {
      document.getElementById("btnInsertUpdateOtherFee").innerText = "Update";
      document.getElementById("type_alert_fee_title").innerText =
        "Edit other fee";
      document.getElementById("lblOtherFeeId").value = otherFee[i][0];
      document.getElementById("lblAmountFee").value = otherFee[i][3];
      document.getElementById("lblTypeOfDescription").value = otherFee[i][2];
      document.getElementById("lblNumberInstallment").value = otherFee[i][1];

      document.getElementById("newOtherFee").innerText = "false";
    }
  }
  otherFeeModal.show();
}
