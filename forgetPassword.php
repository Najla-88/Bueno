<?php 
session_start(); 
include('include/header.php') ?>
<link rel="stylesheet" href="css/login_styles.css">
<style>

        .center_forms_input{
                position: relative;
                margin:auto;
                text-align:center;
            }

            h4  ,p {
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
    <?php
        // define variables and set to empty values
    $emailErr = $userNameErr = "";
    $email = $userName = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            }
        }
            
        if (empty($_POST["userName"])) {
            $userNameErr = "userName is required";
        } else {
            $userName = test_input($_POST["userName"]);
            // check if userName only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9-_' ]*$/",$userName)) {
        $userNameErr = "Only letters, numbers and white space allowed";
        }
        }

        if(isset($email, $userName)){
            $sql = "SELECT * FROM users WHERE email = ? AND Name = ?";
            $stm = $conn -> prepare($sql);
            $stm -> execute(array($email , $userName));
            if($stm -> rowCount() == 1)
            {
                echo "<script>
                alert('✔ reply sent');
                window.open('login.php','_self');
                </script>";
            }
        else{
            echo "<div class='alert alert-danger text-center'>Email Or User Name is Wrong</div>";

        }
        }

    }
?>
    

    <div class="login-container">
        <br>
        <br>
        <h4 class="login-header">Did your Forget Your Password?</h4>
        <br>
        <br>
        <br>

        <!-- Login Form -->
        <div class="contact-form-area login ">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
               
                    <div class="col-6 col-lg-4 center_forms_input ">
                        <span class="error"> <?php echo $emailErr;?></span>
                        <input type="email" class="form-control" name="email" placeholder="Email*" required>
                    </div>
                    <br>

                    <div class="col-6 col-lg-4 center_forms_input">
                        <span class="error"> <?php echo $userNameErr;?></span>
                        <input type="userName" class="form-control" name="userName" placeholder="User Name*" required>
                    </div>
                    <br>    

                    <div class="col-4 center_forms_input">
                        <button class="btn bueno-btn submit-btn " type="submit">send</button>
                    </div>
                
            </form>
        </div>

        
    </div>

    <?php include('include/footer.php')?>   