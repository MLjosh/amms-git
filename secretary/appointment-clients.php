<!--
=========================================================
* * Black Dashboard - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/black-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)


* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ODABSaid']==0)) {
  header('location:logout.php');
  } 

if(ISSET($_POST['update'])){
    $user_id = $_POST['user_id'];
    $doctors = $_POST['doctors'];
    $status = $_POST['status'];
    $work = $_POST['work'];



$adid=$_SESSION['ODABSaid'];
    $logquery=mysqli_query($con,"Select UserName from tblsecretary where ID='$adid'");
    $reslog=mysqli_fetch_array($logquery);
    $logname=$reslog['UserName'];

    $logquery2=mysqli_query($con,"Select Name from tblappointment where ID='$user_id'");
    $reslog2=mysqli_fetch_array($logquery2);
    $logname2=$reslog2['Name'];


    mysqli_query($con,"insert into tbluserlogs (Status) value('$logname - Updated an appointment for $logname2 ')");


    $mquery=mysqli_query($con, "UPDATE `tblappointment` SET `doctors` = '$doctors',`Status` = '$status',`Mark` = '$work' WHERE `ID` = '$user_id'");
    if ($mquery) {
      
 
      }

      

    }
 


     ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/images/logo/favicon.png">
  <title>
    AMM ADMIN
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />

    <!-- jquery table. -->
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" />
</head>

<body class="white-content">
  <div class="wrapper">
    <div class="sidebar" style="background: #0008ff;">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
            <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="./dashboard.php">
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <li>
            <a href="./appointment-clients2.php">
              <i class="tim-icons icon-badge"></i>
              <p>Appointment</p>
            </a>
          </li>

             <li class="active">
            <a href="./appointment-clients.php">
              <i class="tim-icons icon-single-copy-04"></i>
              <p>All Appointment</p>
            </a>
          </li>

          <li>
            <a href="./all-clients.php">
              <i class="tim-icons icon-single-02"></i>
              <p>Clients</p>
            </a>
          </li>



        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include('extend-navbar.php'); ?>
      <!-- End Navbar -->

      <div class="content">

<!-- Your appointment status -->


<div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h2 class="card-title">All Pending Appointment</h2>
                <p class="category">Here is the list of all pending appointment.</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table tablesorter " id="example3">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Appointment No.
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          Service
                        </th>
                        <th>
                          Date
                        </th>
                        <th>
                          Time
                        </th>
                        <th>
                          Status
                        </th>
                        <th>
                          Work
                        </th>
                        <th class="text-center">
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

            $ret=mysqli_query($con,"select * from  tblappointment where Status='1' && Mark='' order by AptDate ASC");

            $cnt=1;
            while ($row=mysqli_fetch_array($ret)) {

            ?>

                      <tr>
                        <th scope="row">
                          <?php echo $cnt;?>
                        </th>

                        <td>
                          <?php  echo $row['AptNumber'];?>
                        </td>
                        <td>
                          <?php
                          $str=$row['Name'];
                          if (strlen($str) > 15)
                          $str = substr($str, 0, 15) . '...';
                          echo $str;
                          ?>
                        </td>
                        <td>
                          <?php  echo $row['Services'];?>
                        </td>
                        <td>
              <?php  
              $aptdate=$row['AptDate'];
              $date=date_create("$aptdate");
              echo date_format($date,"F j, Y");
              ?>
                        </td>
                        <td>
                          <?php

              $time=$row['AptTime'];

              $newDateTime = date('h:i A', strtotime($time));

               echo $newDateTime;
              ?>
                        </td>
                        
                          <td>
                          <?php 
                          $stats=$row['Status'];
                          if ($stats=='1') {
                            echo 'ACCEPTED';
                          } elseif ($stats=='2') {
                            echo 'REJECTED';
                          }  ?>
                        </td>
                        <td>
                          <?php 
                          $work=$row['Mark'];
                          if ($work=='') {
                            echo 'PENDING';
                          }elseif ($work=='1') {
                            echo 'DONE';
                          }
                            ?>
                        </td>
      
                        <td class="text-center">
                          <button type="button" class="btn btn-link text-warning" data-backdrop="static" data-keyboard="false" data-target="#update_modal2<?php echo $row['ID']?>" data-toggle="modal"><i class="tim-icons icon-zoom-split text-primary"></i></button>

                           <button type="button" class="btn btn-link text-warning" data-backdrop="static" data-keyboard="false" data-target="#update_modal3<?php echo $row['ID']?>" data-toggle="modal"><i class="fas fa-edit"></i></button>

                          <button class="btn btn-link" data-target="#modal_delete2<?php echo $row['ID']?>" data-toggle="modal" ><i class="tim-icons icon-trash-simple text-danger"></i></i></button>
                        </td>
                      </tr>

<?php include('view-appointment-clients-all.php'); ?>
<?php include('update-appointment-clients-all.php'); ?>
<div class="modal hide" id="modal_delete2<?php echo $row['ID']?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h3 class="modal-title">Delete Appointment</h3>
        </div>
        <div class="modal-body">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="form-group">
              <label>Are you sure you want to delete this Appointment?</label>
          </div>
        </div>
        <div style="clear:both;"></div>
        <div class="modal-footer">
          <a type="button" class="btn btn-danger" href="delete-appointment-clients-all.php?mem_id=<?php echo $row['ID']?>">Yes</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>

                      <?php 
              $cnt=$cnt+1;
              }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>




<div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h2 class="card-title">All Finish Appointments</h2>
                <p class="category">Here is the list of all Done appointment.</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table tablesorter " id="example4">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Appointment No.
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          Service
                        </th>
                        <th>
                          Date
                        </th>
                        <th>
                          Time
                        </th>
                        <th>
                          Status
                        </th>
                        <th>
                          Work
                        </th>
                        <th class="text-center">
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

            $ret=mysqli_query($con,"select * from  tblappointment where Status='1' && Mark='1' order by AptDate ASC");

            $cnt=1;
            while ($row=mysqli_fetch_array($ret)) {

            ?>

                      <tr>
                        <th scope="row">
                          <?php echo $cnt;?>
                        </th>

                        <td>
                          <?php  echo $row['AptNumber'];?>
                        </td>
                        <td>
                          <?php
                          $str=$row['Name'];
                          if (strlen($str) > 15)
                          $str = substr($str, 0, 15) . '...';
                          echo $str;
                          ?>
                        </td>
                        <td>
                          <?php  echo $row['Services'];?>
                        </td>
                        <td>
              <?php  
              $aptdate=$row['AptDate'];
              $date=date_create("$aptdate");
              echo date_format($date,"F j, Y");
              ?>
                        </td>
                        <td>
                          <?php

              $time=$row['AptTime'];

              $newDateTime = date('h:i A', strtotime($time));

               echo $newDateTime;
              ?>
                        </td>
                        
                          <td>
                          <?php 
                          $stats=$row['Status'];
                          if ($stats=='1') {
                            echo 'ACCEPTED';
                          } elseif ($stats=='2') {
                            echo 'REJECTED';
                          }  ?>
                        </td>
                        <td>
                          <?php 
                          $work=$row['Mark'];
                          if ($work=='') {
                            echo 'PENDING';
                          }elseif ($work=='1') {
                            echo 'DONE';
                          }
                            ?>
                        </td>
      
                        <td class="text-center">
                          <button type="button" class="btn btn-link text-warning" data-backdrop="static" data-keyboard="false" data-target="#update_modal2<?php echo $row['ID']?>" data-toggle="modal"><i class="tim-icons icon-zoom-split text-primary"></i></button>

                           <button type="button" class="btn btn-link text-warning" data-backdrop="static" data-keyboard="false" data-target="#update_modal3<?php echo $row['ID']?>" data-toggle="modal"><i class="fas fa-edit"></i></button>

                          <button class="btn btn-link" data-target="#modal_delete2<?php echo $row['ID']?>" data-toggle="modal" ><i class="tim-icons icon-trash-simple text-danger"></i></i></button>
                        </td>
                      </tr>

<?php include('view-appointment-clients-all.php'); ?>
<?php include('update-appointment-clients-all.php'); ?>
<div class="modal hide" id="modal_delete2<?php echo $row['ID']?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h3 class="modal-title">Delete Appointment</h3>
        </div>
        <div class="modal-body">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="form-group">
              <label>Are you sure you want to delete this Appointment?</label>
          </div>
        </div>
        <div style="clear:both;"></div>
        <div class="modal-footer">
          <a type="button" class="btn btn-danger" href="delete-appointment-clients-all.php?mem_id=<?php echo $row['ID']?>">Yes</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>

                      <?php 
              $cnt=$cnt+1;
              }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        





        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h2 class="card-title">Rejected Appointment</h2>
                <p class="category">Here is the list all Cancelled appointment.</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table tablesorter " id="example2">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Appointment No.
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          Service
                        </th>
                        <th>
                          Date
                        </th>
                        <th>
                          Time
                        </th>
                        <th>
                          Status
                        </th>
                        <th class="text-center">
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

            $ret=mysqli_query($con,"select * from  tblappointment where Status='2' order by ApplyDate DESC");

            $cntt=1;
            while ($row=mysqli_fetch_array($ret)) {

            ?>

                      <tr>
                        <th scope="row">
                          <?php echo $cntt;?>
                        </th>

                        <td>
                          <?php  echo $row['AptNumber'];?>
                        </td>
                        <td>
                          <?php
                          $str=$row['Name'];
                          if (strlen($str) > 15)
                          $str = substr($str, 0, 15) . '...';
                          echo $str;
                          ?>
                        </td>
                        <td>
                          <?php  echo $row['Services'];?>
                        </td>
                        <td>
              <?php  
              $aptdate=$row['AptDate'];
              $date=date_create("$aptdate");
              echo date_format($date,"F j, Y");
              ?>
                        </td>
                        <td>
                          <?php

              $time=$row['AptTime'];

              $newDateTime = date('h:i A', strtotime($time));

               echo $newDateTime;
              ?>
                        </td>
                        
                          <td>
                          <?php 
                          $stats=$row['Status'];
                          if ($stats=='1') {
                            echo 'ACCEPTED';
                          } elseif ($stats=='2') {
                            echo 'REJECTED';
                          }  ?>
                        </td>
      
                        <td class="text-center">
                          <button type="button" class="btn btn-link text-warning" data-backdrop="static" data-keyboard="false" data-target="#update_modal<?php echo $row['ID']?>" data-toggle="modal"><i class="tim-icons icon-zoom-split text-primary"></i></button>

                          <button type="button" class="btn btn-link text-warning" data-backdrop="static" data-keyboard="false" data-target="#update_modal3<?php echo $row['ID']?>" data-toggle="modal"><i class="fas fa-edit"></i></button>

                          <button class="btn btn-link" data-target="#modal_delete<?php echo $row['ID']?>" data-toggle="modal" ><i class="tim-icons icon-trash-simple text-danger"></i></i></button>
                        </td>
                      </tr>

<?php include('view-appointment-clients-cancelled.php'); ?>
<?php include('update-appointment-clients-all.php'); ?>

<div class="modal hide" id="modal_delete<?php echo $row['ID']?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h3 class="modal-title">Delete Appointment</h3>
        </div>
        <div class="modal-body">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="form-group">
              <label>Are you sure you want to delete this Appointment?</label>
          </div>
        </div>
        <div style="clear:both;"></div>
        <div class="modal-footer">
          <a type="button" class="btn btn-danger" href="delete-appointment-clients-cancelled.php?mem_id=<?php echo $row['ID']?>">Yes</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>


                      <?php 
              $cntt=$cntt+1;
              }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>




<div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h2 class="card-title">All Appointments</h2>
                <p class="category">Here is the list of all appointment.</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table tablesorter " id="example">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Appointment No.
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          Service
                        </th>
                        <th>
                          Date
                        </th>
                        <th>
                          Time
                        </th>
                        <th>
                          Status
                        </th>
                        <th>
                          Work
                        </th>
                        <th class="text-center">
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

            $ret=mysqli_query($con,"select * from  tblappointment order by AptDate ASC");

            $cnt=1;
            while ($row=mysqli_fetch_array($ret)) {

            ?>

                      <tr>
                        <th scope="row">
                          <?php echo $cnt;?>
                        </th>

                        <td>
                          <?php  echo $row['AptNumber'];?>
                        </td>
                        <td>
                          <?php
                          $str=$row['Name'];
                          if (strlen($str) > 15)
                          $str = substr($str, 0, 15) . '...';
                          echo $str;
                          ?>
                        </td>
                        <td>
                          <?php  echo $row['Services'];?>
                        </td>
                        <td>
              <?php  
              $aptdate=$row['AptDate'];
              $date=date_create("$aptdate");
              echo date_format($date,"F j, Y");
              ?>
                        </td>
                        <td>
                          <?php

              $time=$row['AptTime'];

              $newDateTime = date('h:i A', strtotime($time));

               echo $newDateTime;
              ?>
                        </td>
                        
                          <td>
                          <?php 
                          $stats=$row['Status'];
                          if ($stats=='1') {
                            echo 'ACCEPTED';
                          } elseif ($stats=='2') {
                            echo 'REJECTED';
                          }  ?>
                        </td>
                        <td>
                          <?php 
                          $stats=$row['Status'];
                          if($stats=='2'){
                            echo 'N/A';
                          }elseif($stats=='1'){
                          $work=$row['Mark'];
                          if ($work=='') {
                            echo 'PENDING';
                          }elseif ($work=='1') {
                            echo 'DONE';
                          }
                          }

                           ?>
                        </td>
      
                        <td class="text-center">
                          <button type="button" class="btn btn-link text-warning" data-backdrop="static" data-keyboard="false" data-target="#update_modal2<?php echo $row['ID']?>" data-toggle="modal"><i class="tim-icons icon-zoom-split text-primary"></i></button>

                           <button type="button" class="btn btn-link text-warning" data-backdrop="static" data-keyboard="false" data-target="#update_modal3<?php echo $row['ID']?>" data-toggle="modal"><i class="fas fa-edit"></i></button>

                          <button class="btn btn-link" data-target="#modal_delete2<?php echo $row['ID']?>" data-toggle="modal" ><i class="tim-icons icon-trash-simple text-danger"></i></i></button>
                        </td>
                      </tr>

<?php include('view-appointment-clients-all.php'); ?>
<?php include('update-appointment-clients-all.php'); ?>
<div class="modal hide" id="modal_delete2<?php echo $row['ID']?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h3 class="modal-title">Delete Appointment</h3>
        </div>
        <div class="modal-body">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="form-group">
              <label>Are you sure you want to delete this Appointment?</label>
          </div>
        </div>
        <div style="clear:both;"></div>
        <div class="modal-footer">
          <a type="button" class="btn btn-danger" href="delete-appointment-clients-all.php?mem_id=<?php echo $row['ID']?>">Yes</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>

                      <?php 
              $cnt=$cnt+1;
              }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>








      </div>





        <!--   footer   -->

        <?php include('extend-footer.php'); ?>

        <!--   end of footer   -->
    </div>
  </div>


  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script src="darkmode-script.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });
  </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
  $(document).ready(function() {
    $('#example').DataTable();
});
</script>
 <script>
  $(document).ready(function() {
    $('#example2').DataTable();
});
</script>
 <script>
  $(document).ready(function() {
    $('#example3').DataTable();
});
</script>
 <script>
  $(document).ready(function() {
    $('#example4').DataTable();
});
</script>
</body>

</html>
