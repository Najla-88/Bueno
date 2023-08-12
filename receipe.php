<?php
session_start(); 
include('include/header.php');

if(isset($_GET['recipeID']) && in_table ('recipe','ID',$_GET['recipeID']))
{
    $recid = $_GET['recipeID'];
    $sql = "SELECT * FROM recipe where ID=:recid";
    $stm = $conn->prepare($sql);
    $stm -> execute(array("recid"=>$recid));
    $rec = $stm->fetch();

?>
  <!-- ##### Post Details Area Start ##### -->
    <section class="post-news-area section-padding-100-0 mb-70">
        <div class="container">
            <div class="row justify-content-center">

                <!-- Post Details Content Area -->
                <div class="col-12 col-lg-7 col-xl-7">
                    <div class="post-details-content mb-100">
                        <div class="blog-thumbnail mb-50">
                            <img src="<?php echo $rec['img'];?>" alt="">
                        </div>
                        <div class="blog-content">
                            <a href="catagory-post.php?catid=<?php echo $rec['cat_id'];?>" class="post-tag"><?php echo get_cat_by_id($rec['cat_id']);?></a>
                            <h4 class="post-title"><?php echo $rec['name'];?></h4>
                            <div class="post-meta mb-50">
                                <p href="#" class="post-date"><?php echo $rec['time'];?></p>
                            </div>
                            <!-- if find double newline seperate it to new step -->
                           <?php $textarray = explode("\r\n\r\n", $rec['text']);
                           $num = 1;
                                foreach ($textarray as $step) 
                                {
                           ?>
                                <h5 class="mb-30">Step <?php echo $num++ ?></h5>
                                <p class="mb-30"><?php echo $step;?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4 col-xl-4 justify-content-center">
                    <!-- Ingredients -->
                    <div class="ingredients">
                        <h5>Ingredients</h5>
                        <?php $ingredientsArray = explode("\r\n\r\n", $rec['ingredients']);
                            foreach ($ingredientsArray as $ing) 
                            { ?>
                            <!-- Custom Checkbox -->
                            <div class="pt-4 pb-2" style="border-bottom: 2px solid #d6e1e4;">
                                <label style="color: #8b8b8b;"><?php echo $ing;?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    
    </section>
    <!-- ##### Post Details Area End ##### -->

    <?php
    }
    else 
        echo '<p class="pt-5 mt-5 pb-5 mb-5 " style="font-size: x-large; font-weight: 900; text-align: center;">There is no recipe !!! </p>';
     
    include('include/footer.php')?>