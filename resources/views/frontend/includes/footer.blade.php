<footer class="page-footer section-80">
    <div class="container container-wide text-md-left">
        <div class="row row-50">
            <div class="col-sm-12 col-md-2">
                <a class="f-logo" href="">
                    <img class="img-responsive" src="/images/logo-white.png" width="166" height="55" alt="Logo">
                </a>
            </div>
            <div class="col-sm-12 col-md-8">
                <ul class="nav-menu">
                    <li class="item-menu">
                        <a href="{{--route('frontend.index')--}}">HOME</a>
                    </li>
                    <li class="item-menu">
                        <a href="{{route('frontend.about')}}">ABOUT</a>
                    </li>
                    @guest
                    <li class="item-menu">
                        <a href="{{route('frontend.auth.charter-register')}}">CHARTER REGISTER</a>
                    </li>
                    @endguest
                    <li class="item-menu">
                        <a href="{{route('frontend.contact')}}">CONTACT</a>
                    </li>
                    <li class="item-menu">
                        <a href="{{route('frontend.terms-conditions')}}">TERMS & CONDITIONS</a>
                    </li>
                    <li class="item-menu">
                        <a href="{{route('frontend.privacy-policy')}}">PRIVACY POLICY</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-12 col-md-2">
                <ul class="social-nav">
                    <li>
                        <a class="" href="#">
                            <i class="fab fa-twitter-square"></i>
                        </a>
                    </li>
                    <li>
                        <a class="" href="#">
                            <i class="fab fa-facebook-square"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row row-50 copyright-top">
            <div class="col-sm-12">
                <p class="rights copy text-center">
                    <span>&copy;</span>
                    <span class="copyright-year"><?php echo date('Y'); ?></span>
                    <span>All Rights Reserved.</span>
                    <a href="privacy-policy.html">Jumla Booking.</a>
                </p>
            </div>
        </div>

    </div>
</footer>
</div>
</body>
</html>