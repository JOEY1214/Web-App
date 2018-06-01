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

//to get the all contacts info
$contacts = get_all_contacts();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">
    <?php include_once 'menu.php'; ?>
    <!-- Navigation -->

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Contact Management</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <h4><strong>Contact List</strong></h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <a class="btn btn-default btn-lg btn-block" href="contact_add.php">Add Contact</a>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline"
                                   id="events-table">
                                <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Office</th>
                                    <th>Staff Name</th>
                                    <th>Identity</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($contacts): ?>
                                    <?php foreach ($contacts as $contacts): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $contacts['department']; ?></td>
                                            <td><?php echo $contacts['office_address']; ?></td>
                                            <td><?php echo $contacts['name']; ?></td>
                                            <td><?php echo $contacts['identity']; ?></td>
                                            <td><?php echo $contacts['phone']; ?></td>
                                            <td><?php echo $contacts['email']; ?></td>
                                            <td><a href="contact_edit.php?i=<?php echo $contacts['id']; ?>"
                                                   class="btn btn-primary btn-circle fa fa-edit"></a>
                                                <a href="javascript:void(0);"
                                                   class="btn btn-danger btn-circle fa fa-times" id="del_news"
                                                   data-id="<?php echo $contacts['id']; ?>"></a>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->


</body>
<script>
    $(document).ready(function () {
        $('#events-table').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#members-table').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function () {

        //表單送出
        $("a.btn-danger").on("click", function () {
            //宣告變數
            var c = confirm("Do you want delete this contact?"),
                this_tr = $(this).parent().parent();
            if (c) {
                $.ajax({
                    type: "POST",
                    url: "../php/del_contact.php",
                    data: {
                        id: $(this).attr("data-id") //文章id
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function (data) {
                    //data output test
                    console.log(data);
                    data = data.replace(/[\r\n]/g, "")
                    console.log(data);

                    if (data == "yes") {
                        //註冊新增成功，轉跳到登入頁面。
                        alert("Delete successful!");
                        this_tr.fadeOut();
                    }


                }).fail(function (jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
            }


            return false;
        });
    });
</script>
</html>
