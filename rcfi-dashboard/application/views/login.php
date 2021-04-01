<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Courage Faith Ispire Marketing</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?= base_url()?>public/assets/img/courage-logo.jpg" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?= base_url()?>/public/assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?= base_url()?>/public/assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?= base_url()?>/public/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url()?>/public/assets/css/atlantis.min.css">
	<link rel="stylesheet" href="<?= base_url()?>/public/assets/css/jrey.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
</head>
<body data-background-color="dark">
	<div class="">
	
		<div class="">

            
       
            <div class="col-md-3 ml-auto mr-auto m-top-50">
                <img src="<?= base_url()?>public/assets/img/rcfi-logo.png" class="w-full my-3 center" alt="">

                <?php
                if($this->session->flashdata('error')){

                    echo '<div class="alert alert-danger" role="alert">';
                    echo $this->session->flashdata('error');
                    echo '</div>';
                }
                ?>

                <div class="card">
                    <div class="card-header text-center">
                        <div class="card-title" style="text-transform:uppercase">RCFI MARKETING</div>
                        <small id="emailHelp2" class="form-text text-muted">Login your account</small>
                    </div>
                    <div class="card-body pb-0">

                        <form method="POST" action="<?= base_url()?>login/login">

                        <div class="form-group">
                            <!-- <label for="email2">Enter your username</label> -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <!-- <label for="email2">Enter your password</label> -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-round btn-border float-right my-3"><i class="fa fa-check"></i>  LOGIN</button>
                        <div class="card-action mb-3"></div>
                    
                    </div>
                </div>

                <div class=" text-center">
                       
                    </div>

        
               
            </div>
      
        

		<!-- End Custom template -->
	</div>
	<!--   Core JS Files   -->
	<script src="<?= base_url()?>/public/assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="<?= base_url()?>/public/assets/js/core/popper.min.js"></script>
	<script src="<?= base_url()?>/public/assets/js/core/bootstrap.min.js"></script>


</body>
</html>