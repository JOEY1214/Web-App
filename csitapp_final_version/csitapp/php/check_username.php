<?php
//載入資料庫與處理的方法
require_once 'db.php';
require_once 'functions.php';

//執行檢查有無使用者的方法。
//$check = check_has_username($_POST['n']);

if(check_has_username($_POST['check_un']))
{
    //若為true 代表有使用者以重複
    echo 'no';
}
else
{
    //若為 null 或者 false 代表沒有使用者，可以註冊
    echo 'yes';
}

?>