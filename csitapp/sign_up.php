<?php
require_once 'php/db.php';
require_once 'php/functions.php';

$user = get_member('3');
echo $user['authority'];
//$a = check_has_username('nickcsitapp@gmail.com');
//echo $a;
//$b = verify_user('nickcsitapp@gmail.com');
//echo $b;
//if (isset($_SESSION['is_login']) && $_SESSION['is_login']) {
//    header("Location: admin/index.php");
//}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test login page</title>
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

<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php">CSIT</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#deadline">Deadlines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#news">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#event">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#feedback">Feedback</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<header class="masthead text-center text-white d-flex">

    <div class="container my-auto">

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2 class="text-uppercase">Sign up to CSIT-APP</h2>
                <hr>
                <p class="text-faded mb-5">If you are first time to use CSIT-APP, click and login google account
                    below.</p>

                <div class="col-lg-8 mx-auto">
                    <div class="btn btn-xl js-scroll-trigger" id="my-signin2"></div>
                    <br>
                    <a href="index.php" onclick="signOut();" style="color: #0b0b0b">click and sign out your google
                        account</a>
                    <br>
                    <div class="dropdown-divider"></div>
                    <form class="signup">
                        <button type="submit" class="col-lg-4 btn btn-primary btn-xl js-scroll-trigger">Sign Up</button>
                        <input type="hidden" id="id" name="id">
                    </form>
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
        document.getElementById('id').value = googleUser.getBasicProfile().getEmail();
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

<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>

    $(document).ready(function () {

        $("form.signup").on("submit", function () {
            //use ajax send id and password to verify_user.php

            $.ajax({
                type: "POST",
                url: "php/verify_user.php",
                data: {
                    un: $("#username").val(),
                    pw: $("#password").val()
                },
                dataType: 'html'
            }).done(function (data) {
                //if it done
                console.log(data);
                data = data.replace(/[\r\n]/g, "")
                console.log(data);

                if (data == "yes") {
                    //if it true jump to main page
                    window.location.href = "admin/index.php";
                }
                else {
                    alert("login fail, please check your password");
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
