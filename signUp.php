<?php
session_start(); 
include('include/header.php');
?>
<link rel="stylesheet" href="css/login_styles.css">
<style>

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
<?php 
 $userName = $email = $password  = $birth_date = $gender = "";
    $input_errors = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (empty($_POST["userName"])) 
        {
            $input_errors['userNameErr']['empty'] = "userName is required";
        } 
        else 
        {
            $userName = test_input($_POST["userName"]);
            // check if userName only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z0-9-_ ]*$/",$userName)) 
            {
                $input_errors['userNameErr']['errchar'] = "Only letters, numbers and white space allowed";
            }
            if(in_table('users', 'Name', $userName)){
                $input_errors['userNameErr']['name_used'] = "This user name is already used";
            }
        }
        
        if (empty($_POST["email"]))
        {
            $input_errors['emailErr']['empty']= "Email is required";
        } 
        else 
        {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                $input_errors['emailErr']['invalid']= "Invalid email format";
            }
            if(in_table('users', 'email', $email)){
                $input_errors['emailErr']['email_used'] = "Email is already used before";
            }
        }
            
        if (empty($_POST["password"])) 
        {
            $input_errors['passwordErr'] = "Password is required";
        } 
        else 
        {
            $password = test_input($_POST["password"]);
            if (strlen($password) < 5) 
            {
                $input_errors['passwordErr'] = "At least 5 characters";
            }
            elseif(!preg_match("/^[a-zA-Z0-9-_!@#$%^&*~:;.,?]*$/",$password))
            {
                $input_errors['passwordErr'] = "Only litters, numbers and underscor";   
            }
        }

        if (empty($_POST["cpassword"])) 
        {
            $input_errors['confPasswordErr'] = "You have to confirm the password";
        } 
        else 
        {
            $confPassword = test_input($_POST["cpassword"]);
            if ($confPassword <> $password ) 
            {
                $input_errors['confPasswordErr'] = " Confirm password again, they are not equal!";
            }
        }
        if(isset($_POST["gender"]))
        {
            $gender = substr($_POST["gender"], 0,1);
        }
        if(isset($_POST["birthdate"])&& !empty($_POST["birthdate"]))
        {
            $parts = explode('-', $birth_date);
            $bd = $parts[0];
            if($bd > 2016 || $bd < 1940){
                $input_errors['birthdate'] = "Invalid Birthdate";
            }

            $birth_date = $_POST["birthdate"];
        }
        else
        $birth_date ="0000-00-00";

        if(empty($input_errors))
        {
            $password = password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO users 
            (Name, email, Password, gender, birthdate, permission_id) VALUES (?,?,?,?,?,?)"; 
            $stmt = $conn->prepare($sql); 
            $stmt->execute(array($userName,$email,$password,$gender,$birth_date,2)); 

          echo "<script>
                    alert('sign up complete');
                    window.open('login.php','_self');
                </script>";

        }
        
        
    }
?>

<br>
<br>

    <div class="login-container">
        <h2 class="login-header">Sign up</h2>
        <!-- SignUp Form -->
        <br>
        <br>

        <div class="contact-form-area login">
            <form method="post" >
                <div class="">
                    <div class="col-lg-4 center_forms_input left_align">
                        <label>userName:</label>
                        <span style="color:red;">* <?php
                        if(isset($input_errors['userNameErr']))
                        {
                            foreach ($input_errors['userNameErr'] as $err) {
                                echo $err;
                            }
                        }
                        ?></span>
                        <input type="text" class="form-control" name="userName" placeholder="" required>
                    </div>
                            <br>

                    <div class="col-lg-4 center_forms_input left_align">
                        <label>Email:</label>
                        <span style="color:red;">* <?php 
                        if(isset($input_errors['emailErr']))
                        {
                            foreach ($input_errors['emailErr'] as $err) {
                                echo $err;
                            }
                        }?></span>
                        <input type="email" class="form-control" name="email" placeholder="" required>
                    </div>
                            <br>

                    <div class="col-lg-4 center_forms_input left_align">
                        <label>Password:</label>
                        <span style="color:red;">* <?php 
                        
                        if(isset($input_errors['passwordErr']))
                        {
                            echo $input_errors['passwordErr'];
                        }    
                        ?></span>
                        <input type="password" class="form-control" name="password" placeholder="" required>
                    </div>
                                        <br>

                    <div class="col-lg-4 center_forms_input left_align">
                        <label>Confirm Password:</label>
                        <span style="color:red;">* <?php 
                        if(isset($input_errors['confPasswordErr']))
                        {
                            echo $input_errors['confPasswordErr'];
                        }
                        ?></span>
                        <input type="password" class="form-control" name="cpassword" placeholder="" required>
                    </div>
                                <br>    
                    <div class="col-lg-4 center_forms_input left_align">
                        <label>Gender:</label>
                        <br>
                        <input type="radio" name="gender" value="male">
                        <label>Male</label><br>
                        <input type="radio" name="gender" value="female">
                        <label>Female</label><br>
                    </div>
                    <div class="col-lg-4 center_forms_input left_align">
                    
                    <label>Birthdate:</label>
                    
                    <span style="color:red;">
                        <?php 
                        if(isset($input_errors['birthdate']))
                        {
                            echo $input_errors['birthdate'];
                        }
                        ?>
                    </span>
                    <br>
                    <input type="date" id="birthdate" name="birthdate">
                    </div>

                    <div class="col-4 center_forms_input ">
                        <button class="btn bueno-btn submit-btn" type="submit">SignUp</button>
                    </div>
                <br>
                
                </div>
            </form>
            <p>Already have an account?<a href="login.php">Login </a></p>
        </div>
    </div>

    <?php include('include/footer.php')?>
