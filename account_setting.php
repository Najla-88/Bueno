<!-- User(Loged up) Header -->
<?php
session_start(); 
if(isset($_SESSION['user_info'])){
include('include/header.php')?>
 <link rel="stylesheet" href="css/account_setting.css">

<!-- Validation of Form  -->
<?php

// define variables and set to empty values
$userName = "";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if(isset($_POST['submit']))
    { 
        $files = $_FILES['profile'];
        $nameImg = $files['name'];
        $tmp_nameImg = $files['tmp_name'];
        $errorImg = $files['error'];
        $sizeImg = $files['size'];

        $extensions = array('jpg', 'gif', 'png', 'jpeg');
        $file4 = explode('.', $nameImg);
        $fileExtension = strtolower(end($file4));

        if($errorImg != 4)
        {
            if($sizeImg > 2097152){ //means 2MB
                $errors['img']['size'] = "size is too large!";
            }
            if(!in_array($fileExtension , $extensions)){
                $errors['img']['exten'] = "file extension is not valid!";
            }
        }
    }


    if (empty($_POST["userName"])) {
    $errors['userNameErr']['empty'] = "user name is required";
    } 
    else {
            $userName = test_input($_POST["userName"]);
            // check if userName only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z0-9-_' ]*$/",$userName)) {
            $errors['userNameErr']['invalid_char'] = "Only letters, numbers and white space allowed";
            }
        }

        if(!empty($_POST['birthdate']))
        {
            $parts = explode('-', $birth_date);
            $bd = $parts[0];
            echo $bd."<br>";
            if($bd > 2016 || $bd < 1940){
                $input_errors['birthdate'] = "Invalid Birthdate";
            }
            $newBirthdate = $_POST['birthdate'];
        }
        else
        $newBirthdate ="0000-00-00";


    if(isset($_POST['gender']))
        $newGender = substr($_POST['gender'], 0,1);

    if(empty($errors))
    {
        $nameImg = "img/profile/".$nameImg;
        if(isset($files) && $errorImg != 4){
            move_uploaded_file($tmp_nameImg, $nameImg);
        }  
        elseif(!empty(get_by_id('users', $user_id, 'img')))
            $nameImg = "img/profile/".get_by_id('users', $user_id, 'img');
        else
            $nameImg="";    

        if($userName !== get_by_id('users', $user_id, 'Name') ||
        $newGender !== get_by_id('users', $user_id, 'gender') || 
        $newBirthdate !== get_by_id('users', $user_id, 'birthdate') ||  
        $nameImg !== get_by_id('users', $user_id, 'img'))
        {
                $sql = "UPDATE users SET Name=?, gender=?, img=?, birthdate=? WHERE id=? ";
                $stm = $conn -> prepare($sql);
                $stm -> execute(array($userName, $newGender, $nameImg, $newBirthdate, $user_id));    
        
            if($stm -> rowCount()){
                echo "<script>
                        alert('✔ Row Updated');
                        window.open('index.php','_self');
                    </script>";
            }
            else
            echo "true";
                echo "<p class = 'sql_operation'>✖ NO Row Updated</p>";     
            }
            else
            echo "<script>
                    alert('✔ No change');
                    window.open('index.php','_self');
                </script>";
        }
}
?>

<!-- profile settings start -->

    <div class="container">
        <div class="row">
          <div class="col-md-4 mt-1">
              <div class="card-body">
                <img src="<?php 
                    if(get_by_id('users', $user_id, 'img')!=null)
                          echo get_by_id('users', $user_id, 'img');
                    else 
                        echo "img/profile/solidUser.svg";
                    ?>" class="rounded-circle profile_img" alt="picuture">
              </div>
          </div>
          <div class="col-md-8 mt-1">
              <div class="card mb-3 content card_header">
                <h2 class="m-3 pt-3"> Profile </h2>
                <div class="card-body profile_card_body">

                <div class="contact-form-area ">
                <form method="post"  enctype="multipart/form-data" >
                    
                        <div class="col-12 col-lg-7 ">
                            <label>Change Profile:</label>
                            <span class="text-danger"> <?php if(!empty($errors['img'])){foreach($errors['img'] as $error){ echo '<br>'.$error;}}?></span>
                            <input type="file" class="form-control" name="profile">
                        </div>
                        
                        <div class="col-12 col-lg-7 ">
                            <label>user name:</label>
                            <span class="text-danger"> <?php if(!empty($errors['userNameErr'])){foreach($errors['userNameErr'] as $error){ echo '<br>'.$error;}}?></span>
                            <input type="text" class="form-control" name="userName" required value="<?php echo get_by_id('users', $user_id, 'Name'); ?>">
                        </div>
                        <div class="col-12 col-lg-7 ">
                            <label>Email:</label>
                            <p class="userFixedInfo" style="height: 54px; 
                                                            font-size: 12px;
                                                            margin-bottom: 15px;
                                                            background-color:white;
                                                            border: 1px solid #dadfe5;
                                                            border-bottom: 2px solid #dadfe5;
                                                            border-radius: 0;
                                                            padding: 15px 30px;
                                                            font-weight: 500;">
                            <?php echo get_by_id('users', $user_id, 'email'); ?></p>
                        </div>
                        <div class="form-group  pl-4">
                            <label>Gender:</label>
                            <br>
                            <input type="radio" name="gender" value="m" <?php if(get_by_id('users', $user_id, 'gender') == 'm')echo 'checked="checked"' ?>>
                            <label>Male</label><br>
                            <input type="radio" name="gender" value="f" <?php if(get_by_id('users', $user_id, 'gender') == 'f')echo 'checked="checked"' ?>>
                            <label>Female</label><br>
                        </div>
                        <div class="form-group pl-4 pb-5">
                            <label>Birthdate:</label>
                            <br>
                            
                        <span style="color:red;">* 
                        <?php 
                        if(isset($input_errors['birthdate']))
                        {
                            echo $input_errors['birthdate'];
                        }
                        ?></span>
                            <input type="date" id="birthdate" name="birthdate" value="<?php echo get_by_id('users', $user_id, 'birthdate') ?>">
                        </div>

                        <div class="col-7">
                            <button class="btn bueno-btn submit-btn" name="submit" type="submit" >Save Changes</button>
                        </div>
                    
                </form>
            <!-- information form end-->
                </div>
            </div>
            
            </div>    
        </div>
      </div>
    </div>
    
<?php include('include/footer.php');
} 
else {
  echo "<h2 style='text-align:center'>you have to <a href='../login.php'>login<a> first</h2>";
}
?>