<?php $this->load->view('front/template/header')?>

  <div class="container-fluid">
      <div class="row align-items-center">
          <div class="col-md-6 col-lg-7 fullscreen-md d-flex justify-content-center align-items-center overlay gradient gradient-purple-navy alpha-7 image-background cover" style="background-image:url(https://picsum.photos/1920/1200/?random&gravity=south)">
              <div class="content">
                  <h2 class="display-4 display-md-3 text-contrast mt-4 mt-md-0">It's never too late <span class="bold d-block"> with RCFI</span></h2>
                  <p class="lead text-contrast">Your way to financial freedom.</p>
                  <hr class="mt-md-6 w-25">
                  <div class="d-flex flex-column">
                      <p class="small bold text-contrast">Show your support, by following our social media accounts.</p>
                      <nav class="nav mb-4">
                        <a class="btn btn-rounded btn-outline-secondary brand-facebook mr-2" target="_blank" href="https://www.facebook.com/rcfi21/"><i class="fab fa-facebook-f"></i></a> 
                        <a class="btn btn-rounded btn-outline-secondary brand-instagram mr-2" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-rounded btn-outline-secondary brand-twitter mr-2" target="_blank" href="https://twitter.com/FoodRcfi"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-rounded btn-outline-secondary brand-youtube mr-2" target="_blank" href="https://www.youtube.com/channel/UCLCxr5KhtozGktJQvi6e8Ww/"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-rounded btn-outline-secondary brand-linkedin" target="_blank" href="https://www.linkedin.com/in/rcfi-food-supplement-trading-6713b61ab/"><i class="fab fa-linkedin-in"></i></a>
                      </nav>
                  </div>
              </div>
          </div>
          <div class="col-md-5 col-lg-4 mx-auto">
              <div class="register-form mt-5 mt-md-0"><img src="<?= base_url()?>public/assets/front/img/rcfi-logo.png" class="logo img-responsive mb-4 mb-md-6" alt="">
                  <h1 class="text-darker bold">You are about to inquire for NutriRich Package</h1>
                  <div class="col-md-12">
                  <?php  
                  if($this->session->userdata('acctg_msg')){
                  ?>
                    <div class="alert alert-<?php echo $_SESSION['acctg_msg_type'] ?>" role="alert">
                      <?php echo $_SESSION['acctg_msg'] ?>
                    </div>
                  <?php
                  unset($_SESSION['acctg_msg']);	
                  unset($_SESSION['acctg_msg_type']);	
                  }
                  ?>
                  </div>
                  <form action="<?php echo base_url('EmailNotif/receive_email') ?>" method="post" >
                    <div class="form-group has-icon">
                        <input type="text" id="full_name" name="full_name" class="form-control form-control-rounded" placeholder="Full Name" value="<?php echo isset($full_name)? $full_name : '' ?>">
                        <i class="icon fas fa-user"></i> 
                    </div>
                    <div class="form-group has-icon">
                        <input type="text" id="contact" name="contact" class="form-control form-control-rounded" placeholder="Contact number" value="<?php echo isset($contact)? $contact : '' ?>"> 
                        <i class="icon fas fa-address-card"></i>
                    </div>
                    <div class="form-group has-icon">
                        <input type="text" id="email" name="email" class="form-control form-control-rounded" placeholder="Valid email" value="<?php echo isset($email)? $email : '' ?>"> 
                        <i class="icon fas fa-envelope"></i>
                    </div>
                    <div class="form-group has-icon">
                        <textarea class="form-control form-control-rounded" placeholder="Inquiry message"  name="message" id="message" cols="30" rows="3"><?php echo isset($message)? $message : '' ?></textarea>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between"><button type="submit" name="btnsubmit" class="btn btn-primary btn-rounded ml-auto">Submit <i class="fas fa-long-arrow-alt-right ml-2"></i></button></div>
                    <span class="text-danger"><?php echo form_error('full_name'); ?></span>
                    <span class="text-danger"><?php echo form_error('contact'); ?></span>
                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                    <span class="text-danger"><?php echo form_error('message'); ?></span>
                     
                  </form>
                  <div class="mt-5">
                      <p class="small text-secondary">Back to  <a href="<?= base_url()?>front/">website</a></p>
                  </div>
              </div>
          </div>
      </div>
  </div>
       
<?php $this->load->view('front/template/footer.php');?>