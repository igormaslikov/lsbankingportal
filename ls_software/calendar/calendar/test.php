 <?php
                error_reporting(E_ALL ^ E_DEPRECATED);





                $username = "gwadaron_ls_user";

                $password = "admin$$123";

                $hostname = "mymoneyline.com/lsbankingportal/";

                $database = "gwadaron_lsbanking";



                $conn = mysql_connect($hostname, $username, $password)

                or die("Connecting to MySQL failed");

                mysql_close($conn);

                if ($conn) {
                    if (isset($_GET["end"])) {
                        //this is calendar query. 
                        //form an array of events
                        $arr = array();
                        $from_date = htmlspecialchars($_GET["end"]);
                        $to_date   = htmlspecialchars($_GET["end"]);
                        $sql_string = "SELECT count(DISTINCT id) as  laon_id,creation_date as creation_date FROM tbl_loan group by creation_date";



                        $result = mysql_fetch_assoc($sql_string);


                        //odbc_result_all($result);
                        // Fetch rows:
                        while(mysql_fetch_array($result))
                        {
                            if (!mysql_result($result,2)) continue;
                            //collect results
                            $title=mysql_result($result,1);
                            $date=mysql_result($result,2);


                            $arr[] = array(
                                'title' => $title,
                                'url' => 'myfeed.php?dt='.substr($date, 0, 10),
                                'start' => substr($date, 0, 10)
                            );
                        }
                        echo json_encode($arr);
                    }
                }

                    ?>