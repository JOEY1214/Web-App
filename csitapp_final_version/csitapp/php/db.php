<?php
//To start a session for storing the info after connect with database
session_start();
//To set up host address.
//$host = 'localhost';
$host = 'csitapp.cyeo2kdlrdak.us-west-2.rds.amazonaws.com';

//database username.
//$dbuser = 'root';
$dbuser = 'csitappdb';

//database password.
//$dbpw = '';
$dbpw = 'csitappdb2018';

//database name
$dbname = 'test';

//set up a link to send above info to connect database
$_SESSION['link'] = mysqli_connect($host, $dbuser, $dbpw, $dbname);

if ($_SESSION['link'])
{
    //print successful if connection is work
    //set up UTF-8
    mysqli_query($_SESSION['link'], "SET NAMES utf8");
//    echo "connect successful";
}
else
{
    //if connection is not work print error
    echo 'error :<br/>' . mysqli_connect_error();
}
?>