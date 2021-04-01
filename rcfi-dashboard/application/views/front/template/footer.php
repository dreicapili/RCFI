    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v7.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Your Chat Plugin code -->
    <div class="fb-customerchat"
        attribution=setup_tool
        page_id="112121147092352"
        theme_color="#0084ff">
    </div>

    <script src="<?= base_url()?>public/assets/front/js/01.cookie-consent-util.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/02.1.cookie-consent-themes.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/02.2.cookie-consent-custom-css.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/02.3.cookie-consent-informational.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/02.4.cookie-consent-opt-out.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/02.5.cookie-consent-opt-in.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/02.6.cookie-consent-location.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/card.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/counterup2.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/index.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/noframework.waypoints.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/odometer.min.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/prism.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/simplebar.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/swiper.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/popper.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/jquery.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/jquery.easing.min.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/jquery.smartWizard.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/plugins/jquery.animatebar.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/feather.min.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/bootstrap.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/aos.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/typed.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/jquery.magnific-popup.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/cookieconsent.min.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/common-script.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/forms.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/stripe-bubbles.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/stripe-menu.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/cc.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/pricing.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/shop.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/svg.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/site.js"></script>
    <script src="<?= base_url()?>public/assets/front/js/03.demo.js"></script><!-- endinject -->
</body>

</html>