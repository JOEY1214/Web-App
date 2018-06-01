<?php
//載入資料庫與處理的方法
require_once 'db.php';
require_once 'functions.php';

//判別有無在登入狀態
//if(isset($_SESSION['is_login']) && $_SESSION['is_login']){
//執行新增使用者的方法，直接把整個 $_POST個別的照順序變數丟給方法。
$add_result = add_contacts($_POST['name'], $_POST['image_path'],$_POST['identity'],$_POST['office'],$_POST['phone'],$_POST['email'],$_POST['department'],$_POST['content']);

if($add_result)
{
    //若為true 代表新增成功，印出yes
    echo 'yes';
}
else
{
    //若為 null 或者 false 代表失敗
    echo 'no';
}
//}
//else
//{
//若為 null 或者 false 代表失敗
//    echo 'no';
//}

?>