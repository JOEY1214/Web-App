<?php
//start session
@session_start();


//check user id in database
function check_user_id($id)
{
    //define a result
    $result = null;

    //use sql select this id
    $sql = "SELECT * FROM `user` WHERE `id` = '{$id}';";

    //use mysqli_query to request
    $query = mysqli_query($_SESSION['link'], $sql);

    //if it is success
    if ($query) {
        //use mysqli_num_rows to check if the id is exist
        if (mysqli_num_rows($query) >= 1) {
            //if yes, return true
            $result = true;
        }

        //free the query from result
        mysqli_free_result($query);
    } else {
        echo "{$sql} execute error，error message：" . mysqli_error($_SESSION['link']);
    }

    //return result
    return $result;
}

function check_has_username($username)
{
    //宣告要回傳的結果
    $result = null;

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `user` WHERE `username` = '{$username}'";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
        if (mysqli_num_rows($query) >= 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

//To verity username
function verify_user($username)
{
    //宣告要回傳的結果
    $result = null;
    //先把密碼用md5加密
//    $password = $password;
    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `user` WHERE `username` = '{$username}'";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 回傳 $query 請求的結果數量有幾筆，為一筆代表找到會員且密碼正確。
        if (mysqli_num_rows($query) == 1) {
            //取得使用者資料
            $user = mysqli_fetch_assoc($query);

            //在session李設定 is_login 並給 true 值，代表已經登入
            $_SESSION['is_login'] = TRUE;
            //紀錄登入者的id，之後若要隨時取得使用者資料時，可以透過 $_SESSION['login_user_id'] 取用
            $_SESSION['login_user_id'] = $user['id'];

            //回傳的 $result 就給 true 代表驗證成功
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * get a user info
 */
function get_user($username)
{
    //宣告要回傳的結果
    $result = null;

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `user` WHERE `username` = '{$username}'";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
        if (mysqli_num_rows($query) == 1) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            $result = mysqli_fetch_assoc($query);
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}


function add_user($username)
{

    //宣告要回傳的結果
    $result = null;
    //take email name for user
    $name = explode("@",$username);

    //先把密碼用md5加密
    // $password = md5($password);
    $signupdate = date("Y-m-d");

    //set a authority for first sign up user
    $authority = 'visitor';
    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "INSERT INTO `user` (`username`,`nickname`,`sign_up_date`,`authority`) VALUE ('{$username}', '{$name[0]}','{$signupdate}','{$authority}');";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}


function get_all_member()
{
    //宣告空的陣列
    $datas = array();

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `user` ORDER BY `id` DESC;"; // ORDER BY `create_date` DESC 代表是排序，使用 `create_date` 這欄位， DESC 是從最大到最小(最新到最舊)

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
        if (mysqli_num_rows($query) > 0) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $datas;
}

/**
 * get a member info
 */
function get_member($id)
{
    //宣告要回傳的結果
    $result = null;

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `user` WHERE `id` = '{$id}'";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
        if (mysqli_num_rows($query) == 1) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            $result = mysqli_fetch_assoc($query);
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * 取得所有的文章
 */
function get_all_news()
{
    //宣告空的陣列
    $datas = array();

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `news` ORDER BY `due_date` ASC;"; // ORDER BY `create_date` DESC 代表是排序，使用 `create_date` 這欄位， DESC 是從最大到最小(最新到最舊)

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
        if (mysqli_num_rows($query) > 0) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $datas;
}

/**
 * get one news
 */
function get_news($id)
{
    //宣告要回傳的結果
    $result = null;

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `news` WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
        if (mysqli_num_rows($query) == 1) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            $result = mysqli_fetch_assoc($query);
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

//add news function
function add_news($title, $category, $due_date, $image_path, $content)
{
    //宣告要回傳的結果
    $result = null;
    //建立現在的時間
    $create_date = date("Y-m-d");
    //內容處理html
    $content = htmlspecialchars($content);
    //取得登入者的id
    $creater_id = $_SESSION['login_user_id'];
    //if image path no fill image path value = null
    $image_path_query = "{$image_path}";
    if ($image_path == '') {
        $image_path_query = "NULL";
    }
    //新增語法
    $sql = "INSERT INTO `news` (`title`, `category`, `content`, `image_path`, `due_date`,`create_date`, `creater_id`)
  				VALUE ('{$title}', '{$category}', '{$content}', '{$image_path_query}', '{$due_date}','{$create_date}', '{$creater_id}');";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * 更新文章
 */
function update_news($id, $title, $category, $due_date, $image_path, $content)
{
    //宣告要回傳的結果
    $result = null;
    //建立現在的時間
    $modify_date = date("Y-m-d");
    //內容處理html
    $content = htmlspecialchars($content);

    //check and delete the old image path if exist
    $event = get_event($id);
    if (file_exists($event['image_path'])) {
        if ($image_path != $event['image_path']) {
            unlink($event['image_path']);
        }
    }
    $image_path_query = "`image_path` = '{$image_path}'";
    if ($image_path == '') {
        $image_path_query = "`image_path` = NULL";
    }
    //更新語法
    $sql = "UPDATE `news` SET `title` = '{$title}', `category` = '{$category}', `due_date` ='{$due_date}', `content` = '{$content}',{$image_path_query} WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * 刪除文章
 */
function del_news($id)
{
    //宣告要回傳的結果
    $result = null;
    //Delete image with this id
    $image = get_news($id);
    if (file_exists("../" . $image['image_path'])) {
        unlink("../" . $image['image_path']);
    }
    //Delete data form new table
    $sql = "DELETE FROM `news` WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * get all events
 */
function get_all_events()
{
    //宣告空的陣列
    $datas = array();

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `event` ORDER BY `start_date` ASC;"; // ORDER BY `create_date` DESC 代表是排序，使用 `create_date` 這欄位， DESC 是從最大到最小(最新到最舊)

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
        if (mysqli_num_rows($query) > 0) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $datas;
}

/**
 * get one event
 */
function get_event($id)
{
    //宣告要回傳的結果
    $result = null;

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `event` WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
        if (mysqli_num_rows($query) == 1) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            $result = mysqli_fetch_assoc($query);
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

//add event function
function add_events($title, $start_date, $image_path, $content)
{
    //宣告要回傳的結果
    $result = null;
    //建立現在的時間
    $create_date = date("Y-m-d");
    //內容處理html
    $content = htmlspecialchars($content);
    //取得登入者的id
    $author = $_SESSION['login_user_id'];

    $image_path_query = "{$image_path}";
    if ($image_path == '') {
        $image_path_query = "NULL";
    }
    //新增語法
    $sql = "INSERT INTO `event` (`title`, `content`, `start_date`,`create_date`, `image_path`, `author`)
  				VALUE ('{$title}', '{$content}', '{$start_date}','{$create_date}', '{$image_path_query}', '{$author}');";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * update event
 */
function update_event($id, $title, $start_date, $image_path, $content)
{
    //宣告要回傳的結果
    $result = null;
    //建立現在的時間
    //$modify_date = date("d-m-Y");

    //check and delete the old image path if exist
    $event = get_event($id);
    if (file_exists($event['image_path'])) {
        if ($image_path != $event['image_path']) {
            unlink($event['image_path']);
        }
    }
    $image_path_query = "`image_path` = '{$image_path}'";
    if ($image_path == '') {
        $image_path_query = "`image_path` = NULL";
    }

    //內容處理html
    $content = htmlspecialchars($content);

    //更新語法
    $sql = "UPDATE `event` SET `title` = '{$title}', `start_date` = '{$start_date}', `content` = '{$content}',{$image_path_query} WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * delete event
 */
function del_event($id)
{
    //宣告要回傳的結果
    $result = null;
    //Delete image with this id
    $image = get_event($id);
    if (file_exists("../" . $image['image_path'])) {
        unlink("../" . $image['image_path']);
    }

    //delete data from event table
    $sql = "DELETE FROM `event` WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * get all contacts
 */
function get_all_contacts()
{
    //宣告空的陣列
    $datas = array();

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `contact` ORDER BY `id` DESC;"; // ORDER BY `create_date` DESC 代表是排序，使用 `create_date` 這欄位， DESC 是從最大到最小(最新到最舊)

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
        if (mysqli_num_rows($query) > 0) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $datas;
}

/**
 * get one contact
 */
function get_contact($id)
{
    //宣告要回傳的結果
    $result = null;

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `contact` WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
        if (mysqli_num_rows($query) == 1) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            $result = mysqli_fetch_assoc($query);
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * add contact
 */
function add_contacts($name, $image_path, $identity, $office, $phone, $email, $department, $content)
{
    //宣告要回傳的結果
    $result = null;
    //內容處理html
    $content = htmlspecialchars($content);

    $image_path_query = "{$image_path}";
    if ($image_path == '') {
        $image_path_query = "NULL";
    }
    //新增語法
    $sql = "INSERT INTO `contact` (`name`, `image_path`, `identity`, `office_address`, `phone`, `email`, `department`, `function`)
  				VALUE ('{$name}', '{$image_path_query}', '{$identity}','{$office}', '{$phone}', '{$email}', '{$department}', '{$content}');";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * update contact
 */
function update_contact($id, $name, $image_path, $identity, $office, $phone, $email, $department, $content)
{
    //宣告要回傳的結果
    $result = null;
    //建立現在的時間
    //$modify_date = date("d-m-Y");

    //check and delete the old image path if exist
    $event = get_event($id);
    if (file_exists($event['image_path'])) {
        if ($image_path != $event['image_path']) {
            unlink($event['image_path']);
        }
    }
    $image_path_query = "`image_path` = '{$image_path}'";
    if ($image_path == '') {
        $image_path_query = "`image_path` = NULL";
    }

    //內容處理html
    $content = htmlspecialchars($content);

    //更新語法
    $sql = "UPDATE `contact` SET `name` = '{$name}', `identity` = '{$identity}', `office_address` = '{$office}', `phone` = '{$phone}', `email` = '{$email}', `department` = '{$department}', `function` = '{$content}', {$image_path_query} WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * delete contact
 */
function del_contact($id)
{
    //宣告要回傳的結果
    $result = null;
    //Delete image with this id
    $image = get_contact($id);
    if (file_exists("../" . $image['image_path'])) {
        unlink("../" . $image['image_path']);
    }

    //delete data from event table
    $sql = "DELETE FROM `contact` WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * get all staffs
 */
function get_all_staffs()
{
    //宣告空的陣列
    $datas = array();

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `user` ORDER BY `id` DESC;"; // ORDER BY `create_date` DESC 代表是排序，使用 `create_date` 這欄位， DESC 是從最大到最小(最新到最舊)

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
        if (mysqli_num_rows($query) > 0) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $datas;
}

/**
 * get one staff
 */
function get_staff($id)
{
    //宣告要回傳的結果
    $result = null;

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `user` WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
        if (mysqli_num_rows($query) == 1) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            $result = mysqli_fetch_assoc($query);
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

//add event function
function add_staffs($title, $start_date, $image_path, $content)
{
    //宣告要回傳的結果
    $result = null;
    //建立現在的時間
    $create_date = date("Y-m-d");
    //內容處理html
    $content = htmlspecialchars($content);
    //取得登入者的id
    $author = $_SESSION['login_user_id'];

    $image_path_query = "{$image_path}";
    if ($image_path == '') {
        $image_path_query = "NULL";
    }
    //新增語法
    $sql = "INSERT INTO `user` (`title`, `content`, `start_date`,`create_date`, `image_path`, `author`)
  				VALUE ('{$title}', '{$content}', '{$start_date}','{$create_date}', '{$image_path_query}', '{$author}');";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * update staff
 */
function update_staff($id, $authority)
{
    //宣告要回傳的結果
    $result = null;
    //建立現在的時間
    //$modify_date = date("d-m-Y");

    //更新語法
    $sql = "UPDATE `user` SET `authority` = '{$authority}' WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * delete staff
 */
function del_staff($id)
{
    //宣告要回傳的結果
    $result = null;
    //Delete image with this id
//    $image = get_event($id);
//    if(file_exists("../" . $image['image_path']))
//    {
//        unlink("../" . $image['image_path']);
//    }

    //delete data from event table
    $sql = "DELETE FROM `user` WHERE `id` = {$id};";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * add feedback
 */
function add_feedback($name, $content)
{
    //宣告要回傳的結果
    $result = null;
    //內容處理html
    $content = htmlspecialchars($content);
    //set current date
    $create_date = date("Y-m-d");
    //新增語法
    $sql = "INSERT INTO `feedback` (`username`, `create_date`, `content`)
  				VALUE ('{$name}', '{$create_date}', '{$content}');";

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
        if (mysqli_affected_rows($_SESSION['link']) == 1) {
            //取得的量大於0代表有資料
            //回傳的 $result 就給 true 代表有該帳號，不可以被新增
            $result = true;
        }
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $result;
}

/**
 * get all feedback
 */
function get_all_feedback()
{
    //宣告空的陣列
    $datas = array();

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `feedback` ORDER BY `create_date` DESC;"; // ORDER BY `create_date` DESC 代表是排序，使用 `create_date` 這欄位， DESC 是從最大到最小(最新到最舊)

    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);

    //如果請求成功
    if ($query) {
        //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
        if (mysqli_num_rows($query) > 0) {
            //取得的量大於0代表有資料
            //while迴圈會根據查詢筆數，決定跑的次數
            //mysqli_fetch_assoc 方法取得 一筆值
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }

        //釋放資料庫查詢到的記憶體
        mysqli_free_result($query);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    //回傳結果
    return $datas;
}
?>


