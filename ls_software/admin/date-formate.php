
<html>
   <head>
       <style> 
       label {
    display: block;
    font: 1rem 'Fira Sans', sans-serif;
}



.editableBox {
    width: 150px;
    height: 30px;
}

.timeTextBox {
   width: 125px;
    margin-left: -150px;
    height: 25px;
    border: none;
}



</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    
 $(document).ready(function(){
   
    $(".editableBox").change(function(){         
        $(".timeTextBox").val($(".editableBox option:selected").html());
    });
});   
    
    
</script>
   </head> 
   
        
        
  <form method="POST" action=""> 

<label for="start">Start month:</label>

<input type="month" id="start" name="start" min="" value="">




        <select name="bank_name" id="bank_name" class="form-control editableBox"  value="">
     <option></option>
     <option value="Bank Of America">Bank Of America</option>
     <option value="Chase">Chase</option>
     <option value="Wells Fargo">Wells Fargo</option>
     <option value="Citi Bank ">Citi Bank </option>
     <option value="US Bank">US Bank</option>
     <option value="HSBC">HSBC</option>
     </select>
    <input class="timeTextBox" name="bank_name" maxlength="5"/>
<br><br>



<input type="submit"  name="submit">
</form> 
</html>

<?php
include_once 'dbconnect.php';
include_once 'dbconfig.php';

if(isset($_POST['submit'])) {
    
$start =$_POST['bank_name'];

echo "Date".$start;



 $query_in  = "INSERT INTO loan_initial_banking (bank_name)  VALUES ('$start')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }








}

?>