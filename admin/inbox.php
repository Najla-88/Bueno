<?php
session_start();
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['permission_id']==1){
include('include/header.php');?>

<link rel="stylesheet" href="css/inbox_style.css">
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>

<?php 
$sql = "select * from messages  ORDER BY id DESC";
$stm = $conn->prepare($sql);
$stm->execute();
$rows_count = $stm->rowCount();
$rows = $stm->fetchAll();

    $first_row=1;
    if(isset($_GET['first_row']))
    {
        $first_row =$_GET['first_row'];
    }
?>
<?php
        $msg_counter = $first_row-1;
        $last_row = $first_row+4;
        if($rows_count>0)
        { ?>
    <div class="mail-box container">
        <div class="inbox-body">
            <ul class="unstyled inbox-pagination">
                <li class=" mr-4 pt-1"><span><?php echo $first_row;?>-<?php echo ($last_row-$rows_count<0?$last_row:$rows_count) ?> of <?php echo $rows_count;?></span></li>
                <li>
                    <a class="np-btn" href="<?php if($first_row!=1){ ?> inbox.php?first_row=<?php echo $first_row-5; }?>"><i class="fa fa-angle-left  pagination-left"></i></a>
                </li>
                <li>
                    <a class="np-btn" href="<?php if($last_row!=$rows_count){ ?> inbox.php?first_row=<?php echo $first_row+5; }?>"><i class="fa fa-angle-right pagination-right"></i></a>
                </li>
            </ul>
        </div>

    <?php do
            {
            ?>
                <table class="table table-inbox table-hover">
                <tbody>
                    <tr class="clickable-row" data-href="message.php?msgid=<?php echo $rows[$msg_counter]['id'] ?>"> <!--unread-->
                        <td class="view-message"><?php echo $rows[$msg_counter]['name']; ?></td>
                        <td class="view-message"><?php echo $rows[$msg_counter]['subject']; ?></td>
                        <td class="view-message text-right"><?php echo $rows[$msg_counter]['date']; ?></td>
                    </tr>
                </tbody>
                </table>
                <?php
                $msg_counter++;
            } while($msg_counter<$rows_count && $msg_counter%5!=0 );
        }
        else
        {
            echo '<p style="font-size: x-large; font-weight: 900; text-align: center;">There is no recipe in this category.</p>';
        }
        ?>
            
        </div>
<?php include('include/footer.php');
?>
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>
<?php
} 
else {
  echo "<h2 style='text-align:center'>you have to <a href='../login.php'>login<a> first</h2>";
}
 ?>            