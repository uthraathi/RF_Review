<?php
require_once "config.php";
// Downloads files
if (isset($_GET['doc_id'])) {
    $id = $_GET['doc_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM rf_review_doc WHERE doc_id=$id";
    $result = mysqli_query($MyConnection, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'Review_Documents/' . $file['REVIEW_PPT'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/ppt');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('Review_Documents/' . $file['REVIEW_PPT']));
        readfile('Review_Documents/' . $file['REVIEW_PPT']);

        exit;
    }

}
?>