<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    include_once '../dbconnect.php';
    include_once '../dbconfig.php';

    $loan_create_id = $_GET["loan_id"];


    $sql_mail_key=mysqli_query($con, "select * from loan_initial_banking where loan_id='$loan_create_id'"); 

    while($row_mail_key = mysqli_fetch_array($sql_mail_key)) {
    
        $mail_key=$row_mail_key['email_key'];

        if ($mail_key == ""){
            continue;
        }
        echo "<div><a target='_blank' href='https://pacificafinancegroup.com/loanportal/signature_customer/files/sign_contract.php?id=$mail_key'>https://pacificafinancegroup.com/loanportal/signature_customer/files/sign_contract.php?id=$mail_key</a><div>";

    }

    ?>
</body>
</html>



