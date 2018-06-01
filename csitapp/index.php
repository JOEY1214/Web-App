<?php
require_once 'php/db.php';
require_once 'php/functions.php';


//if (!isset($_SESSION['is_login']) || !$_SESSION['is_login']) {
//
//    header("Location: login.php");
//}

//to get the all user info
$members = get_all_member();
//to get the all mews info
$news = get_all_news();
?>
<!DOCTYPE html>
<html>
<head>
    <title>CSIT-App</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-signin-client_id"
          content="175140894115-499edq1ubee5te3q8seeh2htpedmfcdo.apps.googleusercontent.com">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts css -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'
          rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles CSS -->
    <link href="css/creative.min.css" rel="stylesheet">
</head>

<body id="page-top">
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php">CSIT-App</a>
    </div>
</nav>

<header class="masthead text-center text-white d-flex">

    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h1 class="text-uppercase">
                    <strong>Welcome to CSIT-APP</strong>
                </h1>
                <hr>
                <div class="col-8 mx-auto">
                    <p class="text-faded mb-5">Login your google account and start to manage CSIT app.</p>
                    <div class="btn btn-xl js-scroll-trigger" id="my-signin2"></div>
                    <br>
                    <a href="index.php" onclick="signOut();" style="color: #000000">click here to sign out your google
                        account</a>
                    <br>
                    <div class="dropdown-divider"></div>
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <form class="login">
                                <button type="submit" class="btn btn-primary btn-xl" style="width: 150px">Login</button>
                                <input type="hidden" id="login_id" name="login_id">
                            </form>
                        </div>
                        <div class="col-4">
                            <form class="signup">
                                <button type="submit" class="btn btn-primary btn-xl" style="width: 150px">Sign Up</button>
                                <input type="hidden" id="sign_up_id" name="sign_up_id">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>


<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<script>
    function onSuccess(googleUser) {
        console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
        console.log('Logged in as: ' + googleUser.getBasicProfile().getEmail());
        document.getElementById('login_id').value = googleUser.getBasicProfile().getEmail();
        document.getElementById('sign_up_id').value = googleUser.getBasicProfile().getEmail();
    }

    function onFailure(error) {
        console.log(error);
    }

    function renderButton() {
        gapi.signin2.render('my-signin2', {
            'scope': 'profile email',
            'width': 280,
            'height': 50,
            'longtitle': true,
            'theme': 'dark',
            'onsuccess': onSuccess,
            'onfailure': onFailure
        });
    }
</script>
<script>
    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
    }
</script>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="vendor/scrollreveal/scrollreveal.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

<!-- Custom scripts for this template -->
<script src="js/creative.min.js"></script>

<script>

    $(document).ready(function () {

        $("form.login").on("submit", function () {
            //use ajax send id and password to verify_user.php

            $.ajax({
                type: "POST",
                url: "php/verify_user.php",
                data: {
                    un: $("#login_id").val()
                },
                dataType: 'html'
            }).done(function (data) {
                //if it done
                console.log(data);
                data = data.replace(/[\r\n]/g, "");
                console.log(data);

                if (data == "admin") {
                    //if it true jump to main page
                    window.location.href = "admin/index.php";
                }
                else if (data == "owner") {
                    window.location.href = "admin/owner.php";
                }
                else if (data == "staff") {
                    window.location.href = "main.php";
                }
                else if (data == "empty") {
                    alert("please sign up with your google account.");
                }
                else {
                    alert("login fail, please wait for administrator to change your authority.");
                }

            }).fail(function (jqXHR, textStatus, errorThrown) {

                alert("something wrong，please check console log");
                console.log(jqXHR.responseText);
            });
            return false;
        });
    });
</script>
<script>
    $(document).ready(function () {

        $("form.signup").on("submit", function () {
            //use ajax send id and password to verify_user.php

            $.ajax({
                type: "POST",
                url: "php/check_username.php",
                data: {
                    check_un: $("#sign_up_id").val()
                },
                dataType: 'html'
            }).done(function (check_data) {
                //if it done
                console.log(check_data);
                check_data = check_data.replace(/[\r\n]/g, "")
                console.log(check_data);

                if (check_data == "yes") {
                    //if it true jump to main page
                    $.ajax({
                        type: "POST",
                        url: "php/add_user.php",
                        data: {
                            sign_un: $("#sign_up_id").val()
                        },
                        dataType: 'html'
                    }).done(function (add_data) {
                        //if it done
                        console.log(add_data);
                        add_data = add_data.replace(/[\r\n]/g, "");
                        console.log(add_data);

                        if (add_data == "yes") {
                            //if it true jump to main page
                            alert("Thank you for your sign up, please wait for administrator to pass your account.");
                            window.location.href = "index.php";
                        }
                        else {
                            alert("Sign up fail.");
                        }

                    }).fail(function (jqXHR, textStatus, errorThrown) {

                        alert("something wrong，please check console log");
                        console.log(jqXHR.responseText);
                    });
                }
                else {
                    alert("Your account has been sign up, please login with your account.");
                }

            }).fail(function (jqXHR, textStatus, errorThrown) {

                alert("something wrong，please check console log");
                console.log(jqXHR.responseText);
            });
            return false;
        });
    });
</script>
</body>
</html>
