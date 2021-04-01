<?php $this->load->view('front/template/header')?>

    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7 fullscreen-md d-flex justify-content-center align-items-center overlay gradient gradient-purple-navy alpha-7 image-background cover" style="background-image:url(https://picsum.photos/1920/1200/?random&gravity=south)">
                <div class="content">
                    <h2 class="display-4 display-md-3 text-contrast mt-4 mt-md-0">Welcome to <span class="bold d-block">RCFI</span></h2>
                    <p class="lead text-contrast">Login to your account</p>
                    <hr class="mt-md-6 w-25">
                    <div class="d-flex flex-column">
                        <p class="small bold text-contrast">Or sign in with</p>
                        <nav class="nav mb-4"><a class="btn btn-rounded btn-outline-secondary brand-facebook mr-2" href="#"><i class="fab fa-facebook-f"></i></a> <a class="btn btn-rounded btn-outline-secondary brand-twitter mr-2" href="#"><i class="fab fa-twitter"></i></a> <a class="btn btn-rounded btn-outline-secondary brand-linkedin" href="#"><i class="fab fa-linkedin-in"></i></a></nav>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-4 mx-auto">
                <div class="login-form mt-5 mt-md-0"><img src="<?= base_url()?>public/assets/front/img/rcfi-logo.png" class="logo img-responsive mb-4 mb-md-6" alt="">
                    <h1 class="text-darker bold">Login</h1>
                    <p class="text-secondary mt-0 mb-4 mb-md-6">Don't have an account yet? <a href="<?= base_url()?>front/register" class="text-primary bold">Create it here</a></p>
                    <form class="cozy" action="srv/login.php" data-validate-on="submit" novalidate><label class="control-label bold small text-uppercase text-secondary">Username</label>
                        <div class="form-group has-icon"><input type="text" id="login_username" name="Login[username]" class="form-control form-control-rounded" placeholder="Your registered username" required> <i class="icon fas fa-user"></i></div><label class="control-label bold small text-uppercase text-secondary">Password</label>
                        <div class="form-group has-icon"><input type="password" id="login_password" name="Login[password]" class="form-control form-control-rounded" placeholder="Your password" required> <i class="icon fas fa-lock"></i></div>
                        <div class="form-group d-flex align-items-center justify-content-between"><a href="forgot.html" class="text-warning small">Forgot your password?</a>
                            <div class="ajax-button">
                                <div class="fas fa-check btn-status text-success success"></div>
                                <div class="fas fa-times btn-status text-danger failed"></div><button type="submit" class="btn btn-primary btn-rounded">Login <i class="fas fa-long-arrow-alt-right ml-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
       
<?php $this->load->view('front/template/footer.php');?>