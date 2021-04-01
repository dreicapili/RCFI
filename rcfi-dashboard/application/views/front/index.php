<?php $this->load->view('front/template/header')?>
<?php $this->load->view('front/template/navigation')?>

        <!-- Integration Heading -->
        <header class="header business-header section gradient gradient-primary-light">
            <div class="container pb-8">
                <div class="row">
                    <div class="col-md-10 mx-auto text-center">
                        <h1 class="mt-3 text-contrast">
                        <span class="display-4 display-md-2 bold">
                        <span class="text-danger">R</span>ich 
                        <span class="text-danger">C</span>ourage 
                        <span class="text-danger">F</span>aith
                        <span class="text-danger">I</span>nspire 
                        <span class="text-warning">Trading</span></span>
                        <br><span class="great-vibes">The road to financial freedom</span>
                        </h1>
                        <p class="lead text-contrast my-5 op-8">The best way to start up your day is to take a step closer to a healthy lifestyle. NutriRich Gold is the juice that do good, feel good to be good.</p>
                        <!-- <nav class="nav justify-content-center"><a href="#!" class="btn btn-success btn-rounded px-4 mr-3">Get Started</a> <a href="#!" class="btn btn-success btn-rounded px-4">Sign up for Free</a></nav> -->
                        <!-- <p class="handwritten highlight font-md text-white">Play the video</p><a href="https://www.youtube.com/watch?v=00z-RMCswFI" class="modal-popup mfp-iframe btn btn-circle btn-lg btn-primary" data-effect="mfp-fade"><i data-feather="play" width="36" height="36" stroke-width="1" class="ml-2"></i></a> -->
                    </div>
                </div>
            </div>
        </header>
        <div class="position-relative">
            <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-contrast"><svg viewBox="0 0 2880 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
                </svg>
            </div>
        </div><!-- ./Partners -->
        <section class="partners mt-n5 mb-5">
            <div class="container py-0">
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <div class="swiper-container" data-sw-show-items="5" data-sw-space-between="30" data-sw-autoplay="2500">
                            <div class="swiper-wrapper align-items-center">
                                <div class="swiper-slide"><img src="<?= base_url()?>public/assets/front/img/brands/nutririch.jpg" class="img-responsive" alt="" style="max-height: 60px"></div>
                                <div class="swiper-slide"><img src="<?= base_url()?>public/assets/front/img/brands/kapemalaman.jpg" class="img-responsive" alt="" style="max-height: 60px"></div>
                                <div class="swiper-slide"><img src="<?= base_url()?>public/assets/front/img/brands/chaze.jpg" class="img-responsive" alt="" style="max-height: 60px"></div>
                                <div class="swiper-slide"><img src="<?= base_url()?>public/assets/front/img/brands/malungay.jpg" class="img-responsive" alt="" style="max-height: 60px"></div>
                                <div class="swiper-slide"><img src="<?= base_url()?>public/assets/front/img/brands/zack.jpg" class="img-responsive" alt="" style="max-height: 60px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="features" class="section bg-contrast  top-left mt-5" align="center">
            <div class="container">
                <div class="section-heading mb-6 text-center">
                    <h5 class="text-primary bold small text-uppercase">Brought to you by RCFI Trading</h5>
                    <h2>Must watch, A Life Changing Video</h2>
                </div>
                <iframe width="80%" height="555"
                src="https://www.youtube.com/embed/00z-RMCswFI"
                frameborder="0"  allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>
            </div>
        </section><!-- Features -->

        <section id="features" class="section bg-contrast  top-left mt-5">
            <div class="container">
                <div class="section-heading mb-6 text-center">
                    <h5 class="text-primary bold small text-uppercase">Pilipino's start appreciating RCFI</h5>
                    <h2 >Healthy Products by RCFI</h2>
                </div>
                <?php $this->load->view('front/template/product-collage.php');?>
            </div>
        </section><!-- Features -->

        <section id="features" class="section how-it-works">
            <div class="container">
                <div class="section-heading text-center">
                    <h2 >How the RCFI Trading Works?</h2>
                    <p class="lead text-secondary">RCFI is life-changing, Be one of us by following the process 3 steps below. Invest today, to become someday.</p>
                </div>
                <div class="row gap-y text-center text-md-left">
                    <div class="col-md-4 py-4 text-center">
                        <div class="shapes-figure shapes-container">
                            <div class="shape shape-circle center-x"></div>
                        </div>
                        <figure class="mockup mb-4"><img src="<?= base_url()?>public/assets/front/img/integration/steps/plan.svg" class="mb-3 image-responsive"></figure>
                        <h5 class="bold">
                        <span class="text-success">Nutri</span>
                        <span class="text-primary">R</span><span class="text-danger">I</span><span class="text-primary">C</span><span class="text-danger">H</span> Package</h5>
                        <p class="text-muted">By availing the package, you can now start do the business.</p>
                    </div>
                    <div class="col-md-4 py-4 text-center">
                        <div class="shapes-figure shapes-container">
                            <div class="shape shape-circle center-x"></div>
                        </div>
                        <figure class="mockup mb-4"><img src="<?= base_url()?>public/assets/front/img/integration/steps/payment.svg" class="mb-3 image-responsive"></figure>
                        <h5 class="bold">Payment method</h5>
                        <p class="text-muted">You can send payment via bank transfer, express padala or you can direct at our office.</p>
                    </div>
                    <div class="col-md-4 py-4 text-center">
                        <div class="shapes-figure shapes-container">
                            <div class="shape shape-circle center-x"></div>
                        </div>
                        <figure class="mockup mb-4"><img src="<?= base_url()?>public/assets/front/img/integration/steps/work.svg" class="mb-3 image-responsive"></figure>
                        <h5 class="bold">Growth and Development</h5>
                        <p class="text-muted">RCFI Tradings Offers you, free trainings and seminars that will surely help you grow your business.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section counters gradient gradient-primary-dark text-contrast shadow-lg mb-5">
            <div class="container pb-9">
                <div class="section-heading text-center">
                    <h2 class="text-contrast">How RCFI Trading Change Lives?</h2>
                    <p>Today is the day that turns your life around.</p>
                </div>
                <!-- <div class="row">
                    <div class="col-xs-4 col-md-3 text-center"><i data-feather="box" width="36" height="36"></i>
                        <p class="counter bold font-md mt-0">1,000,880</p>
                        <p class="m-0">Sponsors</p>
                    </div>
                    <div class="col-xs-4 col-md-3 text-center"><i data-feather="download-cloud" width="36" height="36"></i>
                        <p class="counter bold font-md mt-0">980,500</p>
                        <p class="m-0">Business Partners</p>
                    </div>
                    <div class="col-xs-4 col-md-3 text-center"><i data-feather="anchor" width="36" height="36"></i>
                        <p class="counter bold font-md mt-0">99,400,900</p>
                        <p class="m-0">Awards</p>
                    </div>
                    <div class="col-xs-4 col-md-3 text-center"><i data-feather="award" width="36" height="36"></i>
                        <p class="counter bold font-md mt-0">654</p>
                        <p class="m-0">Charity</p>
                    </div>
                </div> -->
            </div>
        </section><!-- Features -->
        <section class="section mt-n6" id="features" style="z-index:13">
            <div class="container pt-0">
                <div class="bg-contrast shadow rounded p-5">
                    <div class="row gap-y">
                        <div class="col-md-4">
                            <div class="rounded gradient gradient-primary-light icon-xl shadow d-flex align-items-center justify-content-center mr-3"><i data-feather="pen-tool" width="36" height="36" class="stroke-contrast"></i></div>
                            <h4 class="semi-bold mt-4 text-capitalize">Wheeler's Club</h4>
                            <hr class="w-25 bw-2 border-alternate mt-3 mb-4">
                            <p class="regular text-muted">Be one of our wheelers club, and live your dreams.</p>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded gradient gradient-primary-light icon-xl shadow d-flex align-items-center justify-content-center mr-3"><i data-feather="zap" width="36" height="36" class="stroke-contrast"></i></div>
                            <h4 class="semi-bold mt-4 text-capitalize">Powerful Team</h4>
                            <hr class="w-25 bw-2 border-alternate mt-3 mb-4">
                            <p class="regular text-muted">Be guided by mentors and team leaders.</p>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded gradient gradient-primary-light icon-xl shadow d-flex align-items-center justify-content-center mr-3"><i data-feather="star" width="36" height="36" class="stroke-contrast"></i></div>
                            <h4 class="semi-bold mt-4 text-capitalize">Discover the power</h4>
                            <hr class="w-25 bw-2 border-alternate mt-3 mb-4">
                            <p class="regular text-muted">The key to success is in your hand.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- See why people love ShasCore -->

        <?php $this->load->view('front/template/testimonial.php');?>

        <section class="bg-light edge top-left">
            <div class="container bring-to-front pb-0 pt-3">
                <div class="section-heading">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8 text-center">
                            <h2 >Life Changing Package Plan.</h2>
                            <p class="lead text-muted">It's a win-win situation both health and wealth benefits.</p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center no-gutters">
                    <div class="col-md-6" style="z-index: 1">
                        <div class="card border-0 rounded-lg shadow-lg mb-4 mb-md-0" data-aos="fade-up">
                            <div class="card-body py-4">
                                <div class="row">
                                    <div class="col-xl-9 mx-auto">
                                        <div class="pricing text-center mb-5">
                                            <h5 class="bold text-uppercase text-primary">Nutri Rich Package</h5>
                                            <hr class="my-4">
                                            <p>The best way to start up your day is to take a step closer to a healthy lifestyle. NutriRich Gold is the juice that do good, feel good to be good.</p>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li>
                                                <div class="media align-items-center mb-3">
                                                    <div class="icon-md bg-success p-2 rounded-circle center-flex mr-3"><i data-feather="box" class="stroke-contrast"></i></div>
                                                    <div class="media-body">Purchase 10 bottles</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="media align-items-center mb-3">
                                                    <div class="icon-md bg-success p-2 rounded-circle center-flex mr-3"><i data-feather="airplay" class="stroke-contrast"></i></div>
                                                    <div class="media-body">And you will get 5 Bottles for free</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="media align-items-center mb-3">
                                                    <div class="icon-md bg-success p-2 rounded-circle center-flex mr-3"><i data-feather="lock" class="stroke-contrast"></i></div>
                                                    <div class="media-body">Plus you are now automatically a member of RCFI Trading</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><a href="<?= base_url()?>front/inquire" class="btn btn-info btn-lg btn-block rounded-top-0 rounded-bottom py-4">Inquire Now <i data-feather="arrow-right" class="ml-3"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 ml-md-n3">
                        <div class="card border-0 rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-body py-4">
                                <div class="row">
                                    <div class="col-xl-10 mx-auto">
                                        <div class="text-center">
                                            <h5 class="bold text-uppercase">Benefits</h5>
                                            <hr class="my-4">
                                            <p class="lead bold">How RCFI Helps People</p>
                                            <div class="row no-gutters">
                                                <div class="col-6 border-right">
                                                    <div class="text-center p-3"><i data-feather="dollar-sign" width="32" height="32" class="stroke-primary"></i>
                                                        <p class="mb-0">Earn Big</p>
                                                    </div>
                                                </div>
                                                <div class="col-6 border-">
                                                    <div class="text-center p-3"><i data-feather="bell" width="32" height="32" class="stroke-primary"></i>
                                                        <p class="mb-0">Tranings & Seminars</p>
                                                    </div>
                                                </div>
                                                <div class="col-6 border-right border-top">
                                                    <div class="text-center p-3"><i data-feather="activity" width="32" height="32" class="stroke-primary"></i>
                                                        <p class="mb-0">Ecommerce Platform</p>
                                                    </div>
                                                </div>
                                                <div class="col-6 border- border-top">
                                                    <div class="text-center p-3"><i data-feather="box" width="32" height="32" class="stroke-primary"></i>
                                                        <p class="mb-0">Supportive Environment</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- </div><a href="#!" class="btn btn-light btn-lg btn-block rounded-top-0 rounded-bottom py-4">Contact us <i data-feather="arrow-right" class="ml-3"></i></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="position-relative mt-n12">
            <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-dark"><svg viewBox="0 0 2880 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
                </svg></div>
        </div><!-- ./Pricing Includes -->
        <section class="bg-dark">
            <div class="container pt-15 pb-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading mb-6 text-center">
                            <h4 class="text-white">RCFI Trading Terms & Condition</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media pb-3">
                            <div class="bg-success p-3 rounded-circle center-flex mr-3"><i data-feather="headphones" class="stroke-contrast"></i></div>
                            <div class="media-body">
                                <!-- <h6 class="text-contrast">First class support</h6> -->
                                <p class="text-muted">1. Applicant-Distributor fully understood and agreed to be bound by the terms and conditions, compensation plan, and the policies and procedures of RCFI Trading.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media pb-3">
                            <div class="bg-success p-3 rounded-circle center-flex mr-3"><i data-feather="box" class="stroke-contrast"></i></div>
                            <div class="media-body">
                                <!-- <h6 class="text-contrast">Code snippets</h6> -->
                                <p class="text-muted">2. Applicant-Distributor, will not produced, promote, or use materials of any kind describing the company's programs, products, and trademarked, copyrighted, or otherwise protected materials without the company's express written consent. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media pb-3">
                            <div class="bg-success p-3 rounded-circle center-flex mr-3"><i data-feather="headphones" class="stroke-contrast"></i></div>
                            <div class="media-body">
                                <!-- <h6 class="text-contrast">Full documentation</h6> -->
                                <p class="text-muted">3. Applicant once encoded becomes an official member/distributor of RCFI Trading, and now therefore prohibited to participate in other multi-level marketing ventures. Violation of this term will result to automatic membership termination. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media pb-3">
                            <div class="bg-success p-3 rounded-circle center-flex mr-3"><i data-feather="lock" class="stroke-contrast"></i></div>
                            <div class="media-body">
                                <!-- <h6 class="text-contrast">Total control of your code</h6> -->
                                <p class="text-muted">4. Member-Distributor has the duty to supervise and train all Member/Distributor that he/she may sponsor as describe in the policies. Applicant-Distributor will explain the company's programs honestly and completely when presenting them to others. He/she understand and will clear in any presentations the following; </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media pb-3">
                            <div class="bg-success p-3 rounded-circle center-flex mr-3"><i data-feather="airplay" class="stroke-contrast"></i></div>
                            <div class="media-body">
                                <!-- <h6 class="text-contrast">Responsive design</h6> -->
                                <p class="text-muted">5. Distributor commission (pay-out) is released on weekly basis, cut-off day is every Monday until 11:59 PM, and pay-out released every Friday. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media pb-3">
                            <div class="bg-success p-3 rounded-circle center-flex mr-3"><i data-feather="monitor" class="stroke-contrast"></i></div>
                            <div class="media-body">
                                <!-- <h6 class="text-contrast">Browser support</h6> -->
                                <p class="text-muted">6. Member-Distributor agrees that the company reserves the right to suspend, and even terminate the accounts of distributors, due to negligence, false claims, misrepresentation, unethical business practices such as, but not limited to piracy of distributors to other networks or MLM companies, indirect violation of the existing policies and guidelines of the company is considered as a serious breach. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media pb-3">
                            <div class="bg-success p-3 rounded-circle center-flex mr-3"><i data-feather="lock" class="stroke-contrast"></i></div>
                            <div class="media-body">
                                <!-- <h6 class="text-contrast">Total control of your code</h6> -->
                                <p class="text-muted">7. The use or non-use of any of the provisions of this agreement is not to be considered as a waiver by RCFI Trading.  </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media pb-3">
                            <div class="bg-success p-3 rounded-circle center-flex mr-3"><i data-feather="airplay" class="stroke-contrast"></i></div>
                            <div class="media-body">
                                <!-- <h6 class="text-contrast">Responsive design</h6> -->
                                <p class="text-muted">8. This agreement is valid as long as I am in good standing with RCFI Trading. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- ./Get Theme CTA -->
        <section class="bg-dark">
            <div class="container">
                <div class="section-heading">
                    <div class="row">
                        <div class="col-12 col-md-10 col-lg-8 mx-auto text-center"><span class="badge badge-light badge-pill text-uppercase bold px-4 py-2 mb-4">Rich Courage Faith Inspire Trading</span>
                            <h1 class="text-contrast great-vibes">The Road to <span class="typed" data-strings='["Financial", "Time", "Life"]'></span> freedom.</h1>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="handwritten highlight font-md">Be one of our winning team!</p><a href="<?= base_url()?>front/inquire" class="btn btn-lg btn-alternate text-contrast px-4">Inquire Now</a>
                </div>
            </div>
        </section>

       
<?php $this->load->view('front/template/pre-footer.php');?>
<?php $this->load->view('front/template/footer.php');?>