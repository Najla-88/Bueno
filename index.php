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
<div class="hero-area">
    <!-- Hero Post Slides -->
    <div class="hero-post-slides owl-carousel">
        <?php 
        if($stm->rowCount()>0){
            foreach ($allRows as $row) {
            ?>
        <!-- Single Slide -->
        <div class="single-slide">
            <!-- Blog Thumbnail -->
            <div class="blog-thumbnail">
                <a href="#"><img class="cropped1" src="<?php echo $row['img']; ?>" alt=""></a>
            </div>

            <!-- Blog Content -->
            <div class="blog-content-bg">
                <div class="blog-content">
                    <a href="catagory-post.php?catid=<?php echo $row['cat_id'];?>" class="post-tag"><?php get_cat_by_id($row['cat_id']); ?></a>
                    <a href="receipe.php?recipeID=<?php echo $row['ID'];?>" class="post-title"><?php echo $row['name']; ?></a>
                    <p class="post-date"><?php echo $row['time']; ?></p>
                </div>
            </div>
        </div>
<?php } }?>        
    </div>
</div>
<!-- ##### Hero Area End ##### -->

<?php 
for($i=3;$i<5;$i++)
{
?>
<!-- ##### Big Posts Area Start ##### -->
<div class="big-posts-area mb-50 mt-5" >
    <div class="container">

        <!-- Single Big Post Area -->
        <div class="row align-items-center">

     <?php if($i%2!=0){?>
        <div class="col-12 col-md-6">
            <div class="big-post-thumbnail mb-50">
                <img src="<?php echo $allRows[$random_index[$i]]['img']; ?>" alt="">
            </div>
         </div>

       
        <div class="col-12 col-md-6">
            <div class="big-post-content text-center mb-50">
                <a href="catagory-post.php?catid=<?php echo $allRows[$random_index[$i]]['cat_id'];?>" class="post-tag"><?php get_cat_by_id($allRows[$random_index[$i]]['cat_id']); ?></a>
                <a href="receipe.php?recipeID=<?php echo $allRows[$random_index[$i]]['ID'];?>" class="post-title"><?php echo $allRows[$random_index[$i]]['name']; ?></a>
                <p class="post-date"><?php echo $allRows[$random_index[$i]]['time']; ?></p>

                <p><?php echo $allRows[$random_index[$i]]['description']; ?></p>
            </div>
        </div>
        <?php }
        
        else { ?>
            <div class="col-12 col-md-6">
                <div class="big-post-content text-center mb-50">
                    <a href="catagory-post.php?catid=<?php echo $allRows[$random_index[$i]]['cat_id'];?>" class="post-tag"><?php get_cat_by_id($allRows[$random_index[$i]]['cat_id']); ?></a>
                    <a href="receipe.php?recipeID=<?php echo $allRows[$random_index[$i]]['ID'];?>" class="post-title"><?php echo $allRows[$random_index[$i]]['name']; ?></a>
                    <p class="post-date"><?php echo $allRows[$random_index[$i]]['time']; ?></p>
                    <p><?php echo $allRows[$random_index[$i]]['description']; ?></p>
                </div>
            </div>


            <div class="col-12 col-md-6">
                <div class="big-post-thumbnail mb-50">
                    <img src="<?php echo $allRows[$random_index[$i]]['img']; ?>" alt="">
                </div>
             </div>
        <?php } ?>
       
        </div>
      
        
    </div>
</div>
<?php } ?>
<!-- ##### Big Posts Area End ##### -->


<!-- //////////////////////////////make single blog post linked to DB/////////////////// -->
              
<!-- ##### Posts Area End ##### -->
<div class="bueno-post-area mb-70">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Post Area -->
            <div class="col-12 col-lg-8 col-xl-9">
                <!-- Single Blog Post -->


        <?php
        for($i=0;$i<3;$i++)
        {
        ?>
                <div class="single-blog-post style-1 d-flex flex-wrap mb-30">
                    <!-- Blog Thumbnail -->
                    <div class="blog-thumbnail">
                        <img src="<?php echo $allRows[$random_index[$i]]['img']; ?>" alt="">
                    </div>
                    <!-- Blog Content -->
                    <div class="blog-content">
                        <a href="catagory-post.php?catid=<?php echo $allRows[$random_index[$i]]['cat_id'];?>" class="post-tag"><?php get_cat_by_id($allRows[$random_index[$i]]['cat_id']); ?></a>
                        <a href="receipe.php?recipeID=<?php echo $allRows[$random_index[$i]]['ID'];?>" class="post-title"><?php echo $allRows[$random_index[$i]]['name']; ?></a>
                        <p class="post-date"><?php echo $allRows[$random_index[$i]]['time']; ?></p>
                        <p style="font-weight: 100 !important;"><?php echo $allRows[$random_index[$i]]['description']; ?></p>
                    </div>
                </div>
    <?php } ?>

            </div>
        </div>
    </div>
</div>
<!-- ##### Posts Area End ##### -->

<?php include('include/footer.php')?>
