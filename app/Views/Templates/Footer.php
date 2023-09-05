            <?php if ($this->app_exceptions && App\Models\User::isLogged() && App\Models\User::session()->isAdmin()) : ?>
                <div class="container">
                    <div class="alert alert-light post" role="alert">
                        <h4 class="alert-heading text-danger">Excepciones del Sistema</h4>
                        <ul>
                            <?php foreach ($this->app_exceptions as $e) : ?>
                                <li><?= $e ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            <?php endif ?>

            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1 col-xs-3 col-sm-2 logo "><a href="#"><img src="public/images/logo.png" alt=""></a></div>
                        <div class="col-lg-8 col-xs-9 col-sm-5 ">Copyrights 2021 YoungFAQ</div>
                        <div class="col-lg-3 col-xs-12 col-sm-5 sociconcent">
                            <ul class="socialicons">
                                <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
                                <li><a href="#"><i class="fa fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
         </div>

         <!-- CDN -->
         <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
         <!-- Custom -->
         <script type="text/javascript" src="public/js/main.js"></script>
    </body> 

</html>