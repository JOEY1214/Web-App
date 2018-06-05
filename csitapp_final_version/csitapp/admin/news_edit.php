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
$news_edit = get_news($_GET['i']);
if (is_null($news_edit)) {
    //如果文章是null就轉回列表頁
    header("Location: news.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>News Detail</title>

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

    <![endif]-->
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css"/>

    <!-- Edit CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/froala_editor.css">
    <link rel="stylesheet" href="../css/froala_style.css">
    <link rel="stylesheet" href="../css/plugins/code_view.css">
    <link rel="stylesheet" href="../css/plugins/colors.css">
    <link rel="stylesheet" href="../css/plugins/emoticons.css">
    <link rel="stylesheet" href="../css/plugins/image_manager.css">
    <link rel="stylesheet" href="../css/plugins/image.css">
    <link rel="stylesheet" href="../css/plugins/line_breaker.css">
    <link rel="stylesheet" href="../css/plugins/table.css">
    <link rel="stylesheet" href="../css/plugins/video.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
    <!-- Include At.JS style. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/at.js/1.4.0/css/jquery.atwho.min.css">
    <style>
        div#editor {
            width: 100%;
            margin: auto;
            text-align: left;
        }
    </style>
    <style type="text/css">
        div.show_image img {
            width: 200px;
        }
    </style>
</head>

<body>
<div id="wrapper">
    <!-- Navigation -->
    <?php include_once 'menu.php'; ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update news: <?php echo $news_edit['title']; ?></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <br>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="edit_event_form" role="form">
                                    <input type="hidden" id="id" value="<?php echo $news_edit['id']; ?>">
                                    <div class="form-group">
                                        <h4>Title of News</h4>
                                        <input id="title" class="form-control"
                                               value="<?php echo $news_edit['title']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <h4>Category</h4>
                                        <select id="category" class="form-control">
                                            <option value="General" <?php echo ($news_edit['category'] == "General") ? "selected" : ""; ?>>
                                                General
                                            </option>
                                            <option value="Teaching" <?php echo ($news_edit['category'] == "Teaching") ? "selected" : ""; ?>>
                                                Teaching
                                            </option>
                                            <option value="Research" <?php echo ($news_edit['category'] == "Research") ? "selected" : ""; ?>>
                                                Research
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h4>Due date of news</h4>
                                        <input id="datepicker" class="form-control"
                                               value="<?php echo $news_edit['due_date']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Picture</label>
                                        <input type="file" name="image_path" class="image"
                                               accept="image/gif, image/jpeg, image/png">
                                        <br>
                                        <input type="hidden" id="image_path"
                                               value="<?php echo ($news_edit['image_path']) ? $news_edit['image_path'] : ''; ?>">
                                        <div class="show_image">
                                            <?php if ($news_edit['image_path'] && file_exists("../" . $news_edit['image_path'])): ?>
                                                <img src='<?php echo "../" . $news_edit['image_path']; ?>'>
                                            <?php endif; ?>
                                        </div>

                                        <a href='javascript:void(0);' class="del_image btn btn-default">Delete</a>
                                    </div>
                                    <div class="form-group" id="editor">
                                        <h4>Content of news</h4>
                                        <textarea id="content">
                                            <?php echo $news_edit['content']; ?>
                                        </textarea>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-default btn-lg">Save</button>
                                    <a href="news.php" class="btn btn-default btn-lg">Cancel</a>
                                </form>
                            </div>
                            <!-- /.col-lg-12 (nested) -->
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>


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

<!-- Custom Editor JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

<script type="text/javascript" src="../js/froala_editor.min.js"></script>
<script type="text/javascript" src="../js/plugins/align.min.js"></script>
<script type="text/javascript" src="../js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="../js/plugins/lists.min.js"></script>
<script type="text/javascript" src="../js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="../js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="../js/plugins/table.min.js"></script>
<script type="text/javascript" src="../js/plugins/url.min.js"></script>
<script type="text/javascript" src="../js/plugins/entities.min.js"></script>

<script>
    $(function () {
        $('#content')
            .on('froalaEditor.initialized', function (e, editor) {
                $('#content').parents('form').on('submit', function () {
                    console.log($('#content').val());
                    return false;
                })
            })
            .froalaEditor({enter: $.FroalaEditor.ENTER_P, placeholderText: null})
    });
</script>


<!-- Date Picker JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>
<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap',
        format: 'yyyy-mm-dd'
    });
</script>

<!-- Post JavaScript -->
<script>
    $(document).ready(function () {

        <!-- Upload images JavaScript -->
        $("input.image").on("change", function () {
            //產生 FormData 物件
            // console.log($(this));

            var file_data = new FormData(),
                file_name = $(this)[0].files[0],
                save_path = "img/news/";

            console.log(file_name);
            //在圖片區塊，顯示loading
            $("div.show_image").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

            //FormData 新增剛剛選擇的檔案
            file_data.append("file", file_name);
            file_data.append("save_path", save_path);

            //透過ajax傳資料
            $.ajax({
                type: 'POST',
                url: '../php/upload_file.php',
                data: file_data,
                cache: false,       //因為只有上傳檔案，所以不要暫存
                processData: false, //因為只有上傳檔案，所以不要處理表單資訊
                contentType: false,  //送過去的內容，由 FormData 產生了，所以設定false
                dataType: 'html'
            }).done(function (data) {
                console.log(data);
                // data = data.replace(/[\r\n]/g, "")
                // console.log(data);

                // var k = "yes,1231368.jpg";
                var t = data.split(',');
                console.log(t[0]);
                console.log(t[1]);

                //上傳成功
                if (t[0] == "yes") {
                    //將檔案插入
                    $("div.show_image").html("<img src='../" + t[1] + "'>");
                    //給予 #image_path 值，等等存檔時會用
                    $("#image_path").val(t[1]);
                }
                else {
                    //警告回傳的訊息
                    alert(data);
                }

            }).fail(function (data) {
                //失敗的時候
                alert("有錯誤產生，請看 console log");
                console.log(jqXHR.responseText);
            });
        });

        <!-- Delete images JavaScript -->
        $("a.del_image").on("click", function () {
            //如果有圖片路徑，就刪除該檔案
            if ($("#image_path").val() != '') {
                //透過ajax刪除
                $.ajax({
                    type: 'POST',
                    url: '../php/del_file.php',
                    data: {
                        "file": $("#image_path").val()
                    },
                    dataType: 'html'
                }).done(function (data) {
                    console.log(data);
                    //上傳成功
                    if (data == "yes") {
                        //將圖片標籤移除，並清空目前設定路徑
                        $("div.show_image").html("");
                        //給予 #image_path 值，等等存檔時會用
                        $("#image_path").val('');
                        //delete input picture
                        $("input.image").val('');
                    }
                    else {
                        //警告回傳的訊息
                        alert(data);
                    }

                }).fail(function (data) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
            }
            else {
                alert("There is no picture.");
            }
        });

        //表單送出
        $("#edit_event_form").on("submit", function () {
            //加入loading icon
            $("div.loading").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

            if ($("#title").val() == '' || $("#content").val() == '') {
                alert("Missing title!!!");

                //清掉 loading icon
                $("div.loading").html('');
            } else {
                //使用 ajax 送出 帳密給 verify_user.php
                $.ajax({
                    type: "POST",
                    url: "../php/update_news.php", //因為此檔案是放在 admin 資料夾內，若要前往 php，就要回上一層 ../ 找到 php 才能進入 add_article.php
                    data: {
                        id: $("#id").val(), //使用者帳號
                        title: $("#title").val(), //使用者帳號
                        category: $("#category").val(), //使用者帳號
                        due_date: $("#datepicker").val(), //使用者帳號
                        image_path: $("#image_path").val(),
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
                        alert("Upadte successful!!");
                        window.location.href = "news.php";
                    }
                    else {
                        alert("Upadte error!!!");
                    }

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("fail to post info!!!");
                    console.log(jqXHR.responseText);
                });
            }
            return false;
        });
    });
</script>

</body>
</html>