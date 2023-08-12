<?php
session_start();
if(isset($_SESSION['user_info'])&& $_SESSION['user_info']['permission_id']==1){
include('include/header.php');?>
<div class="container " >
    <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><i class="fa fa-tasks"></i>Users</h2>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-8">

                <?php
                    if(isset($_POST['addUser'])){
                        $name = trim($_POST['name']);
                        $email = trim($_POST['email']);
                        $password = trim($_POST['password']);
                        $confirm_Password = $_POST['cpassword'];
                        if(isset($_POST['gender']))
                        $gender = $_POST['gender'];
                        $user_type = $_POST['user_type'];
                        $birthdate = $_POST['birthdate'];

                        $files = $_FILES['image'];
                        $nameImg = $files['name'];
                        $tmp_nameImg = $files['tmp_name'];
                        $errorImg = $files['error'];
                        $sizeImg = $files['size'];

                        $errors = array();

                        if(empty($_POST['name'])){
                            $errors['name']['empty_Name'] = "<span class='errors'>Name is required</span>";
                        }
                        else{
                            if(is_numeric($name)){
                            $errors['name']['numeric_Name'] = "<span class='errors'>Name must be string</span>";
                            }
                            if(in_table('users', 'Name', $name)){
                                $errors['name']['name_used'] = "<span class='errors'>This user name is already used</span>";
                            }
                        }

                        if(empty($email)){
                            $errors['email']['empty_email'] = "<span class='errors'>Email is required</span> ";
                        }
                        else{
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errors['email']['invalid_email'] = "<span class='errors'>Invalid email format</span> ";
                            }
                            if(in_table('users', 'email', $email)){
                                $errors['email']['email_used'] = "<span class='errors'>Email is already used before</span>";
                            }
                        }

                        if(empty($password)){
                            $errors['password']['empty_password'] = "<span class='errors'>Password is required</span>";
                        }
                        else{
                            if(!preg_match("/^[a-zA-Z0-9-_!@#$%^&*~:;.,?']*$/",$password)){
                            $errors['password']['invalid_Password'] = "<span class='errors'>Only letters, numbers and underscor</span>";
                            }
                            if(strlen($password) < 5){
                                $errors['password']['short_Password'] = "<span class='errors'>Password is too short, enter 5 letters at least</span>";
                            }
                        }
                        if(empty($confirm_Password)){
                            $errors['cpassword']['empty_cpassword'] = "<span class='errors'>Password is required</span>";
                        }
                        else{
                            if($password <> $confirm_Password){
                                $errors['cpassword']['not_Identical_Password'] = "<span class='errors'>Password not the same</span>";
                            }
                        }

                        if(isset($_POST["birthdate"])&& !empty($_POST["birthdate"]))
                        {
                            $parts = explode('-', $birthdate);
                            $bd = $parts[0];
                            if($bd > 2016 || $bd < 1940){
                                $errors['birthdate'] = "Invalid Birthdate";
                            }

                            $birth_date = $_POST["birthdate"];
                        }

                        $extensions = array('jpg', 'gif', 'png', 'jpeg');
                        $file_explode = explode('.', $nameImg);
                        $fileExtension = strtolower(end($file_explode));
                        if(isset($files) && $fileExtension != "")
                        {
                                if($sizeImg > 2097152){//means 2MB
                                    $errors['image']['large_size_image'] = "<span class='errors'>size is too large</span>!";
                                }
                                if(!in_array($fileExtension , $extensions)){
                                    $errors['image']['invalid_extension'] = "<span class='errors'>file extension is not valid</span>!";
                                }
                        }

                        if(empty($errors)){
                            if(isset($files)){
                                move_uploaded_file($tmp_nameImg, "../img/profile/" .$nameImg);
                                $nameImg = "img/profile/".$nameImg;
                            }
                            $password = password_hash($password,PASSWORD_DEFAULT);
                            $sql = "INSERT INTO users(Name, email, Password, gender, img, birthdate, permission_id) VALUES (?, ?, ?, ?, ?, ?, ?) ";
                            $stm = $conn -> prepare($sql);
                            $stm -> execute(array($name, $email, $password, $gender, $nameImg, $birthdate, $user_type));


                            if($stm -> rowCount())
                            {
                                echo "<div class='alert alert-success'>Row inserted</div>";
                              }
                        }
                        else {
                            echo "<div class='alert alert-danger'>Row not inserted</div>";
                        }
                    }
                ?>
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-plus-circle"></i> Add New user
                            </div>
                            <br>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label>Name</label>
                                                <?php
                                                    if(isset($errors['name'])){
                                                        foreach($errors['name'] as $nameErr){
                                                            echo $nameErr;
                                                        }
                                                    }
                                                ?>
                                                <input type="text" placeholder="User Name" name="name" class="form-control" required/>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <span class = "errors">
                                                    <?php
                                                        if(isset($errors['email'])){
                                                            foreach($errors['email'] as $emailErr){
                                                                echo $emailErr;
                                                            }
                                                        }
                                                    ?>
                                                </span>
                                                <input type="email" placeholder="User email" name="email" class="form-control" required/>
                                            </div>

                                            <div class="form-group">
                                                <label>Password</label>
                                                <span class = "errors">
                                                    <?php
                                                        if(isset($errors['password'])){
                                                            foreach($errors['password'] as $passwordErr){
                                                                echo $passwordErr;
                                                            }
                                                        }
                                                    ?>
                                                </span>
                                                <input type="password" placeholder="User password" name="password" class="form-control" required/>
                                            </div>

                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <span class = "errors">
                                                    <?php
                                                        if(isset($errors['cpassword'])){
                                                            foreach($errors['cpassword'] as $cpasswordErr){
                                                                echo $cpasswordErr;
                                                            }
                                                        }
                                                    ?>
                                                </span>
                                                <input type="password" placeholder="Confirm password" name="cpassword" class="form-control" required/>
                                            </div>

                                            <div class="form-group">
                                                <label>Gender:</label>
                                                <br>
                                                <input type="radio" name="gender" value="male" >
                                                <label>Male</label><br>
                                                <input type="radio" name="gender" value="female" >
                                                <label>Female</label><br>
                                            </div>
                                            <div class="form-group">
                                                <label>Birthdate:</label>
                                                <br>
                                                <span class = "errors">
                                                    <?php
                                                        if(isset($errors['birthdate'])){
                                                           echo $errors['birthdate'];
                                                            
                                                        }
                                                    ?>
                                                </span>
                                                  <input type="date" id="birthdate" name="birthdate">
                                            </div>

                                            <div class="form-group">
                                                <label>Permission</label>
                                                <select id="select" name="user_type"  class="custom-select form-control " required="required">
                                                    <option></option>
                                                <?php
                                                    $sql= "SELECT * FROM permissions";
                                                    $stm= $conn->prepare($sql);
                                                    $stm->execute();
                                                    if($stm->rowCount()){
                                                        foreach($stm->fetchAll() as $row){

                                                ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                                <?php
                                                        }}
                                                ?>
                                              </select>

                                              <div class="form-group">
                                                <br>
                                                <span class = "errors">
                                                    <?php
                                                        if(isset($errors['image'])){
                                                            foreach($errors['image'] as $imageErr){
                                                                echo $imageErr;
                                                            }
                                                        }
                                                    ?>
                                                </span>
                                                <label>Profile Image 📷</label>
                                                <input type="file" placeholder="profile" name="image" class="form-control" />
                                            </div>

                                            </div>
                                            <div style="float:right;">
                                                <button name="addUser" type="submit" class="btn btn-success">Add user</button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-tasks"></i> Users
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover " id="dataTables-example">

                                        <?php
                                            if(isset($_GET['action'], $_GET['id'])){
                                                $id = $_GET['id'];
                                                switch($_GET['action']){
                                                    case "delete":
                                                        $sql = "DELETE FROM users where id=:userid";
                                                        $stm = $conn-> prepare($sql);
                                                        $stm->execute(array("userid"=>$id));
                                                        if($stm->rowCount() == 1){
                                                            echo "<div class='alert alert-success'>One Row Deleted</div>";
                                                        }
                                                        else{
                                                            echo "<div class='alert alert-danger'>Deleted Faild!</div>";
                                                        }
                                                    break;
                                                    case "active":
                                                        $sql = "UPDATE users SET status = 0 WHERE  id=:userid";
                                                        $stm = $conn-> prepare($sql);
                                                        $stm->execute(array("userid"=>$id));
                                                    break;
                                                    case "inactive":
                                                        $sql = "UPDATE users SET status = 1 WHERE  id=:userid";
                                                        $stm = $conn-> prepare($sql);
                                                        $stm->execute(array("userid"=>$id));
                                                    break;

                                                }
                                            }
                                            
                                        ?>

                                        <thead>                                        
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>gender</th>
                                                <th>Permission</th>
                                                <th>action</th>
                                                <th>Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql= "SELECT * FROM users  ORDER BY id ";
                                                $stm= $conn->prepare($sql);
                                                $stm->execute();
                                                if($stm->rowCount()){
                                                    $row_no=0;
                                                    foreach($stm->fetchAll() as $row){
                                            ?>
                                            <tr class="odd gradeX">
                                                <td> <?php $row_no++; echo $row_no;?></td>
                                                <td> <?php echo $row['Name'];?> </td>
                                                <td> <?php echo $row['email'];?> </td>
                                                <td> <?php
                                                switch ($row['gender']) {
                                                    case 'f':
                                                        echo "Femail";
                                                        break;
                                                    case 'm':
                                                        echo "Mail";
                                                        break;
                                                    default:
                                                        break;
                                                } ?> </td>
                                                <td> <?php echo get_by_id('permissions' , $row['permission_id'], 'name');?> </td>
                                                <td>
                                                    <a href="edit.php?action=edituser&id=<?php echo $row['id']?>" class='btn btn-success'>Edit</a>
                                                    <a href="?action=delete&id=<?php echo $row['id']?>" class='btn btn-danger' onclick="return confirm('Are You Sure?')">Delete</a>
                                                </td>
                                                      <?php
                                                        if ($row['status']==1) {
                                                          ?>
                                                           <td><a href="?action=active&id=<?php echo $row['id']?>" class='btn btn-success'>Active</a></td>
                                                        <?php  }

                                                          else {?>

                                                             <td><a href="?action=inactive&id=<?php echo $row['id']?>" class='btn btn-danger'>Inactive</a></td>
                                                         <?php }
                                                      ?>
                                            </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                    <!-- /. ROW  -->
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>
    </div>
</div>

<?php include('include/footer.php');
}
else {
  echo "<h2 style='text-align:center'>you have to <a href='../login.php'>login<a> first</h2>";
} ?>
