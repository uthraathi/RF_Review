<?php
require_once "config.php";
session_start();

$From_Date =  $_POST['From_Date'];
$To_Date = $_POST['To_Date'];
$Due_Date =  $_POST['Due_Date'];
$Discipline = $_POST['Discipline'];
$status=$msg="";


 $sql = "SELECT * FROM rf_review_main WHERE FROM_DATE = '$From_Date' and status = 1 and To_date = '$To_Date' and discipline = '$Discipline'";
 $result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) > 0) 
 {
    $status = "F";
    $msg = "Record Already Exist";
 } 
 else 
 {
    $sql_Insert = "INSERT INTO rf_review_main(From_date,To_date,due_date,discipline) VALUES "
            . "('$From_Date','$To_Date','$Due_Date','$Discipline')";

    if(mysqli_query($MyConnection, $sql_Insert))
        {
            $status = "S";
            $msg =  " Review Date Setted Successfully";
        }
        else
        {
            $status = "F";
            $msg = "Error";
        }
 }
mysqli_close($MyConnection);

$arr = array('status' => $status, 
             'msg'    => $msg); 
echo json_encode($arr);

?>
