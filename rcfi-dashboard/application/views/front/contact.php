<?php $this->load->view('front/template/header')?>
<?php $this->load->view('front/template/navigation')?>

        <!-- ./Page header -->
        <header class="header business-header section gradient gradient-primary-light" >
            <div class="divider-shape">
                <!-- waves divider --> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" class="shape-waves" style="left: 0; transform: rotate3d(0,1,0,180deg);">
                    <path class="shape-fill shape-fill-contrast" d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z" /></svg></div>
            <div class="container pb-9" style="">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="regular display-4 text-contrast mb-4">Contact Us</h1>
                        <p class="lead text-contrast">Get in touch and let us know how we can help. Fill out the form and we’ll be in touch as soon as possible.</p>
                    </div>
                </div>
            </div>
        </header><!-- ./Contact Us -->
        <section class="section mt-7n mt-5">
            <div class="container bring-to-front pt-0">
                <div class="row align-items-center gap-y">
                    <div class="col-md-6">
                        <div class="shadow bg-contrast p-4 rounded">
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
                            <form action="<?php echo base_url('EmailNotif/receive_email') ?>" method="post" >
                                <div class="form-group">
                                    <label for="contact_email" class="bold mb-0">Full Name</label> 
                                    <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Full Name" value="<?php echo isset($full_name)? $full_name : '' ?>">
                                    <input type="hidden" name="type" value="contact">
                                </div>
                                <div class="form-group"><label for="contact_email" class="bold">Contact Number</label>
                                    <input type="text" id="contact" name="contact" class="form-control" placeholder="Contact number" value="<?php echo isset($contact)? $contact : '' ?>"> 
                                </div>
                                <div class="form-group">
                                    <label for="contact_email" class="bold mb-0">Email address</label> 
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Valid email" value="<?php echo isset($email)? $email : '' ?>"> 
                                </div>

                                <div class="form-group"><label for="contact_email" class="bold">Message</label>
                                    <textarea class="form-control" placeholder="Message"  name="message" id="message" cols="30" rows="3"><?php echo isset($message)? $message : '' ?></textarea>
                                </div>
                                <div class="form-group"><button id="contact-submit" data-loading-text="Sending..." name="submit" type="submit" class="btn btn-primary btn-rounded">Send Message</button></div>
                                <span class="text-danger"><?php echo form_error('full_name'); ?></span>
                                <span class="text-danger"><?php echo form_error('contact'); ?></span>
                                <span class="text-danger"><?php echo form_error('email'); ?></span>
                                <span class="text-danger"><?php echo form_error('message'); ?></span>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-5 ml-md-auto">
                        <div class="section-heading">
                            <p class="small bold badge badge-info">Let's do business</p>
                            <h2 class="great-vibes">The road to financial freedom.</h2>
                        </div>
                        <div class="media"><i class="fas fa-map-marker font-l text-primary mr-3"></i>
                            <div class="media-body">Parada ( Mega Center), Sta. Maria Bulacan <br> Poblacion Bocaue, Sta. Maria Bulacan</div>
                        </div>
                        <div class="media my-4"><i class="fas fa-phone font-l text-primary mr-3"></i>
                            <div class="media-body"><span class="d-block"><a href="tel:+1-123-456-7890">0905 967 7910</a></span></div>
                        </div>
                        <div class="media"><i class="fas fa-envelope font-l text-primary mr-3"></i>
                            <div class="media-body"><a href="mailto:rcfifoodsupplementtrading@gmail.com">rcfifoodsupplementtrading@gmail.com</a></div>
                        </div>
                        <hr class="my-4">
                        <nav class="nav justify-content-center justify-content-md-start">
                            <a target="_blank" href="https://www.facebook.com/rcfi21/" class="btn btn-circle btn-sm brand-facebook mr-3"><i class="fab fa-facebook"></i></a> 
                            <a target="_blank" href="#" class="btn btn-circle btn-sm brand-instagram mr-3"><i class="fab fa-instagram"></i></a>
                            <a target="_blank" href="https://twitter.com/FoodRcfi" class="btn btn-circle btn-sm brand-twitter mr-3"><i class="fab fa-twitter"></i></a> 
                            <a target="_blank" href="https://www.youtube.com/channel/UCLCxr5KhtozGktJQvi6e8Ww/" class="btn btn-circle btn-sm brand-youtube mr-3"><i class="fab fa-youtube"></i></a> 
                            <a target="_blank" href="https://www.linkedin.com/in/rcfi-food-supplement-trading-6713b61ab/" class="btn btn-circle btn-sm brand-linkedin mr-3"><i class="fab fa-linkedin-in"></i></a> 
                        </nav>
                    </div>
                </div>
            </div>
        </section><!-- ./Other contact channels -->

<?php $this->load->view('front/template/force-footer.php');?>   
<?php $this->load->view('front/template/pre-footer.php');?>
<?php $this->load->view('front/template/footer.php');?>