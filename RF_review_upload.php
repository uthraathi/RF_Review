<?php
require_once "config.php";
require_once "rf_menu.php";


$EMPID = $_SESSION['empid'];
$REVIEW_ID = "";
$set_fromdt = $set_todt = $set_duedt = $set_discipline = "";
$sql_f = "SELECT m.* FROM rf_review_main m, emp_biodata e where e.discipline = m.discipline and m.status = 1 and "
        . "m.due_date > CURRENT_DATE() and e.empid = '$EMPID'";
$result_f = mysqli_query($MyConnection, $sql_f);

if (mysqli_num_rows($result_f) > 0) 
{
while($row_f = mysqli_fetch_assoc($result_f)) 
{
   $set_fromdt = $row_f['From_date'];
   $set_todt = $row_f['To_date'];
   $set_duedt = $row_f['due_date'];
   $set_discipline = $row_f['discipline'];
   $REVIEW_ID = $row_f['review_id'];
}
}
mysqli_close($MyConnection);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Upload Review Documents</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 700px; }
        .error{color: #FF0000;}
        .button {background:black;border:black;color:whitesmoke;font-weight:bold;font-size:15px;float:right;}
        
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
                
                $('#From_Date').val("<?php echo $set_fromdt; ?>");
                $('#To_Date').val("<?php echo $set_todt; ?>");
                $('#Due_Date').val("<?php echo $set_duedt; ?>");
                $('#Discipline').val("<?php echo $set_discipline; ?>");
                $('#SUBMIT_DOC').click(function () 
                {
                    var check_revw_there = $('#From_Date').val();
                    var REVIEW_ID = "<?php echo $REVIEW_ID; ?>";
                    if(check_revw_there !== '')
                    {
                       var data = new FormData();
                       data.append('REVIEW_ID', REVIEW_ID);
                       data.append('UPLOAD_PPT', $('input[type=file][name=upld_ppt]')[0].files[0]);
                       data.append('UPLOAD_DOC', $('input[type=file][name=upld_doc]')[0].files[0]);
                            $.ajax
                            ({
                                url: 'post_RF_review_upload.php',
                                data: data,
                                type: 'POST',
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                     var result = JSON.parse(response);
                                     if(result.status === "S")
                                     {
                                         alert(result.msg);
                                         window.location.href="RF_review_upload.php";
                                     }
                                     else
                                     {
                                         alert(result.msg);
                                    }
                                }
                            }); 
                    }
                    else
                    {
                       alert("No-ongoing review/Exceeding Due date to submit documents");
                    }
                });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2>Upload Review Documents</h2>
            <p style="color:brown;">Please fill in your credentials to login.</p>

            <table class="table" style="font-weight:bolder;background-image: linear-gradient(to left, orchid , skyblue);border-radius:0 20px 0 20px;">
                        
                        <tr>
                            <td>From Date<span class="error"> * </span></td>
                            <td style="width:65%;">
                                <input type="Date" id="From_Date" name="From_Date" class="form-control" disabled="disabled">
                            </td>
                            <td id="fromdt_err"></td>
                        </tr>
                        <tr>
                            <td>To Date<span class="error"> * </span></td>
                            <td>
                                 <input type="Date" id="To_Date" name="To_Date" class="form-control" disabled="disabled">
                            </td>
                            <td id="todt_err"></td>
                        </tr>
                        <tr>
                            <td>Due Date<span class="error"> * </span></td>
                            <td>
                                 <input type="Date" id="Due_Date" name="Due_Date" class="form-control" disabled="disabled">
                            </td>
                            <td id="duedt_err"></td>
                        </tr>
                         <tr>
                            <td>Discipline<span class="error"> * </span></td>
                            <td>
                                <input type="text" id="Discipline" name="Discipline" class="form-control" disabled="disabled">
                                
                            </td>
                            <td id="disp_err"></td>
                        </tr>
                        <tr>
                            <td>Upload Review Presentation (PPT)<span class="error"> * </span></td>
                            <td>
                                <input type="file" id="upld_ppt" name="upld_ppt" class="form-control" accept=".ppt, .pptx">
                                
                            </td>
                            <td id="ppt_err"></td>
                        </tr>
                         <tr>
                            <td>Upload Review Document (Word Format)<span class="error"> * </span></td>
                            <td>
                                <input type="file" id="upld_doc" name="upld_doc" class="form-control" accept=".doc, .docx">
                                
                            </td>
                            <td id="ppt_err"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="button" id="SUBMIT_DOC" name="SUBMIT_DOC" class="btn btn-primary button" value="Submit" >
                            </td>
                        </tr>
            </table> 
         
            

        </div>    
    </body>
</html>
