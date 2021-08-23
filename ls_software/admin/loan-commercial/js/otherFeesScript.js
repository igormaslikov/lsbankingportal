var otherFeeModal = null;
var table_fees;
$(document).ready(function () {
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
    processing: true,
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
        targets: [4],
        data: null,
        defaultContent:
          "<div style='display:flex;justify-content:space-between; align-items:center'><div><i id='editBtn' class='fa fa-pencil-square' style='color:orange; cursor:pointer'></i></div>" +
          "<div><i id='removeBtn' class='fa fa-trash' style='color:red;cursor:pointer'></i></div></div>",
      },
    ],
  });

  $("#tblOtherFeesId tbody").on("click", "i#removeBtn", function () {
   // showDeletePopup();
  });

  $("#tblOtherFeesId tbody").on("click", "i#editBtn", function () {
    var data = table_fees.row($(this).parents("tr")).data();
    editOtherFee(data[0]);
  });
});

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
  document.getElementById("newOtherFee").innerText = "true";

  let otherFee = table_fees.data();
  for (var i = 0; i < otherFee.length; i++) {
    if (otherFeeId == otherFee[i][0]) {
      document.getElementById("btnInsertUpdateOtherFee").innerText = "Update";
      document.getElementById("type_alert_fee_title").innerText =
        "Edit other fee";
      document.getElementById("lblOtherFeeId").value = otherFee[i][0];
      document.getElementById("lblAmountFee").value = otherFee[i][2];
      document.getElementById("lblTypeOfDescription").value = otherFee[i][1];

      document.getElementById("newOtherFee").innerText = "false";
    }
  }
  otherFeeModal.show();
}
