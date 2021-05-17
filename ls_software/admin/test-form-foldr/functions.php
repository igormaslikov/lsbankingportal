<?php 

  
// Function to return the array 
// of factors of n 



function user_roles($user_role,$form_id){
      
      $sql_role=mysqli_query($con, "select * from access_level_grants where role_id='$user_role' AND form_id='$form_id'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 
 $delete_allowed=$row_role['delete_allowed'];


//echo $role_id."<br>";

}

return "$delete_allowed";
    
}



function user_edit_roles($user_role,$form_id){
      
      $sql_role=mysqli_query($con, "select * from access_level_grants where role_id='$user_role' AND form_id='$form_id'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $role_id=$row_role['role_id'];
 $select_allowed=$row_role['select_allowed'];
 $insert_allowed=$row_role['insert_allowed'];
 $update_allowed=$row_role['update_allowed'];
 $delete_allowed=$row_role['delete_allowed'];


//echo $role_id."<br>";

}

return "$update_allowed";
    
}







?>