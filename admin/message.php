<?php
session_start();
if(isset($_SESSION['user_info'])&& $_SESSION['user_info']['permission_id']==1){
include('include/header.php');?>
<link rel="stylesheet" href="css/inbox.css">


      <?php
  if(isset($_GET['msgid'])&& in_table ('messages','id',$_GET['msgid']))
  {
        $id=$_GET['msgid'];

      $sql="select * from messages where id=?";
      $stm = $conn->prepare($sql);
      $stm->execute(array($id));
      $msg = $stm->fetch();
      
      if(isset($_POST['sendreply']))
      {
        if(empty($_POST['reply']))
        {
          echo "<div class='alert alert-danger' style='text-align:center'>reply didn't send</div>";
          $error = "message is empty";
        }
        else{
          $reply_message = test_input($_POST['reply']); 
          // mail($msg['email'],"replay for your message '".$msg['subject']."'", $reply_message."From:".get_by_id('users',$_SESSION['user_info']['id'],'email'));
          echo "<script>
                  alert('✔ reply sent');
                  window.open('inbox.php','_self');
              </script>";
          
        }
      }

      ?>

              <div class="container">
                <label> subject :</label>
                <p style="border: 1px solid #dadfe5;
                        border-bottom: 2px solid #dadfe5;
                        padding: 15px 30px;">
                        <?php echo $msg['subject']?>
                        
                      </p>

                <label> Message :</label>
                <p style="border: 1px solid #dadfe5;
                          border-bottom: 2px solid #dadfe5;
                          padding: 15px 30px;">
                          
                          <?php
                        $textarray = explode("\r\n", $msg['message']);
                        foreach ($textarray as $line) 
                        {
                          echo $line."<br>";
                        }?>
                </p>
                
                <label style="color: #a0a0a0"> from :</label>
                  <p class="pl-5" style=" font-family: serif; color: #a0a0a0; font-size: medium;">
                          <?php echo $msg['name']?><br>
                          <?php echo $msg['email']?><br>
                          <?php echo $msg['date']?><br>
                  </p>
                  
                <div class="">
                  <form method="post" class="mt-5">
                            <div class="">
                                <div class=" mb-1">
                                  <label> replay message :</label>
                                  <span style="color:red">  <?php if(isset($error)) echo $error; ?> </span>  
                                </div>
                                <div class="">
                                <textarea name="reply" cols="148" rows="3"></textarea>
                                <input class="btn btn-success mb-5" name="sendreply" type="submit" value="send">
                                <a href="inbox.php" class="btn btn-danger mb-5" style="color:white">Cancel</a>
                              </div>
                            </div>
                        </form>
                    </div>
                    
              </div>




<?php 
include('include/footer.php');
      }
      else 
          echo '<p class="pt-5 mt-5 pb-5 mb-5 "
                   style="font-size: x-large;
                          color: #7a7a7a;
                          font-weight: 900;
                          text-align: center;
                          font-family: "Montserrat", sans-serif;
                          ">There is no Message !!! </p>';
      
} 
else {
  echo "<h2 style='text-align:center'>you have to <a href='../login.php'>login<a> first</h2>";
}
 ?>   