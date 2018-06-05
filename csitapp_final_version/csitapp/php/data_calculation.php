<?php
//start session
@session_start();

/**
 * get news %
 */
//function get_user_login_number($month)
//{
//    $staff = get_all_staffs();
//    $all_login_time= get_visiter_count();
//
//    if($month==date('m')){
//
//
//        $count =
//    }
//
//
//
//}

/**
 * get news %
 */
function get_percentage_news()
{
    $news_number = get_number_news();
    $events_number = get_number_events();
    $result = ($news_number / ($news_number + $events_number)) * 100;

    return round($result,2);
}

/**
 * get events %
 */
function get_percentage_events()
{
    $news_number = get_number_news();
    $events_number = get_number_events();
    $result = ($events_number / ($news_number + $events_number)) * 100;

    return round($result,2);
}

/**
 * get number of news in monthly
 */
function get_number_news_month($current_date)
{
    $store = 0;
    //get data from news
    $news_datas = get_all_news();

    if ($news_datas) {
        foreach ($news_datas as $data) {
            if ($data != null) {
                $date=explode("-",$data['create_date']);
                if($date[1]==$current_date)
                    ++$store;
            }
        }
    }
    return $store;

}

/**
 * get number of events in monthly
 */
function get_number_events_month($current_date)
{
    $store = 0;
    //get data from news
    $events_datas = get_all_events();

    if ($events_datas) {
        foreach ($events_datas as $data) {
            if ($data != null) {
                $date=explode("-",$data['create_date']);
                if($date[1]==$current_date)
                    ++$store;
            }
        }
    }
    return $store;

}

/**
 * get the number of all events
 */
function get_number_events()
{
    $store = 0;
    //get data from event
    $event_datas = get_all_events();

    if ($event_datas) {
        foreach ($event_datas as $event_datas) {
            if ($event_datas != null) {
                ++$store;
            }
        }
    }
    return $store;
}

/**
 * get the number of all news
 */
function get_number_news()
{
    $store = 0;
    //get data from news
    $news_datas = get_all_news();
    if ($news_datas) {
        foreach ($news_datas as $news_datas) {
            if ($news_datas != null) {
                ++$store;
            }
        }
    }
    return $store;
}

function get_visiter_count($date)
{
    //宣告要回傳的結果
    $result = null;

    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `visiter` WHERE `id` = {$date};";

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
?>