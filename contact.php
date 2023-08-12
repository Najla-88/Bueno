<?php
session_start(); 
include('include/header.php');
?>


<!-- ##### Contact Area Start ##### -->
<section class="contact-area section-padding-100">
    <div class="container">
        <div class="row justify-content-center">
            <!--contact us area  -->
                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="contact-content mb-100">
                        <h4 class="mb-50">We love seeing your feedback</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tristique justo id elit bibendum pharetra non vitae lectus. Mauris libero felis, dapibus a ultrices sed, commodo vitae odio. Sed auctor tellus quis arcu tempus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac tincidunt nunc. Cras sed mollis erat.</p>
                        <br><br><br>

                        <!-- ##### Contact Area Start ##### -->
                        <div class="contact-area section-padding-0-80">
                            <div class="container">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="section-heading" style="text-align : left;">
                                            <h4>Contact Us</h4>
                                        </div>
                                    </div>
                                </div>
                                <!--input contect-->
                                <!--insert from contect us to ttable messge indataabase-->

                                <?php
                                    $name = $email =  $subject = $message= "";
                                    $input_error=array();

                                    if(isset($_POST['Add_message']))
                                    {
                                            if(empty($_POST['name'])){
                                                $input_error['nameerr']['empty']="Name is required";
                                            }
                                            else {
                                                    if(is_numeric($_POST['name']))
                                                    {
                                                        $input_error['nameerr']['num']="Name must not be numeric";
                                                    }
                                                    $name = test_input($_POST["name"]);
                                                    // check if userName only contains letters and whitespace
                                                    if (!preg_match("/^[a-zA-Z-_ ' ]*$/",$name)) {
                                                    $input_errors['nameerr']['alpa'] = "Only letters and white space allowed";
                                                    }
                                            }
                                            if(empty($_POST['email'])){
                                                    $input_error['email']="Email is required";
                                            }
                                            else {
                                                $email = test_input($_POST["email"]);
                                                // check if e-mail address is well-formed
                                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                $input_errors['emailErr']= "Invalid email format";
                                                }
                                            }
                                            if(empty($_POST['subject'])){
                                                    $input_error['subject']="Subject is required ";
                                            }
                                            else {
                                                $subject = test_input($_POST["subject"]);
                                            }

                                            if(empty($_POST['message'])){
                                                    $input_error['message']="Message is required ";
                                            }
                                            else {
                                                $message = test_input($_POST["message"]);
                                            }

                                            if(empty($input_error))
                                            {
                                                
                                                $sql ="INSERT INTO messages (name, email, subject, message)
                                                VALUES (?,?,?,?)";
                                                $stmt = $conn->prepare($sql);

                                                $stmt->execute(array($name,$email,$subject,$message));
                                                    
                                                if($stmt->rowCount())
                                                {
                                                    echo"<div class='alert alert-success'>message sent</div>";
                                                }
                                                else {
                                                    echo"<div class='alert alert-danger'>message Not sent</div>";

                                                }
                                            }
                                    }
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="contact-form-area">
                                            <form  method="post">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <span  style="color :red;"><?php
                                                        if(isset($input_error['nameerr']))
                                                        {
                                                            foreach($input_error['nameerr'] as $err)
                                                                echo $err;
                                                        }
                                                        ?></span> 
                                                        <input type="text" class="form-control" id="name"name="name" placeholder="Name" required>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <span  style="color :red;"><?php
                                                        if(isset($input_error['email']))
                                                        {
                                                            echo $input_error['email'];
                                                        }
                                                        ?></span> 
                                                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <span  style="color :red;"><?php
                                                        if(isset($input_error['subject']))
                                                        {
                                                            echo $input_error['subject'];
                                                        }
                                                        ?></span> 
                                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <span  style="color :red;"><?php
                                                        if(isset($input_error['message']))
                                                        {
                                                            echo $input_error['message'];
                                                        }
                                                        ?></span> 
                                                        <textarea name="message" class="form-control" id="message" name="message" cols="30" rows="10" placeholder="Message" required></textarea>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <button class=" bueno-btn mt-30" type="submit" name="Add_message">Send</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- cldse insert-->

                            </div>
                        </div>
                        <!-- ##### Contact Area End ##### -->


                    </div>
                </div>
            <!--contact us area  END -->

            <!-- Sidebar Area -->
                <div class="col-12 col-sm-9 col-md-6 col-lg-4 col-xl-3 ">
                    <div class="sidebar-area">

                        <!-- Single Widget Area -->
                        <div class="single-widget-area add-widget mb-30">
                            <img src="img/bg-img/add.png" alt="">
                        </div>

                        <!-- Single Widget Area -->
                        <div class="single-widget-area post-widget mb-30">
                             <?php for($i=5;$i<10;$i++){?>
                            <!-- Single Post Area -->
                            <div class="single-post-area d-flex">
                                <!-- Blog Thumbnail -->
                                <div class="blog-thumbnail">
                                    <img src="<?php echo $allRows[$random_index[$i]]['img']; ?>" alt="">
                                </div>
                                <!-- Blog Content -->
                                <div class="blog-content">
                                    <a href="receipe.php?recipeID=<?php echo $allRows[$random_index[$i]]['ID'];?>" class="post-title"><?php echo $allRows[$random_index[$i]]['name']; ?></a>
                                    <p ><?php echo $allRows[$random_index[$i]]['time']; ?></p>
                                </div>
                            </div>

                            <?php } ?>        
                        </div>
                    </div>
                </div>
            <!-- Sidebar Area End-->
                
        </div>
    </div>
</section>
<!-- ##### Contact Area End ##### -->

    <?php include('include/footer.php')?>
