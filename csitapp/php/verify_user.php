<?php
//import functions
require_once 'db.php';
require_once 'functions.php';

//$username = $_POST['un'];
//to verify the user id
if(verify_user($_POST['un']))
{
    $user = get_user($_POST['un']);

    if($user['authority'] =='admin'){
        //if user is admin echo yes
        echo 'admin';
    }
    elseif($user['authority'] == 'owner'){
        //if user is owner echo yes
        echo 'owner';
    }
    elseif ($user['authority'] == 'staff'){
        echo 'staff';
    }
    else{
        //if user is not owner or admin echo no
        echo 'no';
    }
}
else
{
    //if null or false echo no
    echo 'empty';
}

?>