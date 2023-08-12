<?php
session_start(); 
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['permission_id']==1 ){
include('include/header.php');?>
<div class="container " >
    <div id="page-wrapper">
        <?php
            if(isset($_GET['action'],$_GET['id']))
            {
                    switch ($_GET['action']) {
                    case 'edituser':
                        { ?><!-- //case open-->
                            
                                <div id="page-inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2><i class="fa fa-tasks"></i>Edit User</h2>
                                            </div>
                                        </div>
                                    <!-- /. ROW  -->
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php
                                                $id = $_GET['id'];
                                                
                                                $sql = "SELECT * FROM users WHERE id=:userid";
                                                $stm = $conn-> prepare($sql);
                                                $stm->execute(array("userid"=>$id));
                                                if($stm->rowCount())
                                                {
                                                    $row= $stm->fetch() ;
                                                            $name = $row['Name'];
                                                            $email = $row['email'];
                                                            $permission = get_by_id('permissions', $row['permission_id'], 'name');

                                                    if(isset($_POST['addUser']))
                                                    {
                                                        $id = $_POST['id'];
                                                        $newPermission = $_POST['permission'];

                                                            $sql = "UPDATE users SET permission_id=? WHERE id=? ";
                                                            $stm = $conn -> prepare($sql);
                                                            $stm -> execute(array($newPermission, $id));
                                                            

                                                            if($stm -> rowCount()){
                                                                echo "<script>
                                                                        alert('✔ Row Updated');
                                                                        window.open('users_table.php','_self');
                                                                    </script>";
                                                            }
                                                            else
                                                            {
                                                                echo "<script>
                                                                           alert('✔ no change');
                                                                           window.open('users_table.php','_self');
                                                                       </script>";     
                                                            }       
                                                    }
                                                
                                            ?>
                                            <!-- Form Elements -->
                                            <div class="panel panel-default">
                                            
                                                <br>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <form role="form" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?php echo $id ?>" />
                                                                        <div class="form-group">
                                                                            <label>Name</label>
                                                                            <div class="col-12 col-lg-7 ">
                                                                                <p style="    
                                                                                        color: #495057;
                                                                                        border: 1px solid #ced4da;
                                                                                        border-radius: 0.25rem;
                                                                                        width: 732px;
                                                                                        height: calc(2.25rem + 2px);
                                                                                        padding: 0.375rem 0.75rem;
                                                                                        ">
                                                                                <?php echo $name ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Email</label>
                                                                            <div class="col-12 col-lg-7 ">
                                                                                <p  style="    
                                                                                        color: #495057;
                                                                                        border: 1px solid #ced4da;
                                                                                        border-radius: 0.25rem;
                                                                                        width: 732px;
                                                                                        height: calc(2.25rem + 2px);
                                                                                        padding: 0.375rem 0.75rem;
                                                                                        ">
                                                                                <?php echo $email ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Permission:</label>
                                                                            <!-- <div class="alert alert-success" style="width:10rem; text-align:center"><?php //echo $permission ?></div> -->
                                                                            <select id="select" name="permission" checked="<?php echo $permission ?>" class="custom-select form-control ml-3" required="required">
                                                                            <?php 
                                                                                $sql= "SELECT * FROM permissions";
                                                                                $stm= $conn->prepare($sql);
                                                                                $stm->execute();
                                                                                if($stm->rowCount()){
                                                                                    foreach($stm->fetchAll() as $row){
                                                                                
                                                                            ?>
                                                                            <option value="<?php echo $row['id'] ?>" <?php if($permission == $row['name']) echo"selected"; ?> ><?php echo $row['name'] ?></option>
                                                                            <?php
                                                                                    }}
                                                                            ?>
                                                                        </select>
                                                                        

                                                                        
                                                                    </div>
                                                                    <div style="float:right;">
                                                                        <button name="addUser" type="submit" class="btn btn-success">Edit</button>
                                                                        <a href="users_table.php" class="btn btn-danger" style="color:white">Cancel</a>
                                                                    </div>
                                                                    
                                                                    <?php } ?>
                                                                </div>
                                                            </form>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <hr />
                                        <!-- /. PAGE INNER  -->
                                    </div>
                                    <!-- /. PAGE WRAPPER  -->
                                </div>

                    <?php }  //case close
                        break;
                    
                    case 'editcate':
                        {?>
                                <div id="page-inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2><i class="fa fa-tasks"></i> Categories</h2>


                                        </div>
                                    </div>
                                    <!-- /. ROW  -->
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-8">
                                            <!-- Form Elements -->
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-plus-circle"></i> Edit Category
                                                </div>


                                                <br>
                                                <div class="panel-body">
                                                    <div class="row">

                                                    <?php
                                                        $id_from_get=$_GET['id'];
                                                        $cat_name = get_by_id('categories' , $id_from_get , 'name');
                                                        $cat_img =  get_by_id('categories' , $id_from_get , 'img');
                                                        if(isset($cat_name))
                                                        {
                                                            if (isset($_POST['AddCategory'])) {
                                                                $current_id=$_POST['id'];
                                                                $new_cat_name=test_input($_POST['name']);
                                                                $errors=array();
                                                                if(is_numeric($new_cat_name))
                                                                {
                                                                    $errors['name']['numeric']="Name must be string!";
                                                                }
                                                                elseif(empty($new_cat_name))
                                                                {
                                                                    $errors['name']['empty']="Category name is required!";
                                                                }
                                                                if(isset($_FILES['catimage'])){
                                                                    $file = $_FILES['catimage'];
                                                                    $img_name = $file['name'] ;
                                                                    $tmp_name = $file['tmp_name'] ;
                                                                    $error = $file['error'] ;
                                                                    $size = $file['size'] ; 

                                                                    //pathinfo = get file extension
                                                                    $fileExtension = pathinfo($img_name, PATHINFO_EXTENSION);
                                                                    $fileExtension = strtolower($fileExtension);
                                                                    $extensions = array('jpg', 'gif', 'png', 'jpeg');
                                                                    if($fileExtension != "")
                                                                    {
                                                                            if($size > 2097152){ //means 2MB
                                                                                $errors['imgs']['size'] = "size is too large!";
                                                                            }
                                                                            if(!in_array($fileExtension , $extensions)){
                                                                                $errors['imgs']['exten'] = "file extension is not valid!";
                                                                            }
                                                                            if(empty($errors['imgs'])){
                                                                                move_uploaded_file($tmp_name, "../img/categories-img/" .$img_name);
                                                                                
                                                                            }
                                                                    }   
                                                                    if($error==0)
                                                                    $img =  "img/categories-img/" .$img_name;
                                                            } 
                                                                //img validation END


                                                                if(empty($errors)){
                                                                    $sql="update categories set name=? where id =? ";
                                                                    $stm = $conn->prepare($sql);
                                                                    $stm->execute(array($name,$id));
                                                                    if ($stm->rowcount())
                                                                    {
                                                                    echo "<script>
                                                                    alert('Row updated');
                                                                    window.open('categories_table.php','_self');
                                                                    </script>";
                                                                    }
                                                                    else {
                                                                    echo "<div class='alert alert-danger'>Row not updated</div>";
                                                                    }

                                                                }
                                                                }
                                                    ?>


                                                    <div class="col-md-12">

                                                        <form role="form", method="post">
                                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                                    <div class="form-group">
                                                                        <label>Name</label>
                                                                        <input type="text" placeholder="Category Name " name="name" value="<?php echo $cat_name; ?>"
                                                                            class="form-control" require />
                                                                            <i style="color:red;">
                                                                            <?php
                                                                                if (isset($errors['name'])) {
                                                                                    foreach ($errors['name'] as $err) 
                                                                                        echo $err;
                                                                                }
                                                                                ?>
                                                                            </i>
                                                                    </div>
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
                                                                            <label>category Image 📷</label>
                                                                            <span><img  class="aImage" src="<?php echo '../'.$cat_img ?>" alt=""></span>
                                                                            <input type="file" name="catimage" class="form-control" />
                                                                        </div>
                                                                    <div style="float:right;">
                                                                        <button type="submit" class="btn btn-success" name="AddCategory">Edit Category</button>
                                                                        <a href="categories_table.php" type="reset" class="btn btn-danger">Cancel</a>
                                                                    </div>

                                                            </div>
                                                            <?php } ?>
                                                        </form>

                                                    </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <hr />
                                        <!-- /. PAGE INNER  -->
                                    </div>
                                <!-- /. PAGE WRAPPER  -->
                                </div>
                <?php   }
                        break;
                        case 'editrec':
                            {?>
                                <div id="page-inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2><i class="fa fa-tasks"></i> Edit Recipe</h2>
                                        </div>
                                    </div>
                                    <!-- /. ROW  -->
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-8">

                                        <?php
                                        $id = $_GET['id'];
                                                                        
                                        $sql = "SELECT * FROM recipe WHERE ID=:recipeid";
                                        $stm = $conn-> prepare($sql);
                                        $stm->execute(array("recipeid"=>$id));
                                        if($stm->rowCount())
                                        {
                                            $row = $stm->fetchAll();
                                                $name = $row[0]['name'];
                                                $description = $row[0]['description'];
                                                $text = $row[0]['text'];  
                                                $img = $row[0]['img'];
                                                $time = $row[0]['time'];
                                                $cat_id = $row[0]['cat_id'];
                                                $category = get_by_id('categories', $row[0]['cat_id'], 'name');
                                                $ingredients = $row[0]['ingredients'];

                                            if(isset($_POST['submitRecipe']))
                                            {
                                                $id = $_POST['id'];

                                                $newName = test_input($_POST['name']);
                                                $newDiscription = test_input($_POST['description']);
                                                $newText = test_input($_POST['steps']);
                                                $newCategory = $_POST['select_category'];
                                                $time = get_sys_date();
                                                $newIngredients = test_input($_POST['ingredients']);

                                                $files = $_FILES['image'];
                                                $nameImg = $files['name'];
                                                $tmp_nameImg = $files['tmp_name'];
                                                $errorImg = $files['error'];
                                                $sizeImg = $files['size'];


                                                $errors = array();

                                                if(empty($newName))
                                                {
                                                    $errors['name']['empty_Name'] = "<span class='errors'>Name is required</span>";
                                                }
                                                else{
                                                    if(in_table('recipe', 'name', $name) && $_GET['id']<>$_POST['id']){
                                                        $errors['name']['name_used'] = "<span class='errors'>This recipe name is already used</span>";
                                                    }
                                                }
                                                
                                                if(empty($newIngredients)){
                                                    $errors['ingredients'] = "<span class='errors'>	Ingredients are required</span>";
                                                }

                                                if(empty($newText)){
                                                    $errors['steps'] = "<span class='errors'>Steps are required</span>";
                                                }
                                                
                                                if(empty($newCategory)){
                                                    $errors['category'] = "<span class='errors'>Category is required</span>";
                                                }
                                                
                                                
                                                $extensions = array('jpg', 'gif', 'png', 'jpeg');
                                                $file_explode = explode('.', $nameImg);
                                                $fileExtension = strtolower(end($file_explode));
                                                if(isset($files) && $fileExtension != "")
                                                {
                                                        if($sizeImg > 2097152){//means 2MB
                                                            $errors['image']['large_size_image'] = "<span class='errors'>size is too large!</span>";
                                                        }
                                                        if(!in_array($fileExtension , $extensions)){
                                                            $errors['image']['invalid_extension'] = "<span class='errors'>file extension is not valid!</span>";
                                                        }   
                                                                                
                                                }
                                                                        
                                                if(empty($errors))
                                                {
                                                    if(isset($files) && $errorImg != 4){
                                                        move_uploaded_file($tmp_nameImg, "../img/bg-img/" .$nameImg);
                                                        $nameImg = "img/bg-img/".$nameImg;
                                                    }  
                                                    else
                                                        $nameImg = $img;
                                                        //ID`, `name`, `description`, `text`, `img`, `time`, `cat_id
                                                    $sql = "UPDATE recipe SET name=?, description=?, text=?, img=?, time=?, cat_id=? WHERE ID=? ";
                                                    $stm = $conn->prepare($sql);
                                                    $stm -> execute(array($newName, $newDiscription, $newText, $nameImg, $time, $newCategory, $id));

                                                    if($stm -> rowCount()){
                                                        echo "<script>
                                                                alert('✔ Row Updated');
                                                                window.open('recepies_table.php','_self');
                                                            </script>";
                                                    }
                                                }
                                                else
                                                    echo "<p class = 'sql_operation'>✖ NO Row Updated</p>";
                                            }
                                    ?>

                                        <!-- Form Elements -->
                                        <div class="panel panel-default">
                                                
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form role="form" method="post" enctype="multipart/form-data">
                                                                    
                                                                        <input type="hidden" name="id" value="<?php echo $id ?>" />

                                                                        <div class="form-group">
                                                                            <label>Name</label>
                                                                            <?php
                                                                                if(isset($errors['name'])){
                                                                                    foreach($errors['name'] as $nameErr){
                                                                                        echo $nameErr;
                                                                                    }
                                                                                }
                                                                            ?> 
                                                                            <input type="text" name="name" value="<?php echo $name ?>" class="form-control" />
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Category</label>
                                                                            <!-- <div class="alert alert-success" style="width:10rem; text-align:center"><?php //echo $category ?></div> -->
                                                                            <?php
                                                                                if(isset($errors['category'])){
                                                                                    foreach($errors['category'] as $categoryErr){
                                                                                        echo $categoryErr;
                                                                                    }
                                                                                }
                                                                            ?> 
                                                                            <select id="select" name="select_category" value="<?php echo $category ?>" class="custom-select form-control " required="required">
                                                                            <?php 
                                                                                $sql= "SELECT * FROM categories";
                                                                                $stm= $conn->prepare($sql);
                                                                                $stm->execute();
                                                                                if($stm->rowCount()){
                                                                                    foreach($stm->fetchAll() as $row){    
                                                                            ?>
                                                                            <option value="<?php echo $row['id'] ?>" <?php if($category == $row['name']) echo"selected"; ?> ><?php echo $row['name'] ?></option>
                                                                            <?php }} ?>
                                                                            
                                                                        </select>                                                 
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="pb-2">Description</label>
                                                                            <textarea rows="5" name="description" class="form-control"><?php echo $description ?></textarea>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Ingredients</label>
                                                                            <?php
                                                                                if(isset($errors['ingredients'])){
                                                                                    foreach($errors['ingredients'] as $ingErr){
                                                                                        echo $ingErr;
                                                                                    }
                                                                                }
                                                                                ?> 
                                                                            <textarea name="ingredients" rows="5" class="form-control" required><?php echo $ingredients ?> </textarea>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Steps</label>
                                                                            <?php
                                                                                if(isset($errors['steps'])){
                                                                                    foreach($errors['steps'] as $stepsErr){
                                                                                        echo $stepsErr;
                                                                                    }
                                                                                }
                                                                                ?> 
                                                                            <textarea name="steps" rows="5" class="form-control" required><?php echo $text ?> </textarea>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>image</label>
                                                                            <?php
                                                                                if(isset($errors['image'])){
                                                                                    foreach($errors['image'] as $imageErr){
                                                                                        echo $imageErr;
                                                                                    }
                                                                                }
                                                                            ?> 
                                                                            <span><img class="aImage" src="../<?php echo $img ?>" alt=""></span>
                                                                            <input type="file" name="image"  class="form-control" />
                                                                        </div>
                                                                        
                                                                        <div style="float:right;">
                                                                            <button name="submitRecipe" type="submit" class="btn btn-success">Edit</button>
                                                                            <a href="recepies_table.php" type="reset" class="btn btn-danger">Cancel</a>
                                                                        </div>
                                                                        
                                                                        <?php } ?>
                                                                </div>
                                                                </form>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr />

                                        
                                    </div>
                                    <!-- /. PAGE WRAPPER  -->
                                </div>
                    <?php   }
                            break;    
                    default:
                        echo '<p style="font-size: x-large; font-weight: 500; text-align: center; color:red; ">action is wrong !!!</p>';
                        break;
            }}
        ?>


    </div>
</div>

<?php include('include/footer.php'); 
} 
else {
  echo "<h2 style='text-align:center'>you have to <a href='../login.php'>login<a> first</h2>";
}
?>
