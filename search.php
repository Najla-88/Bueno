<?php
session_start(); 
include('include/header.php'); ?>

<style>
    .cropped1 {
    width: 420.330px; /* width of container */
    height: 415.068px; /* height of container */
}
</style>
<!-- ##### Hero Area Start ##### -->


        <?php
        if(isset($_GET['search_submit'])){
           $search_word = test_input($_GET['search_word']) ;
           
            $sql_recipe = "SELECT * FROM recipe WHERE name LIKE '%$search_word%' OR description LIKE '%$search_word%' ORDER BY ID DESC";
            $stm_recipe = $conn -> prepare($sql_recipe);
            $stm_recipe->execute();


            
           $sql_category = "SELECT * FROM categories WHERE name LIKE '%$search_word%' ORDER BY ID DESC";
           $stm_category = $conn -> prepare($sql_category);
           $stm_category->execute();


           if(empty($search_word)){
               echo '<button class=" btn mt-30 ">No words searched!</button>';
           }

           else if($stm_recipe->rowCount() == 0 && $stm_category->rowCount() == 0){
               echo '<button class=" btn mt-30 ">No result</button>';
           }
          
           else{

            if($stm_category->rowCount()){
                echo "<div class='alert alert-success' style='text-align:center; margin-top:5rem; margin-bottom:0; font-size:1.5rem;'> Categories </div>";

                $catRows = $stm_category->fetchAll();
                
                foreach($catRows as $row_category){
        ?>

        <div class="post-catagory section-padding-100">
            <form  method="get" >
                <div class="container">
                    <div class="row">
                        
                    <!-- Single Post Catagory -->
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-post-catagory mb-30">
                                <img src="<?php echo $row_category['img']; ?>" alt="">
                                <!-- Content -->
                                <div class="catagory-content-bg">
                                    <div class="catagory-content">
                                        <p class="post-tag">The Best</p>
                                        <a href="catagory-post.php?catid=<?php echo $row_category['id'];?>" class="post-title"><?php echo $row_category['name']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                </div>
            </form>
        </div>
        <?php }} 
            if($stm->rowCount()){
                echo "<div class='alert alert-success' style='text-align:center; margin-top:5rem; margin-bottom:2rem; font-size:1.5rem;'> Recipes </div>";

                $recipeRows = $stm_recipe->fetchAll();
                foreach($recipeRows as $row_recipe){
        
        ?>

        <div class="bueno-post-area mb-70">
            <div class="container">
                <div class="row justify-content-center">
                    <!-- Post Area -->
                    <div class="col-12 col-lg-8 col-xl-9">
                        <!-- Single Blog Post -->

                        <div class="single-blog-post style-1 d-flex flex-wrap mb-30">
                            <!-- Blog Thumbnail -->
                            <div class="blog-thumbnail">
                                <img src="<?php echo $row_recipe['img']; ?>" alt="">
                            </div>
                            <!-- Blog Content -->
                            <div class="blog-content">
                                <a href="catagory-post.php?catid=<?php echo $row_recipe['cat_id'];?>" class="post-tag"><?php get_cat_by_id($row_recipe['cat_id']); ?></a>
                                <a href="receipe.php?recipeID=<?php echo $row_recipe['ID'];?>" class="post-title"><?php echo $row_recipe['name']; ?></a>
                                <p class="post-date"><?php echo $row_recipe['time']; ?></p>
                                <p style="font-weight: 100 !important;"><?php echo $row_recipe['description']; ?></p>
                            </div>

                    </div>
                </div>
            </div>
        </div>
 
        <?php }} ?>
        <?php }} ?>

