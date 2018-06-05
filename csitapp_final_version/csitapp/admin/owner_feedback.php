<?php
require_once '../php/db.php';
require_once '../php/functions.php';
require_once '../php/data_calculation.php';

if (!isset($_SESSION['is_login']) || !$_SESSION['is_login']) {

    header("Location: ../index.php");
}

$user_authority = get_member($_SESSION['login_user_id']);
if ($user_authority['authority'] != 'owner') {

    header("Location: ../index.php");
}

$feedback = get_all_feedback();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RMIT - CSIT Event Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>


</head>

<body>

<div id="wrapper">
    <?php include_once 'menu_owner.php'; ?>
    <!-- main page -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User Feedback</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>


        <!-- feedback time line -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-clock-o fa-fw"></i> Feedback Timeline
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <ul class="nav nav-tabs" id="myTabs" role="tablist">
                            <li role="presentation" class="active"><a href="#news_time_line"
                                                                      aria-controls="news_time_line" role="tab"
                                                                      data-toggle="tab">user feedback</a>
                        </ul>
                        <div class="tab-content">
                            <!-- news time line -->
                            <div class="tab-pane fade in active" id="news_time_line">
                                <ul class="timeline">
                                    <?php $class = "";
                                    $i = "true"; ?>
                                    <?php if ($feedback): ?>
                                        <?php foreach ($feedback as $feedback): ?>
                                            <li class="<?php echo $class; ?>">
                                                <div class="timeline-badge default"><i class="fa fa-envelope-o"></i>
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $feedback['username']; ?></h4>
                                                        <p>
                                                            <small class="text-muted"><i
                                                                        class="fa fa-clock-o"></i> <?php echo $feedback['create_date']; ?>
                                                            </small>

                                                        </p>
                                                        <p>
                                                            <?php echo $feedback['content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php if ($i == "true") {
                                                $class = "timeline-inverted";
                                                $i = "false";
                                            } else {
                                                $class = "";
                                                $i = "true";
                                            }
                                            ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <!-- tab-content -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- Bootstrap Core JavaScript-->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>


</body>
</html>