<?php 
session_start(); 
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['permission_id']==1 ){
include('include/header.php');?>

<h2 class="greatting_msg">welcom <?php echo get_by_id('users', $user_id, 'Name');  ?></h2>
<?php include('include/footer.php');
} 
else {
  echo "<h2 style='text-align:center'>you have to <a href='../login.php'>login<a> first</h2>";
}
 ?>
