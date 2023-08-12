<?php
session_start(); 
include('include/header.php');?>
<link rel="stylesheet" href="css/userProfile_styles.css">
<div class="container">
            <div class="row">
              <div class="col-md-4 mt-1">
                  <div class="card-body">
                    <img 
                    src="<?php 
                        if(get_by_id('users', $user_id, 'img')!=null)
                              echo get_by_id('users', $user_id, 'img');
                        else 
                            echo "img/profile/solidUser.svg";
                        ?>" 
                    class="rounded-circle profile_img" width="350" alt="picuture">
                  </div>
              </div>
              <div class="col-md-8 mt-1">
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
                  </div>
                </div>
              </div>
            </div>

        </div>
      </div>

</div>
<?php include('include/footer.php')?>