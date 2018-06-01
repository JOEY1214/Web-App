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

//to get the all mews info
$news_percentage = get_percentage_news();
$events_percentage = get_percentage_events();

//news bar info
$news_past_two = get_number_news_month(date('m') - 2);
$news_past_one = get_number_news_month(date('m') - 1);
$news_current = get_number_news_month(date('m'));
$news_future_one = get_number_news_month(date('m') + 1);
$news_future_two = get_number_news_month(date('m') + 2);

//event bar info
$events_past_two = get_number_events_month(date('m') - 2);
$events_past_one = get_number_events_month(date('m') - 1);
$events_current = get_number_events_month(date('m'));
$events_future_one = get_number_events_month(date('m') + 1);
$events_future_two = get_number_events_month(date('m') + 2);
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
                <h1 class="page-header">Owner Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>


        <!-- time line(workload) -->
        <h3 class="page-header">Publish - Usage</h3>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Monthly-Chart(between news and events)
                    </div>
                    <div class="panel-body">
                        <div id="area"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Totally-Chart(between news and events)
                    </div>
                    <div class="panel-body">
                        <div id="graph"></div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
        <h3 class="page-header">App - Usage</h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Monthly-Chart Of Login Usage(Staff)
                    </div>
                    <div class="panel-body">
                        <div id="bar"></div>
                    </div>
                </div>
            </div>
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
<script>
    new Morris.Donut({
        element: 'graph',
        data: [
            {value: <?php echo $news_percentage; ?>, label: 'News'},
            {value: <?php echo $events_percentage; ?>, label: 'Events'}
        ],
        backgroundColor: '#ccc',
        labelColor: '#000000',
        colors: [
            '#337ab7',
            '#5cb85c'
        ],
        formatter: function (x) {
            return x + "%"
        }
    }).on('click', function (i, row) {
        console.log(i, row);
    });
</script>
<script>
    new Morris.Area({
        element: 'area',
        data: [
            {
                x: '2018-' +<?php echo date('m') - 2; ?>,
                y: <?php echo $news_past_two; ?>,
                z: <?php echo $events_past_two; ?>},
            {
                x: '2018-' +<?php echo date('m') - 1; ?>,
                y: <?php echo $news_past_one; ?>,
                z: <?php echo $events_past_one; ?>},
            {x: '2018-' +<?php echo date('m'); ?>, y: <?php echo $news_current; ?>, z: <?php echo $events_current; ?>},
            {
                x: '2018-' +<?php echo date('m') + 1; ?>,
                y: <?php echo $news_future_one; ?>,
                z: <?php echo $events_future_one; ?>},
            {
                x: '2018-' +<?php echo date('m') + 2; ?>,
                y: <?php echo $news_future_two; ?>,
                z: <?php echo $events_future_two; ?>}
        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['News', 'Event']
    }).on('click', function (i, row) {
        console.log(i, row);
    });
</script>
<script>
    new Morris.Bar({
        element: 'bar',
        data: [
            {x: '2018-1', y: 15},
            {x: '2018-2', y: 11},
            {x: '2018-3', y: 12},
            {x: '2018-4', y: 13},
            {x: '2018-5', y: 14},
            {x: '2018-6', y: 15},
            {x: '2018-7', y: 17}
        ],
        xkey: 'x',
        ykeys: ['y'],
        labels: ['Y'],
        barColors: function (row, series, type) {
            if (type === 'bar') {
                var red = Math.ceil(255 * row.y / this.ymax);
                return 'rgb(' + red + ',0,0)';
            }
            else {
                return '#000';
            }
        }
    });
</script>

</html>

