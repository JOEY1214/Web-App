<?php
require_once 'php/db.php';
require_once 'php/functions.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>CSIT-App</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-signin-client_id"
          content="401883675537-ak2u3a09rhn2ot4fdn1prjgpm4i20ppp.apps.googleusercontent.com">

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

<!--    <style type="text/css">-->
<!--        div.login_view {-->
<!---->
<!--            background: #fff;-->
<!--            border-radius: 10px;-->
<!--            position: relative;-->
<!--            padding-right: 110px;-->
<!--            padding-left: 110px;-->
<!--            padding-bottom: 33px;-->
<!--            padding-top: 62px;-->
<!--        }-->
<!---->
<!--        div.lable {-->
<!--            padding-bottom: 9px;-->
<!--            padding-top: 31px;-->
<!--        }-->
<!--        .txt1 {-->
<!--            font-family: Montserrat-SemiBold;-->
<!--            font-size: 16px;-->
<!--            color: #555555;-->
<!--            line-height: 1.5;-->
<!--        }-->
<!---->
<!--    </style>-->
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
                <p class="text-faded mb-5">Login your google account and start to manage CSIT app.</p>
                <div class="col-6 mx-auto">
                    <script>start();</script>

<!--                    <div class="login_view ">-->
<!---->
<!--                        <div class="lable">-->
<!--                            <span class="txt1">-->
<!--							Username-->
<!--						</span>-->
<!--                        </div>-->
<!--                        <br>-->
<!--                        <input id="username" class="form-control " style="background: #cccecf"-->
<!--                               placeholder="user@rmit.edu.au">-->
<!--                        <label>Password</label>-->
<!--                        <br>-->
<!--                        <input id="password" class="form-control " style="background: #cccecf"-->
<!--                               placeholder="••••••••••••">-->
                        <div id="my-signin2" class="login btn btn-xl" data-onsuccess="onSignIn"></div>
                        <input type="hidden" class="login" id="login_id" name="login_id">
<!--                    </div>-->

                    <!--                    <br>-->
                    <!--                    <br>-->
                    <!--                    <div class="dropdown-divider"></div>-->
                    <!--                    <a class="btn btn-primary btn-xl" href="sign_up.php">Sign up now</a>-->
                </div>
            </div>
        </div>

    </div>
</header>

<script>
    function start() {
        gapi.load('auth2', function () {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut();
            console.log('Logged out.');
        });
    }
</script>

<script>
    function onSuccess(googleUser) {
        googleUser.disconnect()
        console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
        document.getElementById("login_id").value = googleUser.getBasicProfile().getEmail();
        console.log(document.getElementById("login_id").value);

        $(document).ready(function () {

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
                    alert("Thank you for using CSIT app, please wait for administrator to change your authority.");
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

<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="vendor/scrollreveal/scrollreveal.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

<!-- Custom scripts for this template -->
<script src="js/creative.min.js"></script>

</body>
</html>
