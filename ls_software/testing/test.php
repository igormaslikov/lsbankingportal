<?php



$sql=mysqli_query($con, "select * from tbl_users where user_id= '35'"); 

while($row = mysqli_fetch_array($sql)) {

$access_level=$row['username'];

echo $access_level."<br>";

}

$query = "DELETE FROM tbl_users WHERE user_id = '65'";
    $result = mysqli_query($con, $query);
       if ($result) {
           echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }


?>