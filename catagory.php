<?php 
session_start(); 
include('include/header.php');
$page_num=1;
if(isset($_GET['page_num']))
{
    $page_num =$_GET['page_num'];
}

$sql = "SELECT * FROM categories";
$stm = $conn->prepare($sql);
$stm -> execute();
$row = $stm -> fetchAll();
$rows_count = $stm->rowCount();

?>
    <!-- ##### Catagory Area Start ##### -->
    <div class="post-catagory section-padding-100">
        <form  method="get" >
        <div class="container">
            <div class="row">
                
            <?php
            $category_counter = 9*($page_num -1);
                do
                {
                ?>
                <!-- Single Post Catagory -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-post-catagory mb-30">
                        <?php if(!empty($row[$category_counter]['img'])){ ?>
                        <img src="<?php echo $row[$category_counter]['img']; ?>" 
                        style="width: 350px; /* width of container */
                               height: 316.312px; /* height of container */" 
                        alt="">
                        <?php } else{ ?>
                        <img src="img/categories-img/default.jpeg" alt="">
                        <?php } ?>
                        <!-- Content -->
                        <div class="catagory-content-bg">
                            <div class="catagory-content">
                                <p class="post-tag">The Best</p>
                                <a href="catagory-post.php?catid=<?php echo $row[$category_counter]['id'];?>" class="post-title"><?php echo $row[$category_counter]['name']; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                            $category_counter++;
                        } while($category_counter<$rows_count && $category_counter%9!=0 );
                    
                     ?>
                
            </div>
        </form>
        <div class="row">
                <div class="col-12">
                    <div class="pagination-area mt-70">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i=1;$i<=ceil($rows_count/9) ;$i++){
                                   ?>
                                <li class="page-item <?php if($page_num==$i) echo "active";?>"><a class="page-link" href="catagory.php?page_num=<?php echo $i ?>">0<?php echo $i ?></a></li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
            
    <?php include('include/footer.php')?>