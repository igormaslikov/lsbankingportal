$(document).ready(function() {

    table = $('#example').DataTable({
      "order": [
        [0, 'desc']
      ],
      "rowGroup": {
        startRender: function(rows, group) {
          var api = $('#example').dataTable().api();
          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i === 'string' ?
              i.replace('$', '').replace(',', '') * 1 :
              typeof i === 'number' ?
              i : 0;
          };

          var summary = function(i, api, calc) {
            sum = api
              .column(i)
              .data()
              .reduce(function(a, b) {
                return Number((intVal(a) + intVal(b)).toFixed(2));
              }, 0);

            if (calc) {
              sum = amount - sum;
            }
            return round(sum, 2);

          };

          return $('<tr/>')
            .append('<td><b>Total:</b></td>')
            .append('<td></td>')
            .append('<td><b>$' + summary(2, api, false) + '</b></td>')
            .append('<td><b>$' + summary(3, api, false) + '</b></td>')
            .append('<td><b>$' + summary(4, api, false) + '</b></td>')
            .append('<td><b>$' + summary(4, api, true) + '</b></td>')
            .append('<td><b>$' + summary(6, api, false) + '</b></td>')
            .append('<td><b>$' + summary(7, api, false) + '</b></td>')
            .append('<td><b>$' + summary(8, api, false) + '</b></td>')
            .append('<td></td>')
            .append('<td colspan=6></td>');
        },
        endRender: function(rows, group) {
          var api = $('#example').dataTable().api();
          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i === 'string' ?
              i.replace('$', '').replace(',', '') * 1 :
              typeof i === 'number' ?
              i : 0;
          };

          var summary = function(i, api, calc) {
            pageSum = api
              .column(i, {
                page: 'current'
              })
              .data()
              .reduce(function(a, b) {
                return Number((intVal(a) + intVal(b)).toFixed(2));
              }, 0);
            return round(pageSum, 2);

          };

          return $('<tr/>')
            .append('<td colspan=2><b>Page summary:</b></td>')
            .append('<td><b>$' + summary(2, api, false) + '</b></td>')
            .append('<td><b>$' + summary(3, api, false) + '</b></td>')
            .append('<td><b>$' + summary(4, api, false) + '</b></td>')
            .append('<td></td>')
            .append('<td><b>$' + summary(6, api, false) + '</b></td>')
            .append('<td><b>$' + summary(7, api, false) + '</b></td>')
            .append('<td><b>$' + summary(8, api, false) + '</b></td>')
            .append('<td></td>')
            .append('<td colspan=6></td>');
        },
        dataSrc: 1
      }

    });

    $('#example tbody').on('click', 'i#btnChargeBackId', function() {
      var data = table.row($(this).parents('tr')).data();
      var chargeback_amount = data[2].replace("$", "").replace(",","");
      document.getElementById("type_alert_title").innerText = "Set chargeback amount";
      document.getElementById("lblChargeback").placeholder = "0 - " + chargeback_amount;
      document.getElementById("lblLoanId").value = data[1];
      document.getElementById("lblTransactionId").value = data[0];
      document.getElementById("lblTransactionAmount").value = chargeback_amount;

      
      var late_fee = data[6].replace("$","").replace(",","");
      var convenience_fee = data[7].replace("$","").replace(",","");
      var other_fee = data[8].replace("$","").replace(",","");
      var other_fee_id = 0;
      if(other_fee != 0){
        other_fee_id = data[9].match(/\((.*?)\)/)[1]
      }
      
      document.getElementById("lblOtherFeeId").value = other_fee_id;
      document.getElementById("lblLateFee").placeholder = "0 - " + late_fee;
      document.getElementById("lblCovenienceFee").placeholder = "0 - " + convenience_fee;
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

    chargebackModal = new bootstrap.Modal(document.getElementById('type_alert'), {
      keyboard: false
    });

  });

  function oniputChange(elem){
    elem.value = elem.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
    var max = parseFloat(elem.max); 
    if(parseFloat(elem.value) > max)
    {
      elem.value = max;
    }
  }

  function updateChargeback() {

    if (!checkChargebackInput()) {
      document.getElementById("lblError").innerHTML = "Please enter valid data!!";
      document.getElementById("error_row_card").hidden = false;
      return;
    }
    chargebackModal.hide();

    var url = 'functions_commercial_loan.php';

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            'func':"SetChargeback",
            'u_id':document.getElementById("lblUid").getAttribute("value"),
            'id':document.getElementById("lblId").getAttribute("value"),
            'loanId':document.getElementById("lblLoanId").value,
            'transactionId':document.getElementById("lblTransactionId").value,
            'chargebackAmount': document.getElementById("lblChargeback").value,
            'lateFee': document.getElementById("lblLateFee").value,
            'convenienceFee': document.getElementById("lblCovenienceFee").value,
            'otherFee': document.getElementById("lblOtherFee").value,
            'otherFeeId': document.getElementById("lblOtherFeeId").value,
            'transactionAmount': document.getElementById("lblTransactionAmount").value
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

  function checkChargebackInput() {
    Init();
    var valid = true;
    if (document.getElementById("lblChargeback").value == '') {
        document.getElementById("lblChargeback").style.borderColor = "red";
        valid = false;
    }
    return valid;
}

function Init() {
    document.getElementById("lblChargeback").style.removeProperty("border");
    document.getElementById("error_row").hidden = true;
}