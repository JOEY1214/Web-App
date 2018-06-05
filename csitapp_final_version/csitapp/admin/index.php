<?php
require_once '../php/db.php';
require_once '../php/functions.php';


if (!isset($_SESSION['is_login']) || !$_SESSION['is_login']) {

    header("Location: ../index.php");
}

$user_authority = get_member($_SESSION['login_user_id']);
if ($user_authority['authority'] != 'admin') {

    header("Location: ../index.php");
}

//to get the all mews info
$news = get_all_news();
$events = get_all_events();
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

</head>

<body>

<div id="wrapper">
    <?php include_once 'menu.php'; ?>
    <!-- main page -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Admin Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">News</div>
                            </div>
                        </div>
                    </div>
                    <a href="news.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">Events</div>
                            </div>
                        </div>
                    </div>
                    <a href="events.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">Contacts</div>
                            </div>
                        </div>
                    </div>
                    <a href="contact.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>


        <!-- time line(workload) -->
        <div class="row">
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-clock-o fa-fw"></i> All Timeline(workload)
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <ul class="nav nav-tabs" id="myTabs" role="tablist">
                            <li role="presentation" class="active"><a href="#news_time_line"
                                                                      aria-controls="news_time_line" role="tab"
                                                                      data-toggle="tab">News</a>
                            </li>
                            <li role="presentation"><a href="#events_time_line" aria-controls="events_time_line"
                                                       role="tab" data-toggle="tab">Events</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- news time line -->
                            <div class="tab-pane fade in active" id="news_time_line">
                                <ul class="timeline">
                                    <?php $class = "";
                                    $i = "true"; ?>
                                    <?php if ($news): ?>
                                        <?php foreach ($news as $news): ?>
                                            <li class="<?php echo $class; ?>">
                                                <div class="timeline-badge primary"><i class="fa fa-bar-chart-o"></i>
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $news['title']; ?></h4>
                                                        <p>
                                                            <small class="text-muted"><i
                                                                        class="fa fa-clock-o"></i> <?php echo $news['due_date']; ?>
                                                                (Due date)
                                                            </small>

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
                            <!-- events time line -->
                            <div class="tab-pane fade" id="events_time_line">
                                <ul class="timeline">
                                    <?php $class_event = "";
                                    $j = "true"; ?>
                                    <?php if ($events): ?>
                                        <?php foreach ($events as $events): ?>
                                            <li class="<?php echo $class_event; ?>">
                                                <div class="timeline-badge success"><i class="fa fa-tasks"></i>
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $events['title']; ?></h4>
                                                        <p>
                                                            <small class="text-muted"><i
                                                                        class="fa fa-clock-o"></i> <?php echo $events['start_date']; ?>
                                                                (Start date)
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php if ($j == "true") {
                                                $class_event = "timeline-inverted";
                                                $j = "false";
                                            } else {
                                                $class_event = "";
                                                $j = "true";
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

            <!-- feedback/.col-lg-8 -->
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Feedback
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <form id="feedback">
                                <div class="form-group">
                                    <label>Write down what you want to say.</label>
                                    <textarea id="content" class="form-control" rows="5"></textarea>
                                    <input type="hidden" id="feedback_user"
                                           value="<?PHP echo $user_authority['username']; ?>">
                                </div>
                                <button type="submit" class="list-group-item">Send</button>
                            </form>
                            <!--                            <a href="#" class="list-group-item">-->
                            <!--                                <i class="fa fa-comment fa-fw"></i> New Comment-->
                            <!--                                <span class="pull-right text-muted small"><em>4 minutes ago</em>-->
                            <!--                                                </span>-->
                            <!--                            </a>-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- notification/.col-lg-8 -->
            <!--            <div class="col-lg-4">-->
            <!--                <div class="panel panel-default">-->
            <!--                    <div class="panel-heading">-->
            <!--                        <i class="fa fa-bell fa-fw"></i> Notifications Panel-->
            <!--                    </div>-->
            <!--                    <!-- /.panel-heading -->
            <!--                    <div class="panel-body">-->
            <!--                        <div class="list-group">-->
            <!--                            <a href="#" class="list-group-item">-->
            <!--                                <i class="fa fa-comment fa-fw"></i> New Comment-->
            <!--                                <span class="pull-right text-muted small"><em>4 minutes ago</em>-->
            <!--                                    </span>-->
            <!--                            </a>-->
            <!--
            <!--                        </div>-->
            <!--                        <!-- /.list-group -->
            <!--                        <a href="#" class="btn btn-default btn-block">View All Alerts</a>-->
            <!--                    </div>-->
            <!--                    <!-- /.panel-body -->
            <!--                </div>-->
            <!--                <!-- /.panel -->
            <!-- chat bot -->
            <!--                <div class="chat-panel panel panel-default">-->
            <!--                    <div class="panel-heading">-->
            <!--                        <i class="fa fa-comments fa-fw"></i> Chat-->
            <!--                        <div class="btn-group pull-right">-->
            <!--                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">-->
            <!--                                <i class="fa fa-chevron-down"></i>-->
            <!--                            </button>-->
            <!--                            <ul class="dropdown-menu slidedown">-->
            <!--                                <li>-->
            <!--                                    <a href="#">-->
            <!--                                        <i class="fa fa-refresh fa-fw"></i> Refresh-->
            <!--                                    </a>-->
            <!--                                </li>-->
            <!--                                    <a href="#">-->
            <!--                                        <i class="fa fa-sign-out fa-fw"></i> Sign Out-->
            <!--                                    </a>-->
            <!--                                </li>-->
            <!--                            </ul>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <!-- /.panel-heading -->
            <!--                    <div class="panel-body">-->
            <!--                        <ul class="chat">-->
            <!--                            <li class="left clearfix">-->
            <!--                                    <span class="chat-img pull-left">-->
            <!--                                        <img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"-->
            <!--                                             class="img-circle"/>-->
            <!--                                    </span>-->
            <!--                                <div class="chat-body clearfix">-->
            <!--                                    <div class="header">-->
            <!--                                        <strong class="primary-font">Jack Sparrow</strong>-->
            <!--                                        <small class="pull-right text-muted">-->
            <!--                                            <i class="fa fa-clock-o fa-fw"></i> 12 mins ago-->
            <!--                                        </small>-->
            <!--                                    </div>-->
            <!--                                    <p>-->
            <!--                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum-->
            <!--                                        ornare dolor, quis ullamcorper ligula sodales.-->
            <!--                                    </p>-->
            <!--                                </div>-->
            <!--                            </li>-->
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                    <!-- /.panel-body -->
            <!--                    <div class="panel-footer">-->
            <!--                        <div class="input-group">-->
            <!--                            <input id="btn-input" type="text" class="form-control input-sm"-->
            <!--                                   placeholder="Type your message here..."/>-->
            <!--                            <span class="input-group-btn">-->
            <!--                                    <button class="btn btn-warning btn-sm" id="btn-chat">-->
            <!--                                        Send-->
            <!--                                    </button>-->
            <!--                                </span>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <!-- /.panel-footer -->
            <!--                </div>-->
            <!--                <!-- /.panel .chat-panel -->
            <!--            </div>-->
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Custom Theme JavaScript -->
<script src="../js/sb-admin-2.js"></script>
<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="../vendor/raphael/raphael.min.js"></script>
<script src="../vendor/morrisjs/morris.min.js"></script>
<script src="../js/morris-data.js"></script>


</body>
<script>
    $("").click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>
<script>
    <!-- Post JavaScript -->
    $("#feedback").on("submit", function () {
        //加入loading icon
        $("div.loading").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

        if ($("#content").val() == '') {
            alert("Please write your feedback");

            //清掉 loading icon
            $("div.loading").html('');
        } else {
            //使用 ajax 送出 帳密給 verify_user.php
            $.ajax({
                type: "POST",
                url: "../php/add_feedback.php", //因為此檔案是放在 admin 資料夾內，若要前往 php，就要回上一層 ../ 找到 php 才能進入 add_article.php
                data: {
                    name: $("#feedback_user").val(), //使用者帳號
                    content: $("#content").val() //使用者帳號

                },
                dataType: 'html' //設定該網頁回應的會是 html 格式
            }).done(function (data) {
                //data output test
                console.log(data);
                data = data.replace(/[\r\n]/g, "")
                console.log(data);
                if (data == "yes") {
                    //註冊新增成功，轉跳到登入頁面。
                    alert("Your feedback have been send!!");
                    window.location.href = "index.php";
                }
                else {
                    alert("Something fail to send!");
                }

            }).fail(function (jqXHR, textStatus, errorThrown) {
                //失敗的時候
                alert("Something wrong please check console log");
                console.log(jqXHR.responseText);
            });
        }
        return false;
    });
</script>
</html>

