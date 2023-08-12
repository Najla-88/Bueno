<?php
session_start(); 
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['permission_id']==1){
   include('include/header.php');
?>
<div class="container-fluid">
            <div class="row ml-5">
              <div class="col-md-4 pl-5 ml-5">
                  <div class="card-body pl-5 ml-3">
                    <img src="<?php 
                    if(get_by_id('users', $user_id, 'img')!=null)
                          echo '../'.get_by_id('users', $user_id, 'img');
                    else 
                        echo "../img/profile/solidUser.svg";
                    ?>" class="rounded-circle " width="350" alt="picuture">
                  </div>
              </div>
              <div class="col-md-6 ml-5">
                <div class="card mb-3 content card_header">
                  <h1 class="m-3 pt-3"> Profile </h1>
                  <div class="card-body profile_card_body">
                    <div class="row">
                      <div class="col-md-3">
                         <h5> Full Name </h5>
                      </div>
                      <div class="col-md-9 text-secondary">
                         <?php echo get_by_id('users', $user_id, 'Name'); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-3">
                         <h5> Email </h5>
                      </div>
                      <div class="col-md-9 text-secondary">
                      <?php echo get_by_id('users', $user_id, 'email'); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                       <div class="col-md-3">
                         <h5> Birthdate </h5>
                       </div>
                       <div class="col-md-9 text-secondary">
                       <?php if(get_by_id('users', $user_id, 'birthdate')!="0000-00-00") echo get_by_id('users', $user_id, 'birthdate'); ?> 
                       </div>
                    </div>

                    <hr>
                    <div class="row">
                       <div class="col-md-3">
                         <h5> Permission </h5>
                       </div>
                       <div class="col-md-9 text-secondary">
                          <?php
                              //echo get_by_id('users', $user_id, 'permission_id');
                              $permession_user_id = get_by_id('users', $user_id, 'permission_id');
                              echo get_by_id('permissions', $permession_user_id, 'name');
                           ?>
                       </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

        </div>
      </div>

</div>
<?php include('include/footer.php');

} 
else {
  echo "<h2 style='text-align:center'>you have to <a href='../login.php'>login<a> first</h2>";
}
?>
