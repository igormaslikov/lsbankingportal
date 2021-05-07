<?php


    require_once 'dbconfig.php';     
    require_once 'dbconnect.php';

        function datediff($date1) {
                $date2 = "2019-03-28";
                $date1 = date_create($date1);
                $date2 = date_create($date2);
                $diff=date_diff($date1,$date2);
                $realdiff = $diff->format("%a");
                return $realdiff;
        }

    $query = "select creation_date, count(*) as creation_date from tbl_loan group by creation_date";

    try
    {
        $sth = $db->query($query);
        while ($row = $sth->fetch (PDO::FETCH_ASSOC))
        {
        $date = ($row["creation_date"]);
        $mdate = datediff($date);
        $output[$mdate] = ($row["creation_date"]);
        } 
    }

    catch (PDOException $e)
    {
        printf("We had a problem: %s\n", $e->getMessage());
    }


    for ($i = 0; $i < ($mdate + 1) ; $i++) {
        echo $i." ".(0 + $output[$i])."<br>";
    }
?>