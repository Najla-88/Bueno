<?php
session_start();  
if(isset($_SESSION['user_info'])&& $_SESSION['user_info']['permission_id']==1){
include('include/header.php');?>
   
        <!-- /. NAV SIDE  -->
<div class="container ">
    <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><i class="fa fa-tasks"></i>Recipes</h2>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-8">
<?php
    $recipeName = $description = $text = $ingredients = $time = $cat_id = "" ;
    $img ;
    $errors = array();

    
        if (isset($_POST['submitRecipe'])) 
        {
            // name validation 

            if (empty($_POST["name"])) 
            {
                $errors['recepei_name']['empty'] = "recepie name is required";
            } 
            else 
            {
                $recipeName = test_input($_POST["name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z0-9-_' ]*$/",$recipeName))
                {
                    $errors['recepei_name']['syntax'] = "Only letters, numbers and white space allowed";
                }
                elseif(in_table('recipe', 'name', $recipeName)){
                    $errors['recepei_name']['repeated']="Category name is repeated";
                }
            }
            // name validation end
        ///////////////////////////////////
            // img validation strat
                $file = $_FILES['file'];
                $name = $file['name'] ;
                $tmp_name = $file['tmp_name'] ;
                $error = $file['error'] ;
                $size = $file['size'] ; 
        
                $extensions = array('jpg', 'gif', 'png', 'jpeg');
                $file4 = explode('.', $name);
                $fileExtension = strtolower(end($file4));
                if(isset($file) && $fileExtension != "")
                {
                        if($size > 2097152){//means 2MB
                            $errors['imgs']['size'] = "size is too large!";
                        }
                        if(!in_array($fileExtension , $extensions)){
                            $errors['imgs']['exten'] = "file extension is not valid!";
                        }
                        if(empty($errors['imgs'])){
                            move_uploaded_file($tmp_name, "../img/bg-img/" .$name);
                        }
                }    
            // img validation END
        ///////////////////////////////////
        
            // category validation 
           if(empty($_POST['select_category']))
            {
                $errors['category'] = "category is required ";
            }
            else 
                $cat_id = $_POST['select_category'];

            // description validation 

            if(empty($_POST['description']))
            {
                $errors['description'] = "Description is required ";
            }
            else
            $description = test_input($_POST['description']);
        
            // ingredients validation 
            if(empty(test_input($_POST['ingredients'])))
            {
                $errors['ingredients'] = "ingredients is required ";
            }
            else 
                $ingredients = $_POST['ingredients'];
            
            // steps validation 
            if(empty(test_input($_POST['steps'])))
            {
                $errors['steps'] = "steps is required ";
            }
            else 
                $text = $_POST['steps'];
        
                
            // set current date to variable time 
            $time = get_sys_date();
            
            if(empty($errors))
            {
                $img =  "img/bg-img/" .$name;
                //$name = image name
                
                $sql= "INSERT INTO recipe ( name, description, text, img, time, cat_id , ingredients) VALUES (?,?,?,?,?,?,?)";
                $stm= $conn->prepare($sql);
                $stm->execute(array($recipeName, $description, $text,$img, $time ,$cat_id ,$ingredients));
                if($stm->rowCount()){
                   echo "<div class='alert alert-success'>Recepie inserted</div>" ;       
                }
                else{
                    echo "<div class='alert alert-danger'>Recepie not inserted</div>";   
                }
            }
        }//end if (isset($_POST['submitRecipe']))
    
?>
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="pb-2">Name</label>
                                                <br>
                                                <span class="text-danger">
                                                <?php
                                                    if(isset($errors['recepei_name']))
                                                    {
                                                        foreach ($errors['recepei_name'] as $err) {
                                                            echo $err;
                                                        }
                                                    }
                                                ?>
                                                </span>
                                                <input type="text" placeholder="Recepy name"
                                                    name="name" class="form-control" required/>
                                            </div>

                                            <div class="form-group">
                                                <label class="pb-2">Description</label>
                                                <span class="text-danger">
                                                <?php
                                                    if(isset($errors['description']))
                                                    {
                                                            echo $errors['description'];
                                                    }
                                                ?>
                                                </span>
                                                <input type="text" placeholder="Recepy description"
                                                    name="description" class="form-control" required/>
                                            </div>

                                            <div class="form-group">
                                                <label class="pb-2">image</label>
                                                <span class="text-danger"> 
                                                <?php
                                                    if(isset($errors['imgs']))
                                                    {
                                                        foreach ($errors['imgs'] as $err) {
                                                            echo $err;
                                                        }
                                                    }
                                                ?>
                                                <input type="file" name="file" class="form-control" >
                                            </div>

                                            <div class="form-group">
                                                <label>Category</label>
                                                <?php
                                                    if(isset($errors['category'])){
                                                        echo 1;
                                                        foreach($errors['category'] as $categoryErr){
                                                            echo $categoryErr;
                                                        }
                                                    }
                                                ?> 
                                                <select id="select" name="select_category"  class="custom-select form-control " required>
                                                    <option></option>
                                                    <?php 
                                                        $sql= "SELECT * FROM categories  ORDER BY id ";
                                                        $stm= $conn->prepare($sql);
                                                        $stm->execute();
                                                        if($stm->rowCount()){
                                                            foreach($stm->fetchAll() as $row){    
                                                    ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                                    <?php }} ?>
                                                
                                              </select>                                                 
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="pb-2">Ingredients</label>
                                                <br> 
                                                <span style="color:grey;">every ingredients seperate with double newline</span>
                                                <span class="text-danger">
                                                <?php
                                                    if(isset($errors['ingredients']))
                                                    {
                                                        echo $errors['ingredients'];
                                                    }
                                                ?>
                                                </span>
                                                <textarea rows="2" name="ingredients" class="form-control" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label class="pb-2">Steps</label>
                                                <br> 
                                                <span style="color:grey;">every steps seperate with double newline</span>
                                                <span class="text-danger">
                                                <?php
                                                    if(isset($errors['steps']))
                                                    {
                                                        echo $errors['steps'];
                                                    }
                                                ?>
                                                </span>
                                                <textarea rows="5" name="steps" class="form-control" required></textarea>
                                            </div>

                                            <div style="float:right;">
                                                <button name="submitRecipe" type="submit" class="btn btn-success">Add Recipe</button>
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
                                <i class="fa fa-tasks"></i> Recipes
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover "
                                        id="dataTables-example">
                                        <?php
                                            if(isset($_GET['action'], $_GET['id'])){
                                                $id = $_GET['id'];
                                                switch($_GET['action']){
                                                    case "delete":
                                                        $sql = "DELETE FROM recipe where ID=?";
                                                        $stm = $conn-> prepare($sql);
                                                        $stm->execute(array($id));
                                                        if($stm->rowCount() == 1){
                                                            echo "<div class='alert alert-success'>One Row Deleted</div>";
                                                        } 
                                                        else{
                                                            echo "<div class='alert alert-danger'>Deleted Faild!</div>";
                                                        }
                                                }
                                            }
                                        ?>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="col-md-1">Name</th>
                                                <th class="col-md-3">Description</th>
                                                <th class="col-md-1">Category</th>
                                                <th class="col-md-3">Ingredients</th>
                                                <th class="col-md-2">Time</th>
                                                <th class="col-md-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $sql= "SELECT * FROM recipe";
                                            $stm= $conn->prepare($sql);
                                            $stm->execute();
                                            if($stm->rowCount()){
                                                $row_no=0;
                                                foreach($stm->fetchAll() as $row){
                                        ?>
                                            <tr class="odd gradeX">
                                                <td><?php $row_no++; echo $row_no;?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['description'] ?></td>
                                                <td><?php

                                                    $sql= "SELECT * FROM categories WHERE ID=:cat_id";
                                                    $stm= $conn->prepare($sql);
                                                    $stm->execute(array("cat_id"=>$row['cat_id']));
                                                    if($stm->rowCount())
                                                    {
                                                        foreach($stm->fetchAll() as $r)
                                                        echo $r['name'];
                                                    } 
                                                ?></td>
                                                <td>
                                                    <?php $ingredientsArray = explode("\r\n\r\n", $row['ingredients'] );
                                                        foreach ($ingredientsArray as $ing) 
                                                        {  
                                                            echo "◾ ". $ing .".<br>"; 
                                                        }?>
                                                </td>
                                                <td><?php echo $row['time'] ?></td>
                                                <td>
                                                    <a href="edit.php?action=editrec&id=<?php echo $row['ID'] ?>" class='btn btn-success'>Edit</a>
                                                    <a href="?action=delete&id=<?php echo $row['ID'] ?>" class='btn btn-danger' onclick="return confirm('Are You Sure?')">Delete</a>
                                                </td>
                                            </tr>
                                            <?php } }?>
                                            

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
}
?>
