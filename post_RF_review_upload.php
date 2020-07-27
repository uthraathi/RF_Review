<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['empid']))
{
    header('location:index.php');
}
$target = "Review_Documents/";
$target_ppt = $target . basename($_FILES['UPLOAD_PPT']['name']);
$Filename_ppt =basename( $_FILES['UPLOAD_PPT']['name']);
$target_doc = $target . basename($_FILES['UPLOAD_DOC']['name']);
$Filename_doc =basename( $_FILES['UPLOAD_DOC']['name']);

$empid = $_SESSION['empid'];
$REVIEW_ID = $_POST['REVIEW_ID'];


$status=$msg="";


$sql = "SELECT * FROM rf_review_doc WHERE review_id = '$REVIEW_ID' and empid = '$empid'";
$result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) === 0) 
 {
        if(move_uploaded_file($_FILES['UPLOAD_PPT']['tmp_name'], $target_ppt)) 
        {
            if(move_uploaded_file($_FILES['UPLOAD_DOC']['tmp_name'], $target_doc)) 
            {
                $sql = "INSERT INTO rf_review_doc(review_id, empid, review_doc, review_ppt) VALUES "
                        . "('$REVIEW_ID','$empid','$Filename_doc','$Filename_ppt')";
            } 
            else 
            {
                $status = "F";
                $msg = "Sorry, there was a problem uploading in uploading your document";
            }
        } 
        else 
        {
            $status = "F";
            $msg = "Sorry, there was a problem uploading in uploading your ppt.";
        }
        if(mysqli_query($MyConnection, $sql))
        {
            $status = "S";
            $msg = "Documents Successfully Uploaded";
        }
        else
        {
            $status = "F";
            $msg = "Error";
        }
     
 } 
 else 
 {
        $status = "F";
        $msg = "Document Already Uploaded";
 }
 mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
