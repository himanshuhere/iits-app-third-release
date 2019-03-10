
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Manage Students</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
          <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
   <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
<?php include('includes/leftbar.php');?>  

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Manage Students</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Students</li>
            							<li class="active">Manage Students</li>
            						</ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                             

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Send Text Message</h5>
                                                </div>
                                            </div>
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                            <div class="panel-body p-20">

                                                
                                            <div class="main-content2" style="margin-left: 110px;
    font-size: 16px;
    margin-top: 72px;
    margin-top: -113px;
    height: 413px;
    padding: 17px;" id="shadow"> 
             
               


                <table style="margin-top: 74px;
    margin-left: 282px;
    margin-bottom: 22px;">
   


    <form action="manage-results.php" method="post">
    <table border="0" align="center">
        <tr>
            <td colspan="2" align="center">
                <font style="font-weight: bold; font-size: 16px;">Compose message</font>
                <br /><br />
            </td>
        </tr>
        <tr>
            <td valign="top">Recipient: </td>
            <td>
                <textarea name="textAreaRecipient" cols="40" rows="2" style="    width: max-content;
    height: 30px;
    border-radius: 14px;"></textarea>
            </td>
        </tr>
        <tr>
            <td valign="top">Message text: </td>
            <td>
                <textarea name="textAreaMessage" cols="40" rows="10" style="height: 110px;
    border-radius: 14px;"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" value="Send" style="    color: white;
    background-color: #3c3c3c;
    border: none;
    border-radius: 5px;">
            </td>
        </tr>
        <tr><td colspan='2' align='center'>

        </td></tr>
    </table>
</form>
                  
                      
                
       </table>
    </div>
    <?php
    if (isset($_POST["textAreaRecipient"]) && $_POST["textAreaRecipient"] == "")
    {
        echo "<font style=\"color: red; font-weight: bold;\">Recipient field mustn't be empty!</font>";
    }
    else if (isset($_POST["textAreaRecipient"]) && $_POST["textAreaRecipient"] != "")
    {
    try
    {
        connectToDatabase();
        if (insertMessage ($_POST["textAreaRecipient"], "SMS:TEXT", $_POST["textAreaMessage"]))
        {
            echo "<font style=\"color: red; font-weight: bold;\">Insert was successful!</font>";
        }
        closeConnection ();
    }
    catch (Exception $exc)
    {
        echo "Error: " . $exc->getMessage();
    }
}

function insertMessage ($recipient, $messageType, $messageText)
{
    $query = "insert into ozekimessageout (receiver,msgtype,msg,status) ";
    $query .= "values ('" . $recipient . "', '" . $messageType . "', '" . $messageText . "', 'send');";
    $result = mysql_query($query);
    if (!$result)
    {
        echo (mysql_error() . "<br>");
        return false;
    }

    return true;
}

function showOutgoingMessagesInTable()
{
    $query = "select id,sender,receiver,senttime,receivedtime,operator,status,msgtype,msg from ozekimessageout;";
    $result = mysql_query($query);
    if (!$result)
    {
        echo (mysql_error() . "<br>");
        return false;
    }

    try
    {
        echo "<table border='1'>";
        echo "<tr><td>ID</td><td>Sender</td><td>Receiver</td>
        <td>Sent time</td><td>Received time</td><td>Operator</td>";
        echo "<td>Status</td><td>Message type</td><td>Message text</td></tr>";
        while ($row = mysql_fetch_assoc($result))
        {
            echo "<tr>";

            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["sender"] . "</td>";
            echo "<td>" . $row["receiver"] . "</td>";
            echo "<td>" . $row["senttime"] . "</td>";
            echo "<td>" . $row["receivedtime"] . "</td>";
            echo "<td>" . $row["operator"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td>" . $row["msgtype"] . "</td>";
            echo "<td>" . $row["msg"] . "</td>";

            echo "</tr>";
        }
        echo "</table>";
        mysql_free_result($result);
    }
    catch (Exception $exc)
    {
        echo (mysql_error() . "<br>");
        return false;
    }

    return true;
}
?>
                                         
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->

                                                               
                                                </div>
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                    

                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
        </script>
    </body>
</html>
<?php } ?>

