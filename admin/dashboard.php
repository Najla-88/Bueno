<?php 
session_start();
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['permission_id']==1 ){
  include('include/header.php');
?>
<style>
  .card_detail_p{
    font-weight: initial;
  }
</style>
<!--controle cards -->
  <div class="card-group justify-content-center " style="text-align:center;">

    <div class="card m-5 cards_radius bg-cards cards_radius" style="max-width: 18rem;">
      <a href="users_table.php">
        <h5 class="card-header cards_head_radius">Users</h5>
        <div class="card-body">
          <p class="card-text"><b><?php echo fetch_table_counts('users') ?></b></p>
          <p class="card_detail_p">add new user or show more details</p>
        </div>
      </a>
    </div>
    
    <div class="card m-5 cards_radius bg-cards cards_radius " style="max-width: 18rem;">
      <a href="categories_table.php">
        <h5 class="card-header cards_head_radius">Categories</h5>
        <div class="card-body">
            <p class="card-text"><b><?php echo fetch_table_counts('categories') ?></b></p>
            <p class="card_detail_p">add new category  or show more details</p>
        </div>
      </a>
    </div>

    <div class="card m-5 cards_radius bg-cards cards_radius" style="max-width: 18rem;">
      <a href="recepies_table.php">
        <h5 class="card-header cards_head_radius">Recepies</h5>
        <div class="card-body">
          <p class="card-text"><b><?php echo fetch_table_counts('recipe') ?></b></p>
          <p class="card_detail_p">add new recipe or show more details</p>
        </div>
      </a>
    </div>
  </div>

<?php include('include/footer.php') ;
} 
else {
  echo "<h2 style='text-align:center'>you have to <a href='../login.php'>login<a> first</h2>";
}
?>
