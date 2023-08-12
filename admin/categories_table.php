<?php
session_start(); 
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['permission_id']==1 ){
include('include/header.php');
      require_once('../conn.php');
?>
<div class="container">
<div id="page-wrapper">

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
                    <?php
                      if (isset($_POST['AddCategory'])) 
                      {
                        $name=test_input($_POST['name']);
                        $errors=array();

                        if(is_numeric($name))
                        {
                          $errors['name']['numeric']="Name must be string!";
                        }
                        elseif(empty($name))
                        {
                          $errors['name']['empty']="Category name is required";
                        }
                        elseif(in_table('categories', 'name', $name)){
                          $errors['name']['repeated']="Category name is repeated";
                        }
                        if(isset($_FILES['file']))
                        {
                                $file = $_FILES['file'];
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
                                        if($size > 2097152){//means 2MB
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

                        if(empty($errors))
                        {                                   
                          if(isset($img))
                          {
                            $sql="INSERT INTO categories(name,img) VALUES (?,?) ";
                            $stm = $conn->prepare($sql);
                            $stm->execute(array($name,$img));
                          }
                          else 
                          {
                            $sql="INSERT INTO categories(name) VALUES (?) ";
                            $stm = $conn->prepare($sql);
                            $stm->execute(array($name));
                          }
                          if ($stm->rowcount())
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
                                <i class="fa fa-plus-circle"></i> Add New Category
                            </div>
                            <br>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form", method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label>Name</label>
                                                    <i style="color:red;">
                                                       <?php
                                                          if (isset($errors['name'])) {
                                                           foreach($errors['name'] as $err) echo $err;
                                                          }
                                                        ?>
                                                    </i>
                                                <input type="text" placeholder="Category Name " name="name"
                                                    class="form-control" require />
                                                    
                                            </div>

                                            <div class="form-group">
                                                <label class="pb-2">image</label>
                                                <span class="text-danger">
                                                <input type="file" name="file" class="form-control" >
                                            </div>

                                            <div style="float:right;">
                                                <button type="submit" class="btn btn-success" name="AddCategory">Add Category</button>
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
                                <i class="fa fa-tasks"></i> Categories
                            </div>
                            <?php
                              if (isset($_GET['action'],$_GET['id'])) {
                                $id= $_GET['id'];
                                $deleted_item_name = get_by_id ('categories',$id,'name');
                                switch ($_GET['action']) {
                                  case "delete":
                                  $sql="delete FROM categories where id=:cat_id";
                                   $stm = $conn->prepare($sql);
                                  $stm->execute(array("cat_id"=>$id));
                                  if ($stm->rowcount()==1)
                                  {
                                    echo "<div class='alert alert-success'>$deleted_item_name deleted</div>";
                                  }
                                    break;
                                  default:
                                    echo "<i style='color:red'>The action is not correct try agin!</i>";
                                    break;
                                }
                              }
                             ?>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover "
                                        id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="col-md-4">Name</th>
                                                <th class="col-md-2">Image</th>
                                                <th class="col-md-3"># recipes in this category</th>
                                                <th class="col-md-3">action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <?php
                                          
                                          $sql="SELECT * FROM categories  ORDER BY id ";
                                          $stm = $conn->prepare($sql);
                                          $stm->execute();
                                          if ($stm->rowcount())
                                          {
                                            $row_no=0;
                                            foreach ($stm->fetchAll() as $row) {
                                              $id= $row['id'];
                                              $name= $row['name'];
                                              $img = $row['img'];
                                           ?>
                                            <tr class="odd gradeX">
                                                <td> <?php $row_no++; echo $row_no;?></td>
                                                <td><?php echo $name; ?></td>
                                                <td>
                                                <span><?php if(!empty($img)) { ?><img  class="aImage" src="<?php echo '../'.$img ?>" alt=""><?php } ?></span>
                                                </td>
                                                <td><?php echo fetch_recipe_counts_where($id) ?></td>
                                                <td>
                                                    <a href="edit.php?action=editcate&id=<?php echo $id; ?>" class='btn btn-success ml-3' style="float:right;">Edit</a>
                                                    <a href="?action=delete&id=<?php echo $id; ?>" class='btn btn-danger ml-3' style="float:right;" onclick="alert('are you sure?')">Delete</a>
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
