<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else if(isset($_POST['submit']))
{


$studentid = $_POST['studentid']; 
$feeamt = $_POST['feeamt'];

$error = " ";
$error1 = " ";
$rem = 0;


    $sql="SELECT * from tblstudents where StudentId='$studentid'";
    
    $q = $dbh->prepare($sql);
    $q->execute(['%son']);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    $r = $q->fetch();
        if ($r >= 1) {
                    //$r = $q->fetch();
                    $fees = $r['fees'];
                    $due = $r['due'];
                    $paidr = $r['paid'];
                   
                    $paid = $paidr + $feeamt;
                    $rem = $fees - $paid;
                    

    
                // $sql2 = "UPDATE tblstudents SET  due = '$rem' WHERE StudentId = '$studentid' ;";
                // $dbh->query($sql2);
                // $sql3 = "UPDATE tblstudents SET  paid = '$feeamt' WHERE StudentId = '$studentid' ;";
                // $dbh->query($sql3);


                $sql2 = "UPDATE tblstudents SET due = :rem, paid = :paid  WHERE StudentId = :studentid";
                $stmt = $dbh->prepare($sql2);                                  
                $stmt->bindParam(':rem', $rem , PDO::PARAM_STR);       
                $stmt->bindParam(':paid', $paid , PDO::PARAM_STR);    
                $stmt->bindParam(':studentid', $studentid , PDO::PARAM_STR);
                // use PARAM_STR although a number   
                $stmt->execute(); 
               
        }
       else{
            $error = "Student with unique Id"." ".$studentid." "."not present in database. Please re-check entered Id";
            
        }
      // echo "<table><tr><td>".$row["fname"]."</td><td>".$row["lname"] ."</td><td>".$row["dob"]."</td><td>".$row["email"]."</td><td>".$row["phone"]."</td><td>".$row["clg"]."</td><td>".$row["batch"]."</td><td>".$row["course"]."</td></tr>";
        
       // echo "</table>";

//  $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName,tblsubjects.id FROM tblsubjectcombination join  tblsubjects on  tblsubjects.id=tblsubjectcombination.SubjectId WHERE tblsubjectcombination.ClassId=:cid order by tblsubjects.SubjectName");
//  $stmt->execute(array(':cid' => $class));
//   $sid1=array();
//  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
//  {

// array_push($sid1,$row['id']);
//    } 
  
// for($i=0;$i<count($mark);$i++){
//     $mar=$mark[$i];
//   $sid=$sid1[$i];
// $sql="INSERT INTO  tblresult(StudentId,ClassId,SubjectId,marks) VALUES(:studentid,:class,:sid,:marks)";
// $query = $dbh->prepare($sql);
// $query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
// $query->bindParam(':class',$class,PDO::PARAM_STR);
// $query->bindParam(':sid',$sid,PDO::PARAM_STR);
// $query->bindParam(':marks',$mar,PDO::PARAM_STR);
// $query->execute();
// $lastInsertId = $dbh->lastInsertId();
// if($lastInsertId)
// {
// $msg="Result info added successfully";
// }
// else 
// {
// $error="Something went wrong. Please try again";
// }
// }
}
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Admin| Fee </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
        <script>
// function getStudent(val) {
//     $.ajax({
//     type: "POST",
//     url: "get_student.php",
//     data:'classid='+val,
//     success: function(data){
//         $("#studentid").html(data);
        
//     }
//     });
// $.ajax({
//         type: "POST",
//         url: "get_student.php",
//         data:'classid1='+val,
//         success: function(data){
//             $("#subject").html(data);
            
//         }
//         });
// }
//     </script>
<!-- <script>

function getresult(val,clid) 
{   
    
var clid=$(".clid").val();
var val=$(".stid").val();;
var abh=clid+'$'+val;
//alert(abh);
    $.ajax({
        type: "POST",
        url: "get_student.php",
        data:'studclass='+abh,
        success: function(data){
            $("#reslt").html(data);
            
        }
        });
}
</script> -->


    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Fee Payment</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                
                                        <li class="active">Student Fees</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                           
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-horizontal" method="post" action="add-result.php">

 <div class="form-group">
<label for="default" class="col-sm-2 control-label">Student</label>
 <div class="col-sm-10">

 <select name="studentid" class="form-control clid" id="classid" onChange="getStudent(this.value);" required="required">
<option value="">Select Student</option>

<?php $sql = "SELECT * from tblstudents";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<option value="<?php echo htmlentities($result->StudentId); ?> "><?php echo htmlentities($result->StudentId); ?> ::: <?php echo htmlentities($result->RollId); ?>&nbsp; ::: <?php echo htmlentities($result->StudentName); ?></option>
<?php }} ?>
 </select>
                                                        </div>
                                                    </div>
<div class="form-group">
                                                        <!-- <label for="date" class="col-sm-2 control-label ">Student Name</label>
                                                        <div class="col-sm-10">
                                                    <select name="studentid" class="form-control stid" id="studentid" required="required" onChange="getresult(this.value);">
                                                    </select> -->
                                                        </div>
                                                    <!-- </div>

                                                    <div class="form-group">
                                                      
                                                        <div class="col-sm-10">
                                                    <div  id="reslt">
                                                    </div>
                                                        </div>
                                                    </div>
                                                     -->
 <div class="form-group">
                                                        <label for="date" class="col-sm-2 control-label">Fees Amount</label>
                                                        <input type="number" name="feeamt" placeholder="e.g.,5000" style="width: 20%;
    height: 34px;
    padding: 6px 12px;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;" required>
                                                        <div class="col-sm-10">
                                                    <div  id="subject">
                                                    </div>
                                                        </div>
                                                    </div>


                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit Fee</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    </body>
</html>
<?PHP  ?>
