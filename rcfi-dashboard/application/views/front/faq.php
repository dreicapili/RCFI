<?php $this->load->view('front/template/header')?>
<?php $this->load->view('front/template/navigation')?>

        <!-- ./Page header -->
        <header class="page header text-contrast overlay alpha-8 image-background cover gradient gradient-purple-blue" style="background-image: url('img/bg/waves.jpg')">
            <div class="divider-shape">
                <!-- waves divider --> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" class="shape-waves" style="left: 0; transform: rotate3d(0,1,0,180deg);">
                    <path class="shape-fill shape-fill-light" d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z" /></svg></div>
            <div class="container" style="">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="regular display-4 text-contrast mb-4">FAQs</h1>
                        <p class="lead text-contrast">Here are the answers to some of the most common questions we hear from our appreciated customers.</p>
                    </div>
                </div>
            </div>
        </header><!-- ./FAQs -->
        <section class="section">
            <div class="container">
                <div class="row gap-y">
                    <div class="col-lg-8 b-md-l order-lg-2">
                        <h3 class="light">Common Questions</h3>
                        <hr class="mb-4">
                        <div class="accordion accordion-clean" id="faqs-accordion">
                            <div class="card mb-3">
                                <div class="card-header"><a href="#" class="card-title btn" data-toggle="collapse" data-target="#v1-q1"><i class="fas fa-angle-down angle"></i>What does the package include?</a></div>
                                <div id="v1-q1" class="collapse" data-parent="#faqs-accordion">
                                    <div class="card-body">When you buy Dashcore, you get all you see in the demo but the images. We include SASS files for styling, complete JS files with comments, all HTML variations. Besides we include all mobile PSD mockups.</div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header"><a href="#" class="card-title btn" data-toggle="collapse" data-target="#v1-q2"><i class="fas fa-angle-down angle"></i>What is the typical response time for a support question?</a></div>
                                <div id="v1-q2" class="collapse" data-parent="#faqs-accordion">
                                    <div class="card-body">Since you report us a support question we try to make our best to find out what is going on, depending on the case it could take more or les time, however a standard time could be minutes or hours.</div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header"><a href="#" class="card-title btn" data-toggle="collapse" data-target="#v1-q3"><i class="fas fa-angle-down angle"></i>What do I need to know to customize this template?</a></div>
                                <div id="v1-q3" class="collapse" data-parent="#faqs-accordion">
                                    <div class="card-body">Our documentation give you all you need to customize your copy. However you will need some basic web design knowledge (HTML, Javascript and CSS)</div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header"><a href="#" class="card-title btn" data-toggle="collapse" data-target="#v1-q4"><i class="fas fa-angle-down angle"></i>Can I suggest a new feature?</a></div>
                                <div id="v1-q4" class="collapse" data-parent="#faqs-accordion">
                                    <div class="card-body">Definitely <span class="bold">Yes</span>, you can contact us to let us know your needs. If your suggestion represents any value to both we can include it as a part of the theme or you can request a custom build by an extra cost. Please note it could take some time in order for the feature to be implemented.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="bold small text-uppercase mb-3">search</h5>
                        <form class="form search-box">
                            <div class="input-group"><input type="email" name="Search[q]" class="form-control rounded-circle-left shadow-none" placeholder="Search form..." required>
                                <div class="input-group-append"><button class="btn btn-rounded btn-contrast border-input border-left-0" type="submit" data-loading-text="Searching ..."><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                        <h4 class="bold small text-uppercase mt-4 mb-3">categories</h4>
                        <nav class="nav flex-column font-sm"><a class="pl-0 nav-item nav-link bold active" href="faqs.html">Common Questions</a> <a class="pl-0 nav-item nav-link" href="faqs.html">Getting Started</a> <a class="pl-0 nav-item nav-link" href="faqs.html">My Account</a> <a class="pl-0 nav-item nav-link" href="faqs.html">Integrations</a> <a class="pl-0 nav-item nav-link" href="faqs.html">Licencing</a></nav>
                    </div>
                </div>
            </div>
        </section><!-- ./FAQs - Other channels -->
       
<?php $this->load->view('front/template/force-footer.php');?>   
<?php $this->load->view('front/template/pre-footer.php');?>
<?php $this->load->view('front/template/footer.php');?>