<?php
require_once 'rc_Menu.php';

$empid = $_SESSION['empid'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>List of Uploaded Documents</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
               
                $('input[id$="Download"]').click(function () 
             
                {
                    var vartr = $(this).closest('tr');
                    var doc_id = vartr.find('input[id$="doc_id"]').val();
                    //alert("doc_id "+doc_id);
                    window.location.href= "Download_Review_doc.php?doc_id="+doc_id;

                });
                $('input[id$="ppt_Download"]').click(function () 
             
                {
                    var vartr = $(this).closest('tr');
                    var doc_id = vartr.find('input[id$="doc_id"]').val();
                    //alert("doc_id "+doc_id);
                    window.location.href= "Download_Review_ppt.php?doc_id="+doc_id;

                });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">List of Uploaded Documents</h2>
 

            <table class="table">
                <tr style="background:skyblue;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Discipline</td>
                    <td>Duration</td>
                    <td>Due Date</td>
                    <td>Research Fellow ID</td>
                    <td>Document</td>
                    <td>PPT</td>
                    
                </tr>
                <?php
                require_once "config.php";
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 5;
                $offset = ($pageno-1) * $no_of_records_per_page;
                $total_pages_sql = "SELECT count(*) FROM rf_review_main m, rf_review_doc d,review_committee c WHERE c.empid= '$empid' AND C.STATUS = 1 AND C.discipline = M.discipline AND M.review_id = D.REVIEW_ID ORDER BY M.discipline,M.From_date";
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT M.*,D.EMPID AS RF_ID, D.REVIEW_PPT, D.REVIEW_DOC,d.doc_id FROM rf_review_main m, rf_review_doc d,review_committee c WHERE c.empid= 'A1' AND C.STATUS = 1 AND C.discipline = M.discipline AND M.review_id = D.REVIEW_ID ORDER BY M.discipline,M.From_date LIMIT $offset,$no_of_records_per_page";


                 $result = mysqli_query($MyConnection, $sql);
                 $index = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>". $index ."</td>";
                        echo "<td>". $row['discipline'] ."</td>";
                        echo "<td>". $row['From_date']. " to ". $row['To_date'] ."</td>";
                        echo "<td>". $row['due_date'] ."</td>";
                        echo "<td>". $row['RF_ID']."</td>";
                        echo "<td><input type='hidden' id = 'obj[". $index."].doc_id' name = 'obj[". $index."].doc_id' value=".$row['doc_id']."><input type='button' id = 'obj[". $index."].Download' name = 'obj[". $index."].Download' class='btn btn-primary' value='Download' style='background:orangered;border:#b5651d;font-weight:bold;'</td>";
                        echo "<td><input type='button' id = 'obj[". $index."].ppt_Download' name = 'obj[". $index."].ppt_Download' class='btn btn-primary' value='Download' style='background:orangered;border:#b5651d;font-weight:bold;'</td>";
                        echo "</tr>";
                    }
                        
                }
                  

                 mysqli_close($MyConnection);
                ?>
                 <tr style="text-align:center;">
                    <td colspan="10">
                    <ul class="pagination">
                        <li><a href="?pageno=1">First</a></li>
                        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                        </li>
                        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                        </li>
                        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                    </ul>
                </td>
                </tr>                  
                        
            </table> 
     
        </div>    
    </body>
</html>
