<?php
require_once "config.php";
session_start();

$username =  $_POST['username'];
$password = $_POST['password'];

$status=$msg="";


 $sql = "SELECT e.* FROM emp_biodata e, review_committee p WHERE e.empid = '$username' and  e.password = MD5('$password') and e.empid = p.empid and p.status = 1";
 $result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) > 0) 
 {
    while($row = mysqli_fetch_assoc($result)) 
    {
        $status = "S";
        $msg = "Login Successfully";
        $_SESSION['empid'] = $username;
    }
 } 
 else 
 {
        $status = "F";
        $msg = "Access Denied";
 }
mysqli_close($MyConnection);

$arr = array('status' => $status, 
             'msg'    => $msg); 
echo json_encode($arr);

?>
