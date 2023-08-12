
    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-5">
                    
                    </div>
                    <div class="col-12 col-sm-7">
                    <!-- Footer Nav -->
                    <div class="footer-nav">
                        <ul>
                            <?php $activePage = basename($_SERVER['PHP_SELF'],'.php'); ?>
                            <li class="<?= ($activePage == 'index') ? 'active':''; ?>"><a href="index.php">Home</a></li>
                            <li class="<?= ($activePage == 'catagory') ? 'active':''; ?>"><a href="catagory.php">Catagories</a></li>
                            <li class="<?= ($activePage == 'contact') ? 'active':''; ?>"><a href="contact.php">Contact</a></li>
                            <li class="<?= ($activePage == 'about') ? 'active':''; ?>"><a href="about.php">About Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area Start ##### -->
    
    <!-- ##### All Javascript Script ##### -->

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/javascript.min.js"></script>
    
    <!-- jQuery-2.2.4 js -->
    <script src="../js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="../js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="../js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="../js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="../js/active.js"></script>
    

</body>

</html>