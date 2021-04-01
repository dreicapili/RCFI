

<body>

<nav class="st-nav navbar main-nav navigation fixed-top" id="main-nav">
    <div class="container">
        <ul class="st-nav-menu nav navbar-nav">
            <li class="st-nav-section nav-item"><a href="#main" class="navbar-brand">
              <img src="<?= base_url()?>public/assets/front/img/rcfi-logo.png" alt="Dashcore" class="logo logo-sticky d-block d-md-none">
              <img src="<?= base_url()?>public/assets/front/img/rcfi-logo.png" alt="Dashcore" class="logo d-none d-md-block"></a>
            </li>
            <li class="st-nav-section st-nav-primary nav-item">
              <a class="st-root-link nav-link" href="<?= base_url()?>front/">Home </a>
              <a class="st-root-link item-products st-has-dropdown nav-link" href="<?= base_url()?>front/about" data-dropdown="about">About </a>
              <a class="st-root-link item-products nav-link" href="<?= base_url()?>front/gallery" data-dropdown="blocks">Gallery </a>
              <a class="st-root-link item-products st-has-dropdown nav-link" href="<?= base_url()?>front/shop" data-dropdown="products">Products </a>
              <a class="st-root-link item-shop st-has-dropdown nav-link" href="<?= base_url()?>front/contact" data-dropdown="shop">Support</a>
            </li>
            <li class="st-nav-section st-nav-secondary nav-item">

            <a hidden class="btn btn-rounded btn-outline mr-3 px-3" href="<?= base_url()?>front/login" target="_blank"><i class="fas fa-sign-in-alt d-none d-md-inline mr-md-0 mr-lg-2"></i> <span class="d-md-none d-lg-inline">Login</span> </a>
            <a hidden class="btn btn-rounded btn-solid px-3" href="<?= base_url()?>front/register" target="_blank"><i class="fas fa-user-plus d-none d-md-inline mr-md-0 mr-lg-2"></i> <span class="d-md-none d-lg-inline">Signup</span></a></li><!-- Mobile Navigation -->
            <a class="btn btn-rounded btn-solid px-3" href="<?= base_url()?>front/inquire" target="_blank"><i class="fas fa-envelope d-none d-md-inline mr-md-0 mr-lg-2"></i> <span class="d-md-none d-lg-inline">Inquire Now</span></a></li><!-- Mobile Navigation -->
            
            <li class="st-nav-section st-nav-mobile nav-item"><button class="st-root-link navbar-toggler" type="button"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
                <div class="st-popup">
                    <div class="st-popup-container"><a class="st-popup-close-button">Close</a>
                        <div class="st-dropdown-content-group">
                            <h4 class="text-uppercase regular">Pages</h4>
                            <a class="regular text-primary" href="<?= base_url()?>front/"><i class="far fa-building mr-2"></i> Home </a>
                            <a class="regular text-success" href="<?= base_url()?>front/about"><i class="far fa-envelope mr-2"></i> About </a>
                            <a class="regular text-warning" href="<?= base_url()?>front/shop"><i class="fas fa-hand-holding-usd mr-2"></i> Products </a>
                            <a class="regular text-info" href="<?= base_url()?>front/contact"><i class="far fa-question-circle mr-2"></i> Contact Us </a>
                        </div>
                        <!-- <div class="st-dropdown-content-group border-top bw-2">
                            <h4 class="text-uppercase regular">Components</h4>
                            <div class="row">
                                <div class="col mr-4"><a target="_blank" href="components/alert.html">Alerts</a> <a target="_blank" href="components/badge.html">Badges</a> <a target="_blank" href="components/button.html">Buttons</a> <a target="_blank" href="components/color.html">Colors</a> <a target="_blank" href="components/accordion.html">Accordion</a> <a target="_blank" href="components/cookie-law.html">Cookielaw</a></div>
                                <div class="col mr-4"><a target="_blank" href="components/overlay.html">Overlay</a> <a target="_blank" href="components/progress.html">Progress</a> <a target="_blank" href="components/lightbox.html">Lightbox</a> <a target="_blank" href="components/tab.html">Tabs</a> <a target="_blank" href="components/tables.html">Tables</a> <a target="_blank" href="components/typography.html">Typography</a></div>
                            </div>
                        </div>
                        <div class="st-dropdown-content-group bg-light b-t"><a href="login.html">Sign in <i class="fas fa-arrow-right"></i></a></div> -->
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="st-dropdown-root">
        <div class="st-dropdown-bg">
            <div class="st-alt-bg"></div>
        </div>
        <div class="st-dropdown-arrow"></div>
        <div class="st-dropdown-container">
            <div class="st-dropdown-section" data-dropdown="about">
                <div class="st-dropdown-content">
                    <div class="st-dropdown-content-group">
                        <div class="row">
                            <div class="col mr-4">
                                <a class="dropdown-item" href="<?= base_url()?>front/about">About RCFI</a> 
                                <a class="dropdown-item" href="<?= base_url()?>front/testimonial">Feedback & Testimonial</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="st-dropdown-section" data-dropdown="products">
                <div class="st-dropdown-content">
                    <div class="st-dropdown-content-group">
                        <div class="row">
                            <div class="col mr-4">
                                <a class="dropdown-item" href="#">Chaze</a> 
                                <a class="dropdown-item" href="#">Kape</a> 
                                <a class="dropdown-item" href="#">Malunggay</a> 
                                <a class="dropdown-item" href="#">Nutririch</a> 
                                <a class="dropdown-item" href="#">Zack</a> 
                                <a class="dropdown-item" href="#">Promotional</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="st-dropdown-section" data-dropdown="components">
                <div class="st-dropdown-content">
                    <div class="st-dropdown-content-group"><a class="dropdown-item" target="_blank" href="components/color.html">
                            <div class="media mb-4"><i class="fas fa-palette mr-2 bg-primary rounded-circle icon-md text-contrast center-flex"></i>
                                <div class="media-body">
                                    <h3 class="link-title m-0">Colors</h3>
                                    <p class="m-0 text-secondary">Get to know DashCore color options</p>
                                </div>
                            </div>
                        </a><a class="dropdown-item" target="_blank" href="components/accordion.html">
                            <div class="media mb-4"><i class="fas fa-bars mr-2 bg-primary rounded-circle icon-md text-contrast center-flex"></i>
                                <div class="media-body">
                                    <h3 class="link-title m-0">Accordion</h3>
                                    <p class="m-0 text-secondary">Useful accordion elements</p>
                                </div>
                            </div>
                        </a><a class="dropdown-item" target="_blank" href="components/cookie-law.html">
                            <div class="media mb-4"><i class="fas fa-cookie-bite mr-2 bg-primary rounded-circle icon-md text-contrast center-flex"></i>
                                <div class="media-body">
                                    <h3 class="link-title m-0">CookieLaw</h3>
                                    <p class="m-0 text-secondary">Comply with the hideous EU Cookie Law</p>
                                </div>
                            </div>
                        </a>
                        <h4 class="text-uppercase regular">Huge components list</h4>
                        <div class="row">
                            <div class="col mr-4"><a class="dropdown-item" target="_blank" href="components/alert.html">Alerts</a> <a class="dropdown-item" target="_blank" href="components/badge.html">Badges</a> <a class="dropdown-item" target="_blank" href="components/button.html">Buttons</a></div>
                            <div class="col mr-4"><a class="dropdown-item" target="_blank" href="components/overlay.html">Overlay</a> <a class="dropdown-item" target="_blank" href="components/progress.html">Progress</a> <a class="dropdown-item" target="_blank" href="components/lightbox.html">Lightbox</a></div>
                            <div class="col mr-4"><a class="dropdown-item" target="_blank" href="components/tab.html">Tabs</a> <a class="dropdown-item" target="_blank" href="components/tables.html">Tables</a> <a class="dropdown-item" target="_blank" href="components/typography.html">Typography</a></div>
                        </div>
                    </div>
                    <div class="st-dropdown-content-group"><a class="dropdown-item" target="_blank" href="components/wizard.html">Wizard <span class="badge badge-pill badge-primary">New</span></a> <span class="dropdown-item d-flex align-items-center text-muted">Timeline <i class="fas fa-ban ml-auto"></i></span> <span class="dropdown-item d-flex align-items-center text-muted">Process <i class="fas fa-ban ml-auto"></i></span></div>
                </div>
            </div>
            <div class="st-dropdown-section" data-dropdown="blog">
                <div class="st-dropdown-content">
                    <div class="st-dropdown-content-group">
                        <div class="row">
                            <div class="col mr-4">
                                <h4 class="regular text-uppercase">Full width</h4><a class="dropdown-item" target="_blank" href="blog/blog-post.html">Single post</a> <a class="dropdown-item" target="_blank" href="blog/blog-grid.html">Posts Grid</a>
                            </div>
                            <div class="col mr-4">
                                <h4 class="regular text-uppercase">Sidebar left</h4><a class="dropdown-item" target="_blank" href="blog/blog-post-sidebar-left.html">Single post</a> <a class="dropdown-item" target="_blank" href="blog/blog-grid-sidebar-left.html">Posts Grid</a>
                            </div>
                            <div class="col mr-4">
                                <h4 class="regular text-uppercase">Sidebar right</h4><a class="dropdown-item" target="_blank" href="blog/blog-post-sidebar-right.html">Single post</a> <a class="dropdown-item" target="_blank" href="blog/blog-grid-sidebar-right.html">Posts Grid</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="st-dropdown-section" data-dropdown="shop">
                <div class="st-dropdown-content">
                    <div class="st-dropdown-content-group"><a class="dropdown-item" href="<?= base_url()?>front/contact">
                            <div class="media align-items-center">
                                <div class="bg-success text-contrast icon-md center-flex rounded-circle mr-3"><i class="fas fa-phone"></i></div>
                                <div class="media-body">
                                    <h3 class="link-title m-0">Contact Us</h3>
                                    <p class="m-0 text-secondary">We are 24/7 Online for you</p>
                                </div>
                            </div>
                        </a>
                        <!-- <a class="dropdown-item" href="<?= base_url()?>front/faq">
                            <div class="media align-items-center">
                                <div class="bg-info text-contrast icon-md center-flex rounded-circle mr-3"><i class="fas fa-shopping-cart"></i></div>
                                <div class="media-body">
                                    <h3 class="link-title m-0">FAQ's</h3>
                                    <p class="m-0 text-secondary">Online store shopping cart</p>
                                </div>
                            </div>
                        </a> -->
                    </div>
                    <!-- <div class="st-dropdown-content-group">
                        <h3 class="link-title"><i class="fas fa-money-check-alt icon"></i> Checkout</h3>
                        <div class="ml-5"><a class="dropdown-item text-secondary" target="_blank" href="shop/checkout-customer.html">Customer <i class="fas fa-angle-right ml-2"></i> </a><a class="dropdown-item text-secondary" target="_blank" href="shop/checkout-shipping.html">Shipping Information <i class="fas fa-angle-right ml-2"></i> </a><a class="dropdown-item text-secondary" target="_blank" href="shop/checkout-payment.html">Payment Methods <i class="fas fa-angle-right ml-2"></i> </a><a class="dropdown-item text-secondary" target="_blank" href="shop/checkout-confirmation.html">Order Review <i class="fas fa-angle-right ml-2"></i></a></div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</nav>
<main class="overflow-hidden">