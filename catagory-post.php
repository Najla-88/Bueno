<?php 
session_start(); 
include('include/header.php');
if(isset($_GET['catid']))
{
    $catid = $_GET['catid'];
    $sql = "SELECT * FROM recipe where cat_id=:catid";
    $stm = $conn->prepare($sql);
    $stm -> execute(array("catid"=>$catid));
    $rows_count = $stm->rowCount();
    $page_num=1;
    if(isset($_GET['page_num']))
    {
        $page_num =$_GET['page_num'];
    }
}
?>
<!-- ##### Catagory Post Area Start ##### -->
    <div class="catagory-post-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Post Area -->
                <div class="col-12 col-lg-10 col-xl-10">

                    <?php
                    $row= $stm -> fetchall();
                    $recepe_counter = 5*($page_num -1);
                    if($rows_count>0)
                    {
                        do
                        {
                        ?>
                    <!-- Single Blog Post -->
                    <div class="single-blog-post style-1 d-flex flex-wrap mb-30">
                        <!-- Blog Thumbnail -->
                        <div class="blog-thumbnail">
                            <img src="<?php echo $row[$recepe_counter]['img'];?>" alt="">
                        </div>
                        <!-- Blog Content -->
                        <div class="blog-content">
                            <p class="post-tag"><?php get_cat_by_id($row[$recepe_counter]['cat_id']);?> </p>
                            <a href="receipe.php?recipeID=<?php echo $row[$recepe_counter]['ID'];?>" class="post-title"><?php echo $row[$recepe_counter]['name'];?></a>
                            <p class="post-date"><?php echo $row[$recepe_counter]['time'];?></p>
                            <p><?php echo $row[$recepe_counter]['description'];?></p>
                        </div>
                    </div>
                    
                        <?php
                            $recepe_counter++;
                        } while($recepe_counter<$rows_count && $recepe_counter%5!=0 );
                    }
                    else
                    {
                        echo '<p style="font-size: x-large; font-weight: 900; text-align: center;">There is no recipe in this category.</p>';
                    }
                     ?>

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="pagination-area mt-70">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i=1;$i<=ceil($rows_count/5) ;$i++){
                                   ?>
                                <li class="page-item <?php if($page_num==$i) echo "active";?>"><a class="page-link" href="catagory-post.php?catid=<?php echo $catid;?>&&page_num=<?php echo $i ?>">0<?php echo $i ?></a></li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            


        </div>
    </div>
    <!-- ##### Catagory Post Area End ##### -->

    <?php include('include/footer.php')?>