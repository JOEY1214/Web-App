<?php
//import functions
require_once 'db.php';
require_once 'functions.php';

//to verify the user id
if(verify_user($_POST['un']))
{
    $user = get_user($_POST['un']);

    if($user['authority'] =='admin'){
        //if user is admin echo admin
        echo 'admin';
    }
    elseif($user['authority'] == 'owner'){
        //if user is owner echo owner
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
    $add_result = add_user($_POST['un']);
    //if null or false echo no
    echo 'empty';
}

?>