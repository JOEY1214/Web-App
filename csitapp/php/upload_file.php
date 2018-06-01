<?php
//上傳檔案的資訊，則需要透過 $_FILES 取得，為二維陣列
//echo $_FILES['file']['name']; 第一個陣列索引值，是表單給予的 name="image_path" 而來的，第二個索引值 name 代表是上傳的檔案名稱
//echo $_FILES['file']['type'];		//檔案型態
//echo $_FILES['file']['tmp_name'];	//上傳後暫存在 server 的中的位置及檔名
//echo $_FILES['file']['error'];		//錯誤碼0,為上傳正常 4為沒選擇檔案
//echo $_FILES['file']['size'];		//檔案大小，以 byte 為單位
//處理上傳的檔案 圖片
//file_exists 方法，是判別該檔案是否存在 server 上
if(file_exists($_FILES['file']['tmp_name']))
{
    //先定義上傳的資料夾
    $img_folder = $_POST['save_path'];

    //取得圖檔原來的名稱
    $tmp_file_name = $_FILES['file']['name'];

    //fix file name
    $tmp_file_name = preg_replace("/\s+/","_",$tmp_file_name);
    $avatar_ext = pathinfo($tmp_file_name,PATHINFO_EXTENSION);
    $tmp_file_name =pathinfo($tmp_file_name,PATHINFO_FILENAME);
    $file_name =$tmp_file_name."_".date("mjYHis").".".$avatar_ext;

    //如果存在就 搬移檔案 move_uploaded_file 方法是將上傳的檔案，移動到網站資料夾正確定義的位置
    //第一個變數，通常是上傳後暫存的檔案位置，第二個變數，是搬移的目標檔案及位置
    // $img_folder . $file_name 其實是 files/images/圖檔檔名.jpg
    // 由於 work_save.php 這隻檔案在 php 資料夾中，但圖檔是要上傳到「上一層裡找到 files資料夾」，所以搬移的上傳位置要加上 ../
    if(move_uploaded_file($_FILES['file']['tmp_name'], "../" . $img_folder . $file_name))
    {
        $file_path = $img_folder . $file_name;
        echo "yes,{$file_path}";
    }
    else
    {
        echo "檔案搬移失敗，請確認{$_POST['save_path']}資料夾可寫入";
    }

}
else
{
    echo "暫存檔不存在，上傳失敗";
}


?>