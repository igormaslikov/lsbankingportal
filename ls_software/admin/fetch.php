<?php
//fetch.php
$connect = mysqli_connect("localhost", "gwadaron_ls_user", "^%D24L*!Ti5%", "gwadaron_lsbanking");
$request = mysqli_real_escape_string($connect, $_POST["query"]);
$query = "
 SELECT Distinct first_name FROM fnd_user_profile WHERE first_name LIKE '%".$request."%'
";

$result = mysqli_query($connect, $query);

$data = array();

if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_assoc($result))
 {
  $data[] = $row["first_name"];
 }
 echo json_encode($data);
}

?>


