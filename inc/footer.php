<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3 footer-item">
                    <h4 class="text-uppercase">Thông tin</h4>
                    <ul class="menu-list">
                        <li><a href="#">Giới thiệu Min</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Thông tin thương hiệu</a></li>
                        <li><a href="#">Hệ thống cửa hàng</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="#">Thông tin liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-3 footer-item">
                    <h4 class="text-uppercase">Trợ giúp</h4>
                    <ul class="menu-list">
                        <li><a href="#">Phương thức thanh toán</a></li>
                        <li><a href="#">Chính sách khách hàng thân thiết</a></li>
                        <li><a href="#">Chính sách giao hàng</a></li>
                        <li><a href="#">Chính sách mua hàng</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                    </ul>
                </div>
                <div class="col-md-3 footer-item">
                    <h4 class="text-uppercase">Thanh toán</h4>
                    <ul class="menu-list">
                        <li><a href="#">Visa / Mastercard / JCB</a></li>
                        <li><a href="#">ATM / Internet Banking</a></li>
                        <li><a href="#">Quét mã QR</a></li>
                        <li><a href="#">Thanh toán khi nhận hàng (COD)</a></li>
                    </ul>
                </div>
                <div class="col-md-3 footer-item last-item">
                    <h4 class="text-uppercase">Contact Us</h4>
                    <div class="contact-form">
                        <form id="contact footer-contact" action="" method="post">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*" placeholder="E-Mail Address" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required=""></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="filled-button">Send Message</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        Copyright © 2024 Min Watch INTERNATIONAL CORPORATION. All rights reserved. <br>
                        Địa chỉ: 226, Thôn 9, Cát Quế, H.Hoài Đức, TP.Hà Nội | MST: 09665661503 | Hotline: 1900 252 538
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ***** Preloader Start ***** -->
    <!-- <div id="page-preloader" style="display: none;">
        <div class="page-loading">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div> -->
    <!-- ***** Preloader End ***** -->

    <!-- Bootstrap core JavaScript -->
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>




    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/quantity.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="assets/js/locationSelection.js"></script>
    
    <script>
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                const input = $(this).closest('.input-group').find('input');
                const icon = $(this).find('i');
                const type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                icon.toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
</body>

</html>