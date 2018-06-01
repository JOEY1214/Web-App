<?php
//啟動 session_start();
session_start();

//把該使用者 session 銷毀，登入資訊就不見了
session_destroy();

//轉跳回後台首頁，因為此 logout 是放在 php 資料夾內，若要前往 admin，就要回上一層 ../ 找到 admin 才能進入 index.php
header("Location: index.php");

?>