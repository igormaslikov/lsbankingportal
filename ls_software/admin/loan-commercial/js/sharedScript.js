
let tableItem;
let func ="";
function showDeletePopup() {
    var type = $(".nav-link.active")[0].innerText;

    switch (type) {
        case "Loans":
            tableItem = table_loans;
            break;
        case "Banks":
            tableItem = table;
            func = "DeleteBankInfo"; 
            break;
        case "Cards":
            tableItem = tableCardInfo;
            func = "DeleteCardInfo"; 
            break;  
        default:
            break;
    }
    
    var title = document.getElementById("deleteTitle");
    document.getElementById("idInformation").value = "bank";
    var info = "Delete permanently "+type.toLowerCase().replace("s","") +" info";

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

function deleteItem() {
    let result = null;
    tableItem.rows({ selected: true }).every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        result = removeItem(data[0], func);
    });

    if(result[0]){
        tableItem.rows({ selected: true }).remove();
        tableItem.draw(false);
    }
    
 //not reloading page
    alert(result[1]);
    deleteMod.hide();
    
}

function removeItem(idItem, func) {
    var url = 'functions_commercial_loan.php';
    let result = null;
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            'func': func,
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