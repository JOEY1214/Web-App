<?php
//載入資料庫與處理的方法
require_once 'db.php';


//判別有無在登入狀態
if(isset($_SESSION['is_login']) && $_SESSION['is_login']){

    if(file_exists("../" . $_POST['file']))
    {
        //若為檔案存在 就刪除

        unlink("../" . $_POST['file']);

        //印出yes
        echo 'yes';
    }
    else
    {
        //若為不存在代表失敗
        echo '檔案不存在';
    }
}
else
{
    //若為 null 或者 false 代表失敗
    echo '尚未登入';
}

?>