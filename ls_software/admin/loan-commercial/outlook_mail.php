<?php
    $subject="This is a test message";        
    $message="This is a Body Section now.....! :)";        
    $to="asimmaqbool195@gmail.com";

    // starting outlook        
    com_load_typelib("outlook.application"); 

    if (!defined("olMailItem")) {define("olMailItem",0);}

    $outlook_Obj = new COM("outlook.application") or die("Unable to start Outlook");

    //just to check you are connected.        
    echo "Loaded MS Outlook, version {$outlook_Obj->Version}\n";        
    $oMsg = $outlook_Obj->CreateItem(olMailItem);        
    $oMsg->Recipients->Add($to);
    $oMsg->Subject=$subject;        
    $oMsg->Body=$message;        
    $oMsg->Save();        
    $oMsg->Send();    
?>