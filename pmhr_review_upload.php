<?php
require_once "config.php";
require_once "PMHR_Menu.php";

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Set Review Date</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 500px; padding: 20px; }
        .error{color: #FF0000;}
        .button {background:black;border:black;color:whitesmoke;font-weight:bold;font-size:15px;float:right;}
        
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#Set_Date").click(function () 
                {
                   
                    var From_Date = $.trim($('#From_Date').val());
                    var To_Date = $.trim($('#To_Date').val());
                    var Due_Date = $.trim($('#Due_Date').val());
                    var Discipline = $.trim($('#Discipline').val());
                    
                       
                        if(From_Date === '')
                        {
                            $('#fromdt_err').empty();
                            $('#fromdt_err').append('<span style="color:red;">Enter From Date</span>');
                        }
                        else
                        {
                            $('#fromdt_err').empty();
                            if(To_Date === '')
                            {
                                $('#todt_err').empty();
                                $('#todt_err').append('<span style="color:red;">Enter To Date</span>');
                            }
                            else
                            {
                                $('#todt_err').empty();
                                if(Due_Date === '')
                                {
                                    $('#duedt_err').empty();
                                    $('#duedt_err').append('<span style="color:red;">Enter Due Date</span>');
                                }
                                else
                                {
                                    $('#duedt_err').empty();
                                    if(Discipline === 'Select')
                                    {
                                        $('#disp_err').empty();
                                        $('#disp_err').append('<span style="color:red;">Select Discipline</span>');
                                    }
                                    else
                                    {
                                        $('#disp_err').empty();
                                        $.ajax
                                        ({
                                            type: 'POST',
                                            url: 'Post_Set_Time.php',
                                            data: { From_Date: From_Date ,To_Date: To_Date,Due_Date: Due_Date, Discipline: Discipline},
                                            success: function(response) 
                                            {
                                                 var result = JSON.parse(response);
                                                 if(result.status === "S")
                                                 {
                                                     alert(result.msg);
                                                     window.location.href="pmhr_review_upload.php";
                                                 }
                                                 else
                                                 {
                                                     alert(result.msg);
                                                }
                                            }
                                        });

                                    }

                                }

                            }
                        }
                    

                });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2>Set Review Date</h2>
            <p style="color:brown;">Please fill in your credentials to login.</p>

            <table class="table" style="font-weight:bolder;background-image: linear-gradient(to left, orchid , skyblue);border-radius:0 20px 0 20px;">
                        
                        <tr>
                            <td>From Date<span class="error"> * </span></td>
                            <td style="width:65%;">
                                <input type="Date" id="From_Date" name="From_Date" class="form-control">
                            </td>
                            <td id="fromdt_err"></td>
                        </tr>
                        <tr>
                            <td>To Date<span class="error"> * </span></td>
                            <td>
                                 <input type="Date" id="To_Date" name="To_Date" class="form-control">
                            </td>
                            <td id="todt_err"></td>
                        </tr>
                        <tr>
                            <td>Due Date<span class="error"> * </span></td>
                            <td>
                                 <input type="Date" id="Due_Date" name="Due_Date" class="form-control">
                            </td>
                            <td id="duedt_err"></td>
                        </tr>
                         <tr>
                            <td>Discipline<span class="error"> * </span></td>
                            <td>
                                  <select id="Discipline" name="Discipline">
                                    <option value="Select" selected="selected" >-- Select Discipline --</option>
                                    <?php
                                    require_once "config.php";

                                    $sql = "SELECT distinct(Discipline) as Discipline FROM emp_biodata ORDER BY Discipline";
                                    $result = mysqli_query($MyConnection, $sql);

                                     if (mysqli_num_rows($result) > 0) 
                                     {
                                        while($row = mysqli_fetch_assoc($result)) 
                                        {
                                            echo "<option value='".$row['Discipline']."'>" . $row['Discipline'] . "</option>";
                                        }
                                     } 
                                     
                                     mysqli_close($MyConnection);
                                    ?>
                                </select>
                            </td>
                            <td id="disp_err"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="button" id="Set_Date" name="Set_Date" class="btn btn-primary button" value="Submit" >
                            </td>
                        </tr>
            </table> 
         
            

        </div>    
    </body>
</html>
