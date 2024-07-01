<?php 
    require_once('head_html.php'); 
    require_once('../Includes/config.php'); 
    require_once('../Includes/session.php'); 
    require_once('../Includes/admin.php'); 
    if ($logged==false) {
         header("Location:../index.php");
    }
?>
<body>

    <div id="wrapper">

        <?php 
            require_once("nav.php");
            require_once("sidebar.php");
        ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Application
                        </h1>
                        <ol class="breadcrumb">
                          <li>Application</li>
                          <li class="active">Not Processed</li>
                        </ol>
                        </div><!-- /.col-lg-12 -->
                    </div><!-- /.row -->
                    
                            <div class="table-responsive" style="padding-top: 0">
                                <table class="table table-hover table-striped table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Application No.</th>
                                            <th>User</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Process</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $id=$_SESSION['aid'];
                                            $query1 = "SELECT COUNT(application.id) FROM user , application";
                                            $query1.= " WHERE application.uid=user.id AND status='NOT PROCESSED' AND application.aid={$id}";
                                            $result1 = mysqli_query($con,$query1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $numrows = $row1[0];
                                            include("paging1.php");
                                            $result = retrieve_complaints_history($_SESSION['aid'],$offset, $rowsperpage);
                                            while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <tr>
                                                    <td><?php echo 'CA-'.$row['id'] ?></td>
                                                    <td height="50"><?php echo $row['uname'] ?></td>
                                                    <td><?php echo $row['application'] ?></td>
                                                    <td><?php echo $row['status'] ?></td>
                                                    <td width="70">
                                                    <form action="process_application.php" method="post">
                                                        <input type="hidden" name="cid" value=<?php echo $row['id'] ?> >
                                                        <button type="submit" name="complaint_process" class="btn btn-success form-control">PROCESS APPLICATION  </button>
                                                    </form>
                                                        
                                                    </td>
                                                </tr>
                                            <?php 
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <?php include("paging2.php");  ?>
                            </div>
                            <!-- /.table-responsive -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

 <?php 
    require_once("footer.php");
    require_once("js.php");
?>

</body>

</html>
