
<?php
require_once "config.php";
?>



<html>
    <head>
        <meta charset="UTF-8">
        <title>Review Committee - Login</title>
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
                $("#Login").click(function () 
                {
                   
                    var username = $.trim($('#username').val());
                    var password = $.trim($('#password').val());
                    
                       
                        if(username === '')
                        {
                            $('#name_err').empty();
                            $('#name_err').append('<span style="color:red;">Enter Username</span>');
                        }
                        else
                        {
                            $('#name_err').empty();
                            if(password === '')
                            {
                                $('#passwd_err').empty();
                                $('#passwd_err').append('<span style="color:red;">Enter Password</span>');
                            }
                            else
                            {
                                $('#passwd_err').empty();
                                $.ajax
                                ({
                                type: 'POST',
                                url: 'Check_RC_Login.php',
                                data: { username: username ,password: password},
                                success: function(response) {
                                     var result = JSON.parse(response);
                                     if(result.status === "S")
                                     {
                                         alert(result.msg);
                                         window.location.href="RC_Uploaded_Doc.php";
                                     }
                                     else
                                     {
                                         alert(result.msg);
                                    }
                                }
                            });

                            }
                        }
                    

                });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2>Review Committee - Login</h2>
            <p style="color:brown;">Please fill in your credentials to login.</p>

            <table class="table" style="font-weight:bolder;background-image: linear-gradient(to right, whitesmoke , skyblue);">
                        
                        <tr>
                            <td>Employee ID<span class="error"> * </span></td>
                            <td style="width:65%;">
                                 <input type="text" id="username" name="username" class="form-control" style="text-transform:uppercase;">
                            </td>
                            <td id="name_err"></td>
                        </tr>
                        <tr>
                            <td>Password<span class="error"> * </span></td>
                            <td style="width:65%;">
                                 <input type="password" id="password" name="password" class="form-control">
                            </td>
                            <td id="passwd_err"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="submit" id="Login" name="Login" class="btn btn-primary button" value="Login" >
                            </td>
                        </tr>
            </table> 
         
            

        </div>    
    </body>
</html>
