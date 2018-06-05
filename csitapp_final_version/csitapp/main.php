<?php
require_once 'php/db.php';
require_once 'php/functions.php';


if (!isset($_SESSION['is_login']) || !$_SESSION['is_login']) {

    header("Location: ../index.php");
}

$user_authority = get_member($_SESSION['login_user_id']);
if ($user_authority['authority'] != 'staff') {

    header("Location: ../index.php");
}

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
                <h1 class="text-uppercase">
                    <strong>Welcome to CSIT-APP</strong>
                </h1>
                <hr>
                <div class="col-lg-8 mx-auto">
                    <p class="text-faded mb-5">Start to browse CSIT news and events.</p>
                    <a class="col-lg-6 btn btn-primary btn-xl js-scroll-trigger" href="#deadline" >Get Started!</a>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- deadline section -->
<section id="deadline">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Deadlines</h2>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-diamond text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Learning</h3>
                    <p class="text-muted mb-0">Event:XXX End: 2018-04-20.</p><br>
                    <p class="text-muted mb-0">Event:XXX End: 2018-04-30.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-paper-plane text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Teaching</h3>
                    <p class="text-muted mb-0">Event:XXX End: 2018-04-24.</p><br>
                    <p class="text-muted mb-0">Event:XXX End: 2018-05-30.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-newspaper-o text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Research</h3>
                    <p class="text-muted mb-0">Event:XXX End: 2018-05-20.</p><br>
                    <p class="text-muted mb-0">Event:XXX End: 2018-06-30.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-heart text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">General</h3>
                    <p class="text-muted mb-0">Event:XXX End: 2018-05-24.</p><br>
                    <p class="text-muted mb-0">Event:XXX End: 2018-06-30.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- News Section -->
<section class="bg-primary" id="news">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-heading text-white">XXX News</h2>
                <hr class="light my-4">
                <p class="text-faded mb-4">This section only show the last three news, click "Find More" to view all
                    news!</p>

                <div class="album py-5 ">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    <img class="img-fluid" src="img/portfolio/thumbnails/3.jpg" alt="">
                                    <div class="card-body">
                                        <p class="card-text">RMIT and Microsoft develop course in world-first</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">View
                                                </button>
                                            </div>
                                            <small class="text-muted">2018-03-29</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    <img class="img-fluid" src="img/portfolio/thumbnails/1.jpg" alt="">
                                    <div class="card-body">
                                        <p class="card-text">Golden touch: next-gen optical disk to solve</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">View
                                                </button>
                                            </div>
                                            <small class="text-muted">2018-03-28</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    <img class="img-fluid" src="img/portfolio/thumbnails/2.jpg" alt="">
                                    <div class="card-body">
                                        <p class="card-text">Citizen scientists take heatwaves into their own hands</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">View
                                                </button>
                                            </div>
                                            <small class="text-muted">2018-03-27</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-light btn-xl js-scroll-trigger" href="#services">Find More!</a>
                </div>
            </div>
        </div>
</section>


<!-- Event Section -->
<section class="bg-dark text-white" id="event">
    <div class="container text-center">
        <h2 class="mb-4">Events of CSIT</h2>
        <a class="btn btn-light btn-xl sr-button" href="http://startbootstrap.com/template-overviews/creative/">More</a>
    </div>
</section>
<section class="p-0">
    <div class="container-fluid p-0">
        <div class="row no-gutters popup-gallery">
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/1.jpg">
                    <img class="img-fluid" src="img/portfolio/thumbnails/1.jpg" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/2.jpg">
                    <img class="img-fluid" src="img/portfolio/thumbnails/2.jpg" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Learning
                            </div>
                            <div class="project-name">
                                CSIT crazy party!!
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/3.jpg">
                    <img class="img-fluid" src="img/portfolio/thumbnails/3.jpg" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/4.jpg">
                    <img class="img-fluid" src="img/portfolio/thumbnails/4.jpg" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/5.jpg">
                    <img class="img-fluid" src="img/portfolio/thumbnails/5.jpg" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/6.jpg">
                    <img class="img-fluid" src="img/portfolio/thumbnails/6.jpg" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Feedback Section -->
<section id="feedback">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-heading">FeedBack!</h2>
                <hr class="my-4">
                <p class="mb-5">Feel confuse when you use XXX? That's great! Give us an email and we will get back to
                    you as soon as possible!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 ml-auto text-center">
                <i class="fa fa-phone fa-3x mb-3 sr-contact"></i>
                <p>123-456-6789</p>
            </div>
            <div class="col-lg-4 mr-auto text-center">
                <i class="fa fa-envelope-o fa-3x mb-3 sr-contact"></i>
                <p>
                    <a href="mailto:your-email@your-domain.com">feedback@startbootstrap.com</a>
                </p>
            </div>
        </div>
    </div>
</section>

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
                    un: $("#id").val()
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
                else if(data == "true"){
                    window.location.href = "admin/owner.php";
                }
                else {
                    alert("login fail, please check google account.");
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
