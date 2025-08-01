<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/template/sandbo/assets/img/favicon.png">
    <title>
        @yield('title')
    </title>

    <meta name="description" content="{{ \App\Models\SiteMng::getDesc()  }}">
    <meta name="keywords" content="{{ \App\Models\SiteMng::getKeyword()  }}">

    <meta property="og:image" content="/public/images/logo/logo-glx-tech-trans-square-200.png?v=1">
    <meta property="og:title" content="{{ \App\Models\SiteMng::getTitle()  }}">
    <meta property="og:description" content="{{ \App\Models\SiteMng::getDesc()  }}">

    <link rel="stylesheet" href="/template/sandbo/assets/css/plugins.css">
    <link rel="stylesheet" href="/template/sandbo/assets/css/style.css">
    <link rel="stylesheet" href="/template/sandbo/assets/css/colors/yellow.css">
{{--    <link rel="preload" href="/template/sandbo/assets/css/fonts/thicccboi.css" as="style" onload="this.rel='stylesheet'">--}}
    <link rel="stylesheet" href="/template/sandbo/custom.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/admins/jctool.js?v=<?php echo filemtime(public_path().'/admins/jctool.js');?>"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
{{--    <link rel="apple-touch-icon" href="/_site/dna/chatbot/logo192.png" />--}}
    <link rel="manifest" href="/_site/dna/chatbot/manifest.json" />
    <title>React App</title>

{{--    <script defer="defer" src="/_site/dna/chatbot/static/js/main.e14b1c83.js"></script>--}}

    <script src="https://plugin.llmviet.one/static/js/main.js"></script>

{{--    <link href="/_site/dna/chatbot/static/css/main.1c851a49.css" rel="stylesheet" />--}}

    <style>
        button.search-top{
            border: 0px solid #ccc; padding: 5px 10px; height: 36px; vertical-align: bottom;
            margin-right: 20px
        }
        input.search-top {
            height: 38px; padding: 5px 10px;
            /*margin-top:2px;*/
            color: red;
            float: right;
            width: 250px;
            font-size: small;
            margin-left: 20px;
            /*border-radius: 10px 0px 0px 5px;*/
            border: 1px solid #ccc;
            border-right: 0px;
            vertical-align: bottom;
        }
        #chatbot {
            z-index: 10000000;
        }
        .one_news img{
            width: 100%;
        }
    </style>
</head>

<?php

    \App\Models\BlockUi::showCssHoverBlock();

?>

<body>
<div id="chatbot"></div>

<div class="content-wrapper">
    <header class="wrapper">

        <nav class="navbar navbar-expand-lg center-nav transparent navbar-light">
            <div class="container flex-lg-row flex-nowrap align-items-center">
                <div class="navbar-brand w-100 qqqq1111" style="">
                    <a href="/">
                        <h2 style="margin-top: 8px; margin-left: 10px">
                            <?php
                            $ui = \App\Models\BlockUi::showEditButtonStatic('header_logo');
                            if($ui->getThumbInImageList())
                                echo '<img src="'.$ui->getThumbInImageList().'" style="height: 40px">';
                            else
                                echo $ui->getSummary();
                            ?>

                        </h2>
                    </a>
                </div>


                <div class="navbar-collapse offcanvas-nav" >
                    <div class="offcanvas-header d-lg-none d-xl-none">
                        <a href="/">
                            <?php
                            $ui = \App\Models\BlockUi::showEditButtonStatic('header_logo');
                            if($ui->getThumbInImageList())
                                echo '<img src="'.$ui->getThumbInImageList().'" style="height: 40px">';
                            else
                                echo $ui->getExtra();
                            ?>
                        </a>
                        <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close" aria-label="Close"></button>
                    </div>

                    <ul class="navbar-nav qqqq1111">

                    <?php
                    $mm = \App\Models\MenuTree::showMenuPublicSandBox();
                    ?>
                    </ul>

                    <!-- /.navbar-nav -->
                </div>
                <!-- /.navbar-collapse -->
                <div class="navbar-other w-100 d-flex ms-auto">
                    <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
                        <li class="nav-item dropdown language-select text-uppercase">
                            <a class="nav-link dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">En</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="dropdown-item" href="#">En</a></li>
                                <li class="nav-item"><a class="dropdown-item" href="#">De</a></li>
                                <li class="nav-item"><a class="dropdown-item" href="#">Es</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <?php
                            if(getCurrentUserId())
                                echo '<a href="/member"><b>Member</b></a>';
//                            else
//                                echo '<a href="/login"><b>Login</b></a>';
                            ?>
                        </li>
                        <li class="nav-item d-lg-none">
                            <div class="navbar-hamburger"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
                        </li>

                    </ul>
                    <!-- /.navbar-nav -->
                </div>
                <!-- /.navbar-other -->
                <div class="offcanvas-info text-inverse">
                    <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-info-close" aria-label="Close"></button>
                    <a href="/">
                        4SHARE
                    </a>
                    <div class="mt-4 widget">
                        <p>Sandbox is a multipurpose HTML5 template with various layouts which will be a great solution for your business.</p>
                    </div>
                    <!-- /.widget -->
                    <div class="widget">
                        <h4 class="widget-title text-white mb-3">Contact Info</h4>
                        <address> Moonshine St. 14/05 <br /> Light City, London </address>
                        <a href="mailto:first.last@email.com">info@email.com</a><br /> +00 (123) 456 78 90
                    </div>
                    <!-- /.widget -->
                    <div class="widget">
                        <h4 class="widget-title text-white mb-3">Learn More</h4>
                        <ul class="list-unstyled">
                            <li><a href="#">Our Story</a></li>
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- /.widget -->
                    <div class="widget">
                        <h4 class="widget-title text-white mb-3">Follow Us</h4>
                        <nav class="nav social social-white">
                            <a href="#"><i class="uil uil-twitter"></i></a>
                            <a href="#"><i class="uil uil-facebook-f"></i></a>
                            <a href="#"><i class="uil uil-dribbble"></i></a>
                            <a href="#"><i class="uil uil-instagram"></i></a>
                            <a href="#"><i class="uil uil-youtube"></i></a>
                        </nav>
                        <!-- /.social -->
                    </div>
                    <!-- /.widget -->
                </div>
                <!-- /.offcanvas-info -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- /.navbar -->
    </header>
    <!-- /header -->

    @yield('content')

    <!-- /section -->
</div>
<!-- /.content-wrapper -->
<footer class="bg-navy text-inverse">
    <div class="container pt-8 pt-md-8 pb-8 pb-md-8">
        <!--/div -->

        <div class="row gy-6 gy-lg-0">
            <div class="col-md-4 col-lg-3">
                <div class="widget qqqq1111">
                    <?php
                    $ui = \App\Models\BlockUi::showEditButtonStatic('footer1');

                    echo $ui->getSummary();
                    ?>


                    <nav class="nav social social-white">
                        <a href="#"><i class="uil uil-twitter"></i></a>
                        <a href="#"><i class="uil uil-facebook-f"></i></a>
                        <a href="#"><i class="uil uil-dribbble"></i></a>
                        <a href="#"><i class="uil uil-instagram"></i></a>
                        <a href="#"><i class="uil uil-youtube"></i></a>
                    </nav>
                    <!-- /.social -->
                </div>
                <!-- /.widget -->
            </div>
            <!-- /column -->
            <div class="col-md-4 col-lg-3 qqqq1111">
                <div class="widget ">
                    <?php
                    $ui = \App\Models\BlockUi::showEditButtonStatic('footer2');
                    echo $ui->getSummary();
                    ?>

                </div>
                <!-- /.widget -->
            </div>
            <!-- /column -->
            <div class="col-md-4 col-lg-3 qqqq1111">
                <div class="widget">
                    <?php
                    $ui = \App\Models\BlockUi::showEditButtonStatic('footer3');
                    echo $ui->getSummary();
                    ?>


                </div>
                <!-- /.widget -->
            </div>
            <!-- /column -->
            <div class="col-md-12 col-lg-3 qqqq1111">
                <div class="widget">
                    <?php
                    $ui = \App\Models\BlockUi::showEditButtonStatic('footer4');
                    echo $ui->getSummary();
                    ?>

                    <!-- /.newsletter-wrapper -->
                </div>
                <!-- /.widget -->
            </div>
            <!-- /column -->
        </div>
        <!--/.row -->
    </div>
    <!-- /.container -->
</footer>
<div class="progress-wrap" style="display: none">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script src="/template/sandbo/assets/js/plugins.js"></script>
<script src="/template/sandbo/assets/js/theme.js"></script>
</body>

</html>
