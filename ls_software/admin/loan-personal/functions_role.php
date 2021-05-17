<?php 

function user_roles($user_role,$form_id){
    
    $date= date('Y-m-d H:i:s');    
      $sql_role=mysqli_query($con, "select * from access_level_grants where role_id='$user_role' AND form_id='$form_id'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $role_id=$row_role['role_id'];
 $select_allowed=$row_role['select_allowed'];
 $insert_allowed=$row_role['insert_allowed'];
 $update_allowed=$row_role['update_allowed'];
 $delete_allowed=$row_role['delete_allowed'];


echo $role_id."<br>";
echo $select_allowed."<br>";
echo $insert_allowed."<br>";
echo $update_allowed."<br>";
echo $delete_allowed."<br>";
}

    
}







?>