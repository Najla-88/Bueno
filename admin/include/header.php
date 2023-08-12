<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin page</title>

    <!-- icon -->
    <link rel="icon" href="../img/core-img/favicon.ico">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    

</head>
<body>
  <!-- connect to database BUENO -->
<?php require_once('../conn.php') ;
include('../include/logo_area.php') ;

include('../include/functions.php');

$user_id = $_SESSION['user_info']['id'] ;
?>
  <!-- profile button -->

<div class="container">
  <div class="justify-content-end" style="text-align:right">
    <a class="btn dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img src="<?php 
        if(get_by_id('users', $user_id, 'img')!=null)
        echo '../'.get_by_id('users', $user_id, 'img');
        else 
        echo "../img/profile/solidUser.svg";
        ?>" class="rounded-circle " width="35" alt="picuture">
        </a>
        
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="dropdown-item item_hover" href="admin_profile.php">Profile</a>
          <a class="dropdown-item item_hover" href="inbox.php">Inbox</a>
          <a class="dropdown-item item_hover" href="account_setting.php">Account setting</a>
          <a class="dropdown-item item_hover" href="../logout.php">Logout</a>
        </div>
      </div>
</div>

  <!-- profile button end-->

  <!-- navbar -->

  <nav class="navbar_styles mb-5">
    <ul class="navbar_list">
      <li><a href="admin_profile.php" class="list_box">Profile</a></li>
      <li><a href="dashboard.php" class="list_box">Dashboard</a></li>
      <li>
        <div>
          <a class="dropdown-toggle list_box" href="" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          </a>
          <div class="dropdown-menu " aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item item_hover" href="users_table.php">Users</a>
            <a class="dropdown-item item_hover" href="categories_table.php">Categories</a>
            <a class="dropdown-item item_hover" href="recepies_table.php">Recepies</a>
            
          </div>
        </div>
      </li>
      <li><a class="list_box" href="inbox.php">Inbox</a></li>
      <!-- <p style="font-weight: 700;
                font-size: 19px;
                display: block;
                color: #769324;
                text-align: center;
                padding-top: 14px "
                >Welcom <?php //echo $_SESSION['user_info']['Name']; ?>
      </p> -->
    </ul>
</nav>
  <!-- navbar end-->
