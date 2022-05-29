$(document).ready(function () {
  table = $("#example").DataTable({
    select: {
      bluerable: true,
    },
    order: [[0, "desc"]],
    rowGroup: {
      startRender: function (rows, group) {
        var api = $("#example").dataTable().api();
        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === "string"
            ? i.replace("$", "").replace(",", "") * 1
            : typeof i === "number"
            ? i
            : 0;
        };

        var summary = function (i, api, calc) {
          sum = api
            .column(i)
            .data()
            .reduce(function (a, b) {
              return Number((intVal(a) + intVal(b)).toFixed(2));
            }, 0);

          if (calc) {
            sum = amount - sum;
          }
          return round(sum, 2);
        };

        return $("<tr/>")
          .append("<td><b>Total:</b></td>")
          .append("<td></td>")
          .append("<td></td>")
          .append("<td></td>")
          .append("<td></td>")
          .append("<td><b>$" + summary(5, api, false) + "</b></td>")
          .append("<td><b>$" + summary(6, api, false) + "</b></td>")
          .append("<td><b>$" + summary(7, api, false) + "</b></td>")
          .append("<td><b>$" + summary(7, api, true) + "</b></td>")
          .append("<td></td>")
          .append("<td></td>")
          .append("<td><b>$" + summary(11, api, false) + "</b></td>")
          .append("<td><b>$" + summary(12, api, false) + "</b></td>")
          .append("<td><b>$" + summary(13, api, false) + "</b></td>")
          .append("<td></td>")
          // .append("<td><b>$" + summary(10, api, false) + "</b></td>")
          // .append("<td></td>")
          .append("<td colspan=6></td>");
      },
      endRender: function (rows, group) {
        var api = $("#example").dataTable().api();
        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === "string"
            ? i.replace("$", "").replace(",", "") * 1
            : typeof i === "number"
            ? i
            : 0;
        };

        var summary = function (i, api, calc) {
          pageSum = api
            .column(i, {
              page: "current",
            })
            .data()
            .reduce(function (a, b) {
              return Number((intVal(a) + intVal(b)).toFixed(2));
            }, 0);
          return round(pageSum, 2);
        };

        return $("<tr/>")
          .append("<td colspan=2><b>Page summary:</b></td>")
          .append("<td></td>")
          .append("<td></td>")
          .append("<td></td>")
          .append("<td><b>$" + summary(5, api, false) + "</b></td>")
          .append("<td><b>$" + summary(6, api, false) + "</b></td>")
          .append("<td><b>$" + summary(7, api, false) + "</b></td>")
          .append("<td></td>")
          .append("<td></td>")
          .append("<td></td>")
          .append("<td><b>$" + summary(11, api, false) + "</b></td>")
          .append("<td><b>$" + summary(12, api, false) + "</b></td>")
          .append("<td><b>$" + summary(13, api, false) + "</b></td>")
          .append("<td></td>")
          // .append("<td><b>$" + summary(10, api, false) + "</b></td>")
          // .append("<td></td>")
          .append("<td colspan=6></td>");
      },
      dataSrc: 1,
    },
  });

  $("#example tbody").on("click", "i#editBtnTransaction", function () {
    var data = table.row($(this).parents("tr")).data();

    var payment = data[2].replace("$", "").replace(",", "");
    var late_fee = data[6].replace("$", "").replace(",", "");
    var convenience_fee = data[7].replace("$", "").replace(",", "");
    var other_fee = data[8].replace("$", "").replace(",", "");
    var other_fee_id = 0;
    if (other_fee != 0) {
      other_fee_id = data[9].match(/\((.*?)\)/)[1];
    }

    document.getElementById("lblLoanIdTransaction").value = data[1];
    document.getElementById("lblTransactionIdTransaction").value = data[0];
    document.getElementById("lblTransactionAmountTransaction").value = payment;
    document.getElementById("lblOtherFeeIdTransaction").value = other_fee_id;
    // document.getElementById("lblPayment").value = payment;
    // document.getElementById("lblTransactionLateFee").value = late_fee;
    // document.getElementById("lblTransactionCovenienceFee").value = convenience_fee;
    // document.getElementById("lblTransactionOtherFee").value = other_fee;
    document.getElementById("transaction_edit_modal_title").innerText =
      "Update transaction " + data[0];
    var is_card = data[12] == "Debit Card" || data[12] == "Repay";
    document.getElementById("is_card").value = is_card;
    getEditForm();
    editTransactionModal.show();
  });

  $("#example tbody").on("click", "i#removeBtnTransaction", function () {
    showDeleteTransactionPopup();
  });

  $("#example tbody").on("click", "i#btnChargeBackId", function () {
    var data = table.row($(this).parents("tr")).data();
    var chargeback_amount = data[2].replace("$", "").replace(",", "");
    document.getElementById("type_alert_title").innerText =
      "Set chargeback amount";
    document.getElementById("lblChargeback").placeholder =
      "0 - " + chargeback_amount;
    document.getElementById("lblLoanId").value = data[1];
    document.getElementById("lblTransactionId").value = data[0];
    document.getElementById("lblTransactionAmount").value = chargeback_amount;

    var late_fee = data[6].replace("$", "").replace(",", "");
    var convenience_fee = data[7].replace("$", "").replace(",", "");
    var other_fee = data[8].replace("$", "").replace(",", "");
    var other_fee_id = 0;
    if (other_fee != 0) {
      other_fee_id = data[9].match(/\((.*?)\)/)[1];
    }

    document.getElementById("lblOtherFeeId").value = other_fee_id;
    document.getElementById("lblLateFee").placeholder = "0 - " + late_fee;
    document.getElementById("lblCovenienceFee").placeholder =
      "0 - " + convenience_fee;
    document.getElementById("lblOtherFee").placeholder = "0 - " + other_fee;

    document.getElementById("lblChargeback").disabled = chargeback_amount == 0;
    document.getElementById("lblLateFee").disabled = late_fee == 0;
    document.getElementById("lblCovenienceFee").disabled = convenience_fee == 0;
    document.getElementById("lblOtherFee").disabled = other_fee == 0;

    document.getElementById("lblChargeback").max = chargeback_amount;
    document.getElementById("lblLateFee").max = late_fee;
    document.getElementById("lblCovenienceFee").max = convenience_fee;
    document.getElementById("lblOtherFee").max = other_fee;

    chargebackModal.show();
  });

  $('[data-toggle="tooltip"]').tooltip();

  chargebackModal = new bootstrap.Modal(document.getElementById("type_alert"), {
    keyboard: false,
  });

  editTransactionModal = new bootstrap.Modal(
    document.getElementById("transaction_edit_modal"),
    {
      keyboard: false,
    }
  );
});

function oniputChange(elem) {
  elem.value = elem.value.replace(/[^0-9.-]/g, "").replace(/(\..*)\./g, "$1");
  var max = parseFloat(elem.max);
  if (parseFloat(elem.value) > max) {
    elem.value = max;
  }
}

function updateTransaction(e) {
  var formData = new FormData(
    document.querySelector("form[id=transactionFormId]")
  );
  
  formData.append(
    "transaction_id",
    document.getElementById("lblTransactionIdTransaction").value
  );
  formData.append("user_fnd_id", document.getElementById("userId").innerText);
  formData.append(
    "u_id",
    document.getElementById("lblUidTransaction").getAttribute("value")
  );
  formData.append(
    "loan_id",
    document.getElementById("lblLoanIdTransaction").value
  );
  let payment = formData.get("to_be_paid_amount");
  let late_fee = formData.get("late_fee");
  let convenience_fee = formData.get("convenience_fee");
  let type_of_description = formData.get("type_of_description");
  let payment_method = formData.get("payment_method");
  let payment_description = formData.get("payment_description");
  let other_fee = formData.get("other_fee");

  if (
    other_fee == "" &&
    payment == "" &&
    late_fee == "" &&
    convenience_fee == "" &&
    type_of_description == "" &&
    payment_method == "" &&
    payment_description == ""
  ) {
    // TODO set error message
    alert("test");
    return;
  }
  let func = "UpdateTransaction";
  if(payment_method.toString().startsWith("Chargeback")){
    func = "UpdateChargebackTransaction";
  }
  formData.append("func", func);
  $.ajax({
    url: "functions_commercial_loan.php",
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    type: "POST",
    success: function (response) {
      table.draw(false);
      editTransactionModal.hide();
      e.preventDefault();
      window.location.reload();
      // window.location.reload();
      //SlickLoader.disable();
    },
    error: function (error) {
      
      //SlickLoader.disable();
    },
  });
  //$apr=str_replace("%","","$apr");
  e.preventDefault();
}

function showDeleteTransactionPopup() {
  var title = document.getElementById("deleteTitle");
  document.getElementById("idInformation").value = "transaction";
  var info = "Delete permanently transaction";

  title.innerText = info;
  title.innerHTML = info;
  document.getElementById("chkDel").checked = false;
  document.getElementById("btnDel").disabled = true;
  deleteMod.show();
}

function deleteTransaction() {
  var transactionId = 0;
  table
    .rows({ selected: true })
    .every(function (rowIdx, tableLoop, rowLoop) {
      var data = this.data();
      transactionId = data[0];
      payment_method = data[12];
      result = removeTransaction(transactionId,payment_method);
    });

    window.location.reload();
}

function removeTransaction(transactionId, payment_method){
  let func = "DeleteTransaction";
  if(payment_method.toString().startsWith("Chargeback")){
    func = "DeleteChargebackTransaction";
  }

  var url = 'functions_commercial_loan.php';
  let result = null;
  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: {
          'func': func,
          'transactionId':transactionId
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


function updateChargeback() {
  if (!checkChargebackInput()) {
    document.getElementById("lblError").innerHTML = "Please enter valid data!!";
    document.getElementById("error_row_card").hidden = false;
    return;
  }
  chargebackModal.hide();

  var url = "functions_commercial_loan.php";

  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: {
      func: "SetChargeback",
      u_id: document.getElementById("lblUid").getAttribute("value"),
      id: document.getElementById("lblId").getAttribute("value"),
      loanId: document.getElementById("lblLoanId").value,
      transactionId: document.getElementById("lblTransactionId").value,
      chargebackAmount: document.getElementById("lblChargeback").value,
      lateFee: document.getElementById("lblLateFee").value,
      convenienceFee: document.getElementById("lblCovenienceFee").value,
      otherFee: document.getElementById("lblOtherFee").value,
      otherFeeId: document.getElementById("lblOtherFeeId").value,
      transactionAmount: document.getElementById("lblTransactionAmount").value,
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
      } else {
        alert(err.responseText);
      }
      window.location.reload();
    },
  });
}

function checkChargebackInput() {
  Init();
  var valid = true;
  if (document.getElementById("lblChargeback").value == "") {
    document.getElementById("lblChargeback").style.borderColor = "red";
    valid = false;
  }
  return valid;
}

function Init() {
  document.getElementById("lblChargeback").style.removeProperty("border");
  document.getElementById("error_row").hidden = true;
}

function getEditForm() {
  var url = "functions_commercial_loan.php";

  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: {
      func: "GetEditTransactionModal",
      u_id: document.getElementById("lblUidTransaction").getAttribute("value"),
      user_fnd_id: document.getElementById("userId").innerText,
      loanId: document.getElementById("lblLoanIdTransaction").value,
      transactionId: document.getElementById("lblTransactionIdTransaction")
        .value,
    },
    success: function (data) {
      var editModal = data[0].editModal;
      document.getElementById("transaction_modal_body_id").innerHTML =
        editModal;
      document.getElementById("transaction_modal_body_id").innerHTML.reload;

      //alert(data[0].message);
      //window.location.reload();
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

function GetUnpaidOtherFee(elem, event) {
  let id = elem.value.split(" ").slice(-1)[0].replace("(", "").replace(")", "");
  var url = "functions_commercial_loan.php";

  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: {
      func: "GetUnpaidOtherFee",
      id: id,
    },
    async: true,
    success: function (data) {
      //var tableCard = data[0].cardTable;
      var unpaidFee = data[0].nonpaid;
      document.getElementById("other_fee_id").value = unpaidFee;
      //calculate_summary(event);
      event.preventDefault();
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

function payment_method_info(elem, event) {
  let method = elem.value;
  switch (method) {
    case "Repay":
    case "Debit Card":
    case "Repay Portal":
      var url = "functions_commercial_loan.php";
      // projectName = "SPVL"

      $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
          func: "GetBankInfoTable",
          userId: document.getElementById("userId").innerText,
          loan_create_id: document.getElementById("lblLoanIdTransaction").value,
          transaction_id: document.getElementById("lblTransactionIdTransaction")
            .value,
          is_card: document.getElementById("is_card").value,
        },
        async: true,
        success: function (data) {
          //var tableCard = data[0].cardTable;
          var tableBank = data[0].bankTable;
          // document.getElementById("bankTableId").outerHTML = tableBank;
          // document.getElementById("cardTableId").outerHTML = tableCard;
          document.getElementById("bankTableId").innerHTML = tableBank;
          document.getElementById("bankTableId").innerHTML.reload;
          // document.getElementById("cardTableId").innerHTML = tableCard;
          // document.getElementById("cardTableId").innerHTML.reload;
          $("#tbl_bank_info").on(
            "click",
            ".clickable-bank-row",
            function (event) {
              if ($(this).hasClass("table-success")) {
                $(this).removeClass("table-success");
              } else {
                $(this)
                  .addClass("table-success")
                  .siblings()
                  .removeClass("table-success");
              }

              getCardInfoTable(event);
              //getDebitCardInformation(event);
            }
          );

          getCardInfoTable(event);
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
      break;
    default:
      document.getElementById("bankOptionId").innerHTML = "";
      document.getElementById("cardOptionId").innerHTML = "";
      document.getElementById("cardTableId").innerHTML = "";
      document.getElementById("bankTableId").innerHTML = "";
      document.getElementById("btnUpdateTransaction").disabled = false;
      break;
  }
}

function getCardInfoTable(e) {
  var selected_data_bank = $("#tbl_bank_info tr.table-success td");
  var paymentElem = document.getElementById("bankOptionId");
  paymentElem.innerHTML = "";
  var bankExists = selected_data_bank.length > 0;
  paymentElem.innerHTML +=
    "<input type='text' name='bankExists' value='" +
    bankExists +
    "' style='display:none;'>";
  if (!bankExists) {
    document.getElementById("btnUpdateTransaction").disabled = true;
    document.getElementById("cardTableId").innerHTML = "";
    e.preventDefault();
    return;
  }

  var bankId = selected_data_bank[0].innerText;
  paymentElem.innerHTML +=
    "<input type='text' name='bankName' value='" +
    selected_data_bank[1].innerText +
    "' style='display:none;'>";
  paymentElem.innerHTML +=
    "<input type='text' name='accountNumber' value='" +
    selected_data_bank[2].innerText +
    "' style='display:none;'>";
  paymentElem.innerHTML +=
    "<input type='text' name='routingNumber' value='" +
    selected_data_bank[3].innerText +
    "' style='display:none;'>";
  paymentElem.innerHTML +=
    "<input type='text' name='accountType' value='" +
    selected_data_bank[4].innerText +
    "' style='display:none;'>";
  paymentElem.innerHTML +=
    "<input type='text' name='bankType' value='" +
    selected_data_bank[5].innerText +
    "' style='display:none;'>";

  var url = "functions_commercial_loan.php";
  // projectName = "SPVL"

  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: {
      func: "GetCardInfoByBankId",
      userId: document.getElementById("userId").innerText,
      loan_create_id: document.getElementById("lblLoanIdTransaction").value,
      bankId: bankId,
      transaction_id: document.getElementById("lblTransactionIdTransaction")
        .value,
      is_card: document.getElementById("is_card").value,
    },
    async: true,
    success: function (data) {
      //var tableCard = data[0].cardTable;
      var tableCard = data[0].cardTable;
      document.getElementById("cardTableId").innerHTML = tableCard;
      document.getElementById("cardTableId").innerHTML.reload;
      // var selected_data = $("#tbl_bank_info tr.success td");

      $("#tbl_card_info").on("click", ".clickable-card-row", function (event) {
        if ($(this).hasClass("table-success")) {
          $(this).removeClass("table-success");
        } else {
          $(this)
            .addClass("table-success")
            .siblings()
            .removeClass("table-success");
        }

        getCardInformation(event);
        //change_bank_info(event);
      });

      getCardInformation(event);
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

function getCardInformation(e) {
  var selected_data_card = $("#tbl_card_info tr.table-success td");
  var paymentElem = document.getElementById("cardOptionId");
  paymentElem.innerHTML = "";
  var cardExists = selected_data_card.length > 0;
  paymentElem.innerHTML +=
    "<input type='text' name='cardExists' value='" +
    cardExists +
    "' style='display:none;'>";
  if (!cardExists) {
    document.getElementById("btnUpdateTransaction").disabled = true;
    e.preventDefault();
    return;
  }

  document.getElementById("btnUpdateTransaction").disabled = false;
  paymentElem.innerHTML +=
    "<input type='text' name='typeOfID' value='" +
    selected_data_card[1].innerText +
    "' style='display:none;'>";
  paymentElem.innerHTML +=
    "<input type='text' name='typeOfCard' value='" +
    selected_data_card[2].innerText +
    "' style='display:none;'>";
  paymentElem.innerHTML +=
    "<input type='text' name='cardNumber' value='" +
    selected_data_card[3].innerText +
    "' style='display:none;'>";
  paymentElem.innerHTML +=
    "<input type='text' name='expDate' value='" +
    selected_data_card[4].innerText +
    "' style='display:none;'>";
  paymentElem.innerHTML +=
    "<input type='text' name='cvv' value='" +
    selected_data_card[5].innerText +
    "' style='display:none;'>";
}
