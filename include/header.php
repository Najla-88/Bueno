<?php require_once('conn.php');
      include('include/functions.php');
      if(isset($_SESSION['user_info']))
      {
          $user_id = $_SESSION['user_info']['id'];
      }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Bueno - Food Blog</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/classy-nav.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .headerActive{
            color:#b0c364 !important;
        }
    </style>
</head>

<body>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">

        <!-- Top Header Area -->
        <div class="top-header-area bg-img bg-overlay" style="background-image: url(img/bg-img/header.jpg);">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-between">
                    <div class="col-12 col-sm-6">
                        <!-- Top Social Info -->
                        <div class="top-social-info">
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Dribbble"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Behance"><i class="fa fa-behance" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-5 col-xl-4">
                       <!-- Top Search Area -->
                       <div class="top-search-area">
                            <form action="search.php" method="get">
                                <input type="search" name="search_word" id="topSearch" placeholder="Search">
                                <button type="submit" name="search_submit" class="btn"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo Area -->
        <div class="logo-area">
            <a href="index.php"><img src="img/core-img/logo.png" alt=""></a>
        </div>

        <!-- Navbar Area -->
        <div class="bueno-main-menu" id="sticker">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="buenoNav">
                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul class="pl-5 m">
                                    <?php $activePage = basename($_SERVER['PHP_SELF'],'.php'); ?>
                                    <li><a class="<?= ($activePage == 'index') ? 'headerActive':''; ?>" href="index.php">Home</a></li>
                                    <li><a class="<?= ($activePage == 'catagory') ? 'headerActive':''; ?>" href="catagory.php">Catagories</a></li>
                                    <li><a class="<?= ($activePage == 'contact') ? 'headerActive':''; ?>" href="contact.php">Contact</a></li>
                                    <li><a class="<?= ($activePage == 'about') ? 'headerActive':''; ?>" href="about.php">About Us</a></li>
                                    <?php 
                                    if(isset($_SESSION['user_info']))
                                    { ?>
                                    <li class="ml-5 mr-3 pl-5">
                                        <a href="#">
                                        <img
                                            src="<?php 
                                                if(get_by_id('users', $user_id, 'img')!=null)
                                                    echo get_by_id('users', $user_id, 'img');
                                                else 
                                                    echo 'img/profile/solidUser.svg';
                                                ?>"
                                            alt="user"
                                            class="rounded-circle "
                                            width="31"
                                        />
                                        </a>
                                        <ul class="dropdown">
                                            <li><a href="profile.php">Profile</a></li>
                                            <li><a href="account_setting.php">Account setting</a></li>
                                            <li><a href="logout.php">Logout</a></li>
                                        </ul>
                                    </li>
                                   <?php
                                    }
                                    ?>
                                </ul>
                                <?php if(!isset($_SESSION['user_info'])) 
                                { ?>
                                <!-- Login/Register -->
                                <div class="login-area">
                                    <a class="<?= ($activePage == 'login') ? 'headerActive':''; ?>" href="login.php">Login</a>
                                </div>
                                <?php } ?>
                            </div>
                            <!-- Nav End -->

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>