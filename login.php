<?php require_once('conn.php');
session_start();
/////////////// functions start //////////////////////////
        function get_cat_by_id($catID)
        {
            global $conn;
            $sql = "stm * FROM categories where id=:cat_id ";
            $stm = $conn->prepare($sql);
            $stm -> execute(array("cat_id"=>$catID));
            $rows = $stm -> fetchAll();
            echo $rows[0]['name'];
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //  function to get any information in any table by id

        function get_by_id ($table ,$id, $attribute ){  //$attribute == column
            global $conn;
            $sql = "stm * FROM $table";
            $stm = $conn->prepare($sql);
            $stm -> execute();
            $allRows = $stm -> fetchAll();
            //$search = $vlaue;
            foreach($allRows as $row){
                if($row['id'] == $id){
                    return $row[$attribute];
                }
            }
            echo "Not Found!";
        }

/////////////// functions end //////////////////////////

/////////////// validate inputs /////////////////////////
    $emailErr = array();
    $passwordErr = $email = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["email"])) {
            $emailErr['empty'] = "Email is required";
        } else {
            $user_email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // $emailErr['invalid'] = "Invalid email format";
            // }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $user_password = test_input($_POST["password"]);
        }

        /////////////////////// session  //////////////////////
        if(isset($user_email,$user_password)){
            $stm = $conn->prepare("select * from users where email =?");
            $stm->execute(array($user_email));
            if($stm->rowCount() == 1)
            {   
                $user_info = $stm->fetch();
                if(password_verify($user_password,$user_info['Password']))
                {
                    $_SESSION['user_info'] = $user_info;

                    if ($_SESSION['user_info']['status']==0) {
                    $active_err ="<div class='alert alert-danger'>You are not allowed to login!</div>";
                    }

                    else {
                    if($_SESSION['user_info']['permission_id']==1)
                    {
                            header("location:admin/index.php");
                    }
                    else
                    {
                        header("location:index.php");
                    }
                    }
                }
            }
            else
            {
                $wrong_e_p = "<div class='alert alert-danger text-center'>E-mail or Passowrd is wrong </div>";
            }    
            
        }
        
        ///////////////////// session end /////////////////////////
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
    <title>Bueno - Food Blog HTML Template</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/classy-nav.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-stm.css">
    <link rel="stylesheet" href="css/style.css">

<style>
    .headerActive{
        color:#b0c364 !important;
    }
    .center_forms_input{
        position: relative;
        margin:auto;
        text-align:center;
    }
    h2  ,p {
        text-align:center;
    }
    a:hover{
        color: #b0c364;
    }

    .bueno-btn:hover, .bueno-btn:focus {
        background-color: #91a052 !important ;
        color: #ffffff !important; }
    .left_align{
        text-align: left;
    }
</style>
</head>

<body>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area pb-5">

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
                                <ul>
                                    <?php $activePage = basename($_SERVER['PHP_SELF'],'.php'); ?>
                                    <li><a class="<?= ($activePage == 'index') ? 'headerActive':''; ?>" href="index.php">Home</a></li>
                                    <li><a class="<?= ($activePage == 'catagory') ? 'headerActive':''; ?>" href="catagory.php">Catagories</a></li>
                                    <li><a class="<?= ($activePage == 'contact') ? 'headerActive':''; ?>" href="contact.php">Contact</a></li>
                                    <li><a class="<?= ($activePage == 'about') ? 'headerActive':''; ?>" href="about.php">About Us</a></li>
                                </ul>

                                <!-- Login/Register -->
                                <div class="login-area">
                                    <a class="<?= ($activePage == 'login') ? 'headerActive':''; ?>" href="login.php">Login</a>
                                </div>
                            </div>
                            <!-- Nav End -->

                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <?php if(isset($wrong_e_p)) echo $wrong_e_p;
              if(isset($active_err)) echo $active_err;
         ?>

    </header>
<!-- ////////////////////////////////////////////// -->

<!-- login form start -->
<div class="login-container">
    <h2 class="login-header pb-5">Login</h2>

    <!-- Login Form -->
    <div class="contact-form-area login">
        <form method="post">
            <div class="">
                <div class="col-6 col-lg-4 center_forms_input">
                    <span style='color:red'><?php if(isset($emailErr)) foreach ($emailErr as $err) echo $err?></span>
                    <input type="email" class="form-control" name="email" placeholder="Email*" required>
                </div>
                <br>

                <div class="col-12 col-lg-4 center_forms_input">
                    <span style='color:red'><?php echo $passwordErr;?></span>
                    <input type="password" class="form-control" name="password" placeholder="Password*" required>
                </div>
                <br>

                <div class="col-4 center_forms_input">
                    <button class="btn bueno-btn submit-btn " type="submit">login</button>
                </div>
            </div>
        </form>
    </div>
<br>

    <p><a href="forgetPassword.php">Forget Password?</a></p>
    <p><a href="signUp.php">Don't have an account?</a></p>
</div>

<?php include('include/footer.php')?>
