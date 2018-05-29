<?php
require_once '../php/db.php';
require_once '../php/functions.php';


//if (!isset($_SESSION['is_login']) || !$_SESSION['is_login']) {
//
//    header("Location: ../index.php");
//}
//
//$user_authority = get_member($_SESSION['login_user_id']);
//if ($user_authority['authority'] != 'owner') {
//
//    header("Location: ../index.php");
//}

//to get the all contacts info
$staff = get_all_staffs();
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

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


</head>

<body>

<div id="wrapper">
    <?php include_once 'menu_owner.php'; ?>
    <!-- main page -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Staff Management</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>


        <!-- time line(workload) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-yellow">
                    <div class="panel-heading ">
                        <h4><strong>Staff List</strong></h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline"
                                   id="news-table">
                                <thead>
                                <tr>
                                    <th>Sign Up Date</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Authority</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($staff): ?>
                                    <?php foreach ($staff as $staff): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $staff['sign_up_date']; ?></td>
                                            <td><?php echo $staff['username']; ?></td>
                                            <td><?php echo $staff['nickname']; ?></td>
                                            <td>
                                                <select class="form-control" id="authority_<?php echo $staff['id']; ?>">
                                                    <option value="visitor" <?php echo ($staff['authority'] == "visitor") ? "selected" : ""; ?>>
                                                        Visitor
                                                    </option>
                                                    <option value="staff" <?php echo ($staff['authority'] == "staff") ? "selected" : ""; ?>>
                                                        Staff
                                                    </option>
                                                    <option value="admin" <?php echo ($staff['authority'] == "admin") ? "selected" : ""; ?>>
                                                        Admin
                                                    </option>
                                                    <option value="owner" <?php echo ($staff['authority'] == "owner") ? "selected" : ""; ?>>
                                                        Owner
                                                    </option>
                                                </select>
                                            </td>
                                            <td><a href="javascript:void(0);"
                                                   class="btn btn-primary btn-circle fa fa-save" id="save_authority"
                                                   data-id="<?php echo $staff['id']; ?>"
                                                   data-authority="authority_<?php echo $staff['id']; ?>"</a>
                                                <a href="javascript:void(0);"
                                                   class="btn btn-danger btn-circle fa fa-times" id="del_authority"
                                                   data-id="<?php echo $staff['id']; ?>"></a>
                                            </td>
                                            <!--                                            </form>-->
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


</body>
<script>
    $(document).ready(function () {
        $('#news-table').DataTable({
            responsive: true
        });
    });
</script>

<script>
    //change authority function
    $(document).ready(function () {
        $("a.btn-primary").on("click", function () {

            var select_value =document.getElementById($(this).attr("data-authority")) ;
            var index = select_value.selectedIndex;



            console.log(index);
            console.log(select_value.options[index].value);
            console.log($(this).attr("data-id"));

            //宣告變數
            var c = confirm("Do you want change this staff?"),
                this_tr = $(this).parent().parent();
            if (c) {
                $.ajax({
                    type: "POST",
                    url: "../php/upload_staff.php",
                    data: {
                        id: $(this).attr("data-id"), //文章id
                        authority: select_value.options[index].value
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function (data) {
                    //data output test
                    console.log(data);
                    data = data.replace(/[\r\n]/g, "")
                    console.log(data);

                    if (data == "yes") {
                        //註冊新增成功，轉跳到登入頁面。
                        alert("Staff's authority has been changed!");
                        window.location.href = "owner_staff_management.php";
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
<script>
    //delete staff function
    $(document).ready(function () {
        //表單送出
        $("a.btn-danger").on("click", function () {
            //宣告變數
            var c = confirm("Do you want delete this staff?"),
                this_tr = $(this).parent().parent();
            if (c) {
                $.ajax({
                    type: "POST",
                    url: "../php/del_staff.php",
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
                        alert("Delete successful!!");
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

