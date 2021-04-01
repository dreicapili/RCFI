<?php $this->load->view('front/template/header')?>
<?php $this->load->view('front/template/navigation')?>

 <!-- ./Page header -->
 <header class="header business-header section gradient gradient-primary-light" >
            <div class="divider-shape">
                <!-- waves divider --> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" class="shape-waves" style="left: 0; transform: rotate3d(0,1,0,180deg);">
                    <path class="shape-fill shape-fill-contrast" d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z" /></svg></div>
            <div class="container" style="">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="regular display-4 text-contrast mb-4">Gallery</h1>
                        <p class="lead text-contrast">RCFI is not only providing the best lives, but RCFI also creates the best memories.</p>
                    </div>
                </div>
            </div>
        </header><!-- ./Overview - Floating boxes -->



        <section class="section overview mp-2">
            <div class="container" id="history">
                <div class="row align-items-center gap-y gap-x">
                  <div class="row gap-y gap-y" >
                      <div class="col-md-4">
                          <img class="d-block ml-auto img-responsive" style="height:500px;" src="<?= base_url()?>public/assets/front/img/promos/1.jpg" alt="">
                      </div>
                      <div class="col-md-4">
                          <img class="d-block ml-auto img-responsive" style="height:500px;" src="<?= base_url()?>public/assets/front/img/promos/2.jpg" alt="">
                      </div>
                      <div class="col-md-4">
                          <img class="d-block ml-auto img-responsive" style="height:500px;width:100%" src="<?= base_url()?>public/assets/front/img/promos/3.jpg" alt="">
                      </div>
                      <div class="col-md-12">
                          <img class="d-block ml-auto img-responsive" src="<?= base_url()?>public/assets/front/img/promos/4.jpg" alt="">
                      </div>
                      <div class="col-md-6">
                          <img class="d-block ml-auto img-responsive" src="<?= base_url()?>public/assets/front/img/promos/mio.jpg" alt="">
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                              <img class="d-block ml-auto img-responsive"  style="height:460px;width:100%" src="<?= base_url()?>public/assets/front/img/gallery/kape-mayaman.png" alt="">
                            </div>
                            <div class="col-md-12">
                                <img class="d-block ml-auto img-responsive"  style="height:455px;width:100%" src="<?= base_url()?>public/assets/front/img/gallery/kape-mayaman-coffe-mix.png" alt="">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                          <img class="d-block ml-auto img-responsive" style="width:100%" src="<?= base_url()?>public/assets/front/img/gallery/nutri-rich.jpg" alt="">
                      </div>
                    </div>
                </div>
            </div>
        </section><!-- ./Video -->

<?php $this->load->view('front/template/force-footer.php');?>
<?php $this->load->view('front/template/pre-footer.php');?>
<?php $this->load->view('front/template/footer.php');?>