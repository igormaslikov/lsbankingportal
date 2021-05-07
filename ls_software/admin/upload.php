<?php


error_reporting(E_ALL);
ini_set("display_errors",1);
$success = 0;
$fail = 0;

$uploads_dir = 'user_images';
$count = 1;
foreach ($_FILES["imagee"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["imagee"]["tmp_name"][$key];
        $name = $_FILES["imagee"]["name"][$key];
        $uploadfile = "$uploads_dir/$name";
        $ext = strtolower(substr($uploadfile,strlen($uploadfile)-3,3));
        if (preg_match("/(jpg|gif|png|bmp)/",$ext)){
            $newfile = "$uploads_dir/picture".str_pad($count++,2,'0',STR_PAD_LEFT).".".$ext;
            if(move_uploaded_file($tmp_name, $newfile)){
                $success++;
            }else{
                echo "Couldn't move file: Error Uploading the file. Retry after sometime.\n";
                $fail++;
            }
        }else{
            echo "Invalid Extension.\n";
            $fail++;
        }
    }
}
echo "<br> Number of files Uploaded:".$success;
echo "<br> Number of files Failed:".$fail;

?>