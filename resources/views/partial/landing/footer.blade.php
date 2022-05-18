<div id="footer" class="footer text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <a href="{{url('/')}}">
                    <img id="footerLogo" class="img-fluid avatar-sm-1-circle"
                         src="{{asset('images\default.png')}}"
                         alt="">
                </a>

                <span id="footerWebsiteName" class="site-description d-block my-3"></span>
                <span id="footerDescription" class="site-description d-block my-3"></span>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <h6 class="footer_title text-capitalize fw-bold fs-5">site map</h6>

                <div class="row row-cols-2">
                    <div class="col">
                        <ul class="list">
                            <li class="list-item">
                                <a href="{{url('/')}}" class="list-link text-capitalize">Members</a>
                            </li>
                            <li class="list-item">
                                <a href="{{url('/information?tab=legal')}}" class="list-link text-capitalize">Legal
                                    Notice</a>
                            </li>

                            <li class="list-item">
                                <a href="{{url('/videos')}}" class="list-link text-capitalize">Videos</a>
                            </li>
                            <li class="list-item">
                                <a href="{{url('/about')}}" class="list-link text-capitalize">X-flix ?</a>
                            </li>
                            <li class="list-item">
                                <a href="{{url('/live')}}" class="list-link text-capitalize">Live</a>
                            </li>

                        </ul>
                    </div>
                    <div class="col">
                        <ul class="list">
                            <li class="list-item">
                                <a href="{{url('/inscription')}}" class="list-link text-capitalize">Inscription</a>
                            </li>
                            <li class="list-item" id="footerConnectionButton">
                                <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal"
                                   class="list-link text-capitalize">Connection</a>
                            </li>
                            <li class="list-item">
                                <a href="{{url('/information?tab=faq')}}" class="list-link text-capitalize">Faq /
                                    Contact</a>
                            </li>
                            <li class="list-item">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#contactModal"
                                   class="list-link text-capitalize">Contact</a>
                            </li>
                            <li class="list-item">
                                <a href="{{url('/information?tab=refund')}}" class="list-link text-capitalize">Refund Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <h6 class="footer_title text-capitalize fw-bold fs-5">Partner site</h6>
                <ul class="row list" id="partnerList">
                </ul>
            </div>


            <div class="col-lg-3 col-sm-6 col-12">
                <h6 class="footer_title text-capitalize fw-bold fs-5">Share the Website on</h6>

                <div class="d-flex align-items-center">
                    <a id="facebook-share" href="" target="_blank" class="list-link">
                        <i class="bi bi-facebook social-icon"></i>
                    </a>

                    <a id="twitter-share" href="" target="_blank" class="list-link">
                        <i class="bi bi-twitter social-icon"></i>
                    </a>


                </div>


            </div>
        </div>
    </div>
</div>

{{--Confirmation Modal--}}
<div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h6 class="text-capitalize">title</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="text-center">
                            <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque, nostrum.</span>
                        </div>


                        <select id="dobyear" class="my-3 form-select py-3 px-4 rounded-0 "></select>
                        <span id="confirmErrMsg"
                              class="text-danger  d-none">Please Confirm Your Birth Year....</span>

                        <button id="birthConfirmDialogBtn"
                                class="btn btn-primary form-control py-3 px-4 rounded-0 my-3 text-capitalize">
                            confirm
                        </button>

                        <div class="text-center">
                            <span class="text-center">or</span>
                        </div>


                        <button data-bs-target="#loginModal" data-bs-toggle="modal"
                                class="btn btn-dark form-control py-3 px-4 rounded-0 my-3 text-capitalize">
                            login
                        </button>

                        <a
                            href="{{url('/auth/twitter')}}"
                            class="btn btn-tweeter form-control py-3 px-4 rounded-0 my-3 d-flex align-items-center justify-content-center"
                        >
                            <span class="iconify me-3" data-icon="akar-icons:twitter-fill" data-width="20" data-height="20"></span>
                            <span>Connect with Twitter</span>
                        </a>


                        <h6 class="text-capitalize fw-bold">terms & condition</h6>
                        <span id="confirmDialogTermsCondition" class="fw-lighter"></span>

                        <div class="border-top border-bottom py-2 my-3 text-center">
                            <p class="text-black-50">How to protect your child</p>
                            <ul class="d-flex justify-content-around align-items-center">
                                <li>
                                    <a href="">
                                        <img class="avatar"
                                             src="https://w7.pngwing.com/pngs/786/126/png-transparent-logo-contracting-photography-logo-symbol.png"
                                             alt="">
                                    </a>
                                </li>

                                <li>
                                    <a href="">
                                        <img class="avatar"
                                             src="https://w7.pngwing.com/pngs/786/126/png-transparent-logo-contracting-photography-logo-symbol.png"
                                             alt="">
                                    </a>
                                </li>

                                <li>
                                    <a href="">
                                        <img class="avatar"
                                             src="https://w7.pngwing.com/pngs/786/126/png-transparent-logo-contracting-photography-logo-symbol.png"
                                             alt="">
                                    </a>
                                </li>
                            </ul>


                        </div>
                        <span class="fw-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aliquid aperiam consectetur cum deserunt distinctio eaque id ipsum libero maiores minima, molestias natus </span>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="contactModal" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h6 class="text-capitalize">Contact</h6>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <span>You have a question, a problem, a suggestion ... contact us</span>
                </div>
                <form action="{{url('/api/contact-us')}}" id="contactForm">
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-3">
                            <div class="form-group">
                                <input type="email" name="email" id="email"  class="form-control email" placeholder="email"  onchange="clearError(this)">
                                <span class="text-danger email_error" id="email_error"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 mb-3">
                            <div class="form-group">
                                <input type="text" name="subject" id="subject" class="subject form-control" placeholder="Subject"  onchange="clearError(this)">
                                <span class="text-danger subject_error" id="subject_error"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-12 mb-3">
                            <div class="form-group">
                                <textarea name="message" id="message"  class="form-control message" placeholder="Message" onchange="clearError(this)"></textarea>
                                <span class="text-danger message_error" id="message_error"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 offset-lg-3">
                            <button id="contact-submit-button" class="btn btn-primary form-control">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="locationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h6 class="text-capitalize">GEO Location</h6>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <span>To display the profiles around you, <br> indicate the city below:</span>
                </div>
                <div class="form-group">
                    <input type="text" name="address" class="form-control  locationInput" placeholder="city">
                    <span class="locationError text-danger d-none">Please select your city</span>
                </div>
                <div class="text-center my-3">
                    <button id="location-btn" class="btn btn-primary w-75  form-control">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="forgotModal" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h6 class="text-capitalize">Recover Password</h6>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <span id="forget_modal_title">Please Enter Your Email or Phone For Recovery Password</span>
                </div>
                <form action="{{url('api/forgot-password')}}" id="recoverForm">
                    <div class="form-group">

                        <input type="text" name="emailorphone" id="emailorphone"
                               class="form-control emptyEmailPhone loginEmptyEmailPhone_input emptyEmailPhone email phone"
                               placeholder="Email or Phone" onchange="clearError(this)">
                        <span class="text-danger phone_error email_error" id="emailorphone_error"></span>

                        <span class="text-danger d-none"
                              id="loginEmptyEmailPhone">The email or phone filed is required</span>

                        <span class="text-danger d-none"
                              id="validateEmailPhone">Please, Enter the valid email or phone.</span>
                        <span class="text-danger d-none"
                              id="emailorphone_register_error">Please, Registered first</span>
                    </div>
                    <div class="text-center my-3">
                        <button type="submit" id="recover-submit-button" class="btn btn-primary">Send OTP</button>
                        <a href="{{url('/')}}"  class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>


                <form action="{{url('api/otp')}}" class="d-none" id="otpForm">
                    <input type="hidden" name="email" id="recoverEmailHiddenInput">
                    <input type="hidden" name="phone" id="recoverPhoneHiddenInput">

                    <div class="form-group">
                        <input required type="number" name="verification_code" id="otp"
                               class="form-control otp" placeholder='0000000'>
                    </div>
                    <div class="text-center my-3">
                        <button type="submit" id="otp-submit-button" class="btn btn-primary">Match OTP</button>
                        <a href="{{url('/')}}"  class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>

                <form action="{{url('api/recover-password')}}" class="d-none" id="recoverPasswordForm">
                    <input type="hidden" name="email" id="passwordChangeHiddenEmailInput">
                    <input type="hidden" name="phone" id="passwordChangeHiddenPhoneInput">
                    <div class="form-group">
                        <input required type="password" name="password" id="password"
                               class="form-control email phone" placeholder="New Password">
                    </div>
                    <div class="text-center my-3">
                        <button type="submit" id="recover-password-submit-button" class="btn btn-primary">Recover Password</button>
                        <a href="{{url('/')}}"  class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alertModal" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h6 class="text-capitalize">Report a dangerous behavior</h6>
            </div>
            <div class="modal-body">
                <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad atque consequuntur debitis dicta dolorem doloremque dolorum enim ipsam, itaque iure laboriosam libero magnam magni molestiae molestias nihil nulla </span>
                <form action="{{url("/api/alert/store")}}" id="alertForm">
                    <input type="hidden" name="reported_user_id" id="reported_user_id">

                    <div class="row my-3">
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="reports[]" value="prostitution"
                                       id="report1">
                                <label class="form-check-label" for="report1">
                                    Prostitution
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="reports[]" type="checkbox" value="scam"
                                       id="report2">
                                <label class="form-check-label" for="report2">
                                    Scam
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="reports[]" type="checkbox" value="minor"
                                       id="report3">
                                <label class="form-check-label" for="report3">
                                    Minor
                                </label>
                            </div>
                        </div>
                    </div>

                    <label for="message" id="message_label" class="message_label">Message</label>
                    <textarea name="message" id="message" class="form-control my-3 message"
                              onchange="clearError(this)"></textarea>
                    <span id="message_error" class="text-danger message_error"></span>

                    <button type="submit" id="alert-submit-button" class="btn btn-primary">Alert</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary">Cancel</button>
                </form>


            </div>
        </div>
    </div>
</div>

<div id="message-box">

</div>


@include('partial.landing.auth.login')
<script src="{{asset('asset/vendor/jquery/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('asset/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
{{--<script src="{{asset('asset/vendor/bootstrap/js/bootstrap.min.js')}}"></script>--}}
<script src="{{asset('asset/vendor/Minimalist-jQuery-Plugin-For-Birthday-Selector-DOB-Picker/dobpicker.js')}}"></script>

<script src="{{asset('asset/vendor/toastr/toastr.js')}}"></script>
<script src="{{asset('asset/vendor/ImagesLoader-main/jquery.imagesloader-1.0.1.js')}}"></script>
<script src="{{asset('asset/vendor/rater-js-master/index.js')}}"></script>

<script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/3.2.1/jquery.serializejson.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
<script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/cdb.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/languages.js')}}"></script>
<script>


    let userTokens = localStorage.getItem('accessToken')

    if(userTokens){
        $('#footerConnectionButton').hide()
    }else{
        $('#footerConnectionButton').show()
    }

    $('#alertForm').submit(function (e) {
        e.preventDefault();
        let token = localStorage.getItem("accessToken");
        let form = $(this);
        let form_data = JSON.stringify(form.serializeJSON());
        let formData = JSON.parse(form_data)

        let url = form.attr('action');

        let checked = []
        $("input[name='reports[]']:checked").each(function () {
            checked.push($(this).val());

        });
        formData.reports = checked


        $.ajax({
            type: "post",
            url: url,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                Authorization: token,
            },

            beforeSend: function () {
                $('#alert-submit-button').prop('disabled', true);

                $('#preloader').removeClass('d-none');
            },
            success: function (response) {

                toastr.success(response.message)
                location.reload();
            }, error: function (xhr, resp, text) {

                if (xhr && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    if (response.status && response.status === "validate_error") {
                        $.each(response.message, function (index, message) {
                            $("." + message.field).addClass("is-invalid");
                            $("." + message.field + "_label").addClass(
                                "text-danger"
                            );
                            $("." + message.field + "_error").html(message.error);
                        });
                    }
                }
            },
            complete: function (xhr, status) {
                $('#preloader').addClass('d-none');
                $('#alert-submit-button').prop('disabled', false);
            }

        });
    })

    $('#contactForm').submit(function (e) {
        e.preventDefault();
        let token = localStorage.getItem("accessToken");
        let form = $(this);
        let form_data = JSON.stringify(form.serializeJSON());
        let formData = JSON.parse(form_data)

        let url = form.attr('action');


        $.ajax({
            type: "post",
            url: url,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                Authorization: token,
            },

            beforeSend: function () {
                $('#contact-submit-button').prop('disabled', true);

                $('#preloader').removeClass('d-none');
            },
            success: function (response) {

                toastr.success(response.message)
                location.reload();
            }, error: function (xhr, resp, text) {

                if (xhr && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    if (response.status && response.status === "validate_error") {
                        $.each(response.message, function (index, message) {
                            $("." + message.field).addClass("is-invalid");
                            $("." + message.field + "_label").addClass(
                                "text-danger"
                            );
                            $("." + message.field + "_error").html(message.error);
                        });
                    }
                }
            },
            complete: function (xhr, status) {
                $('#preloader').addClass('d-none');
                $('#contact-submit-button').prop('disabled', false);
            }

        });
    })

    function clearError(input) {
        $('#' + input.id).removeClass('is-invalid');
        $('#' + input.id + '_label').removeClass('text-danger');
        $('#' + input.id + '_icon').removeClass('text-danger');
        $('#' + input.id + '_icon_border').removeClass('field-error');
        $('#' + input.id + '_error').html('');
        $('#' + input.id + '_register_error').html('');
    }

    $('#recoverForm').submit(function (e) {
        e.preventDefault();

        let form = $(this);


        let form_data = JSON.stringify(form.serializeJSON());
        let formData = JSON.parse(form_data);

        if (formData.emailorphone) {
            let data = {
                email: null,
                phone: null,
            };

            let emailRegex =
                /(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/;

            let numberRegex = /^\s*[+-]?(\d+|\d*\.\d+|\d+\.\d*)([Ee][+-]?\d+)?\s*$/


            if(emailRegex.test(formData.emailorphone)){
                data.email = formData.emailorphone;
                formData.email = data.email;
            }else if(numberRegex.test(formData.emailorphone)){
                data.phone = formData.emailorphone;
                formData.phone = data.phone;
            }else{
                $("#validateEmailPhone").removeClass('d-none')
                $('.emptyEmailPhone').addClass("is-invalid")
            }

        }else{
            $('#loginEmptyEmailPhone').removeClass('d-none')
            $('.emptyEmailPhone').addClass("is-invalid")
            $('.loginEmptyEmailPhone_label').addClass("text-danger")
        }

        if (formData.dob) {
            let now = new Date().getFullYear();
            formData.age = now - formData.dob;
        }


        let url = form.attr("action");



        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                $('#recover-submit-button').prop('disabled', true);
                $('#preloader').removeClass('d-none');
            },
            success: function (response) {
                if (response.status === 'success' && response.form === "recoverForm") {
                    $("#otpForm").removeClass("d-none");
                    $("#recoverForm").addClass("d-none");
                    $("#recoverEmailHiddenInput").val(response.email);
                    $("#passwordChangeHiddenEmailInput").val(response.email);
                    $("#forget_modal_title").text("We sent an otp code in you email "+ response.email );
                }
            },
            error: function (xhr, resp, text) {
                if (xhr && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    if (response.status && response.status === "validate_error") {
                        $.each(response.message, function (index, message) {
                            $("." + message.field).addClass("is-invalid");
                            $("." + message.field + "_label").addClass(
                                "text-danger"
                            );
                            $("." + message.field + "_error").html(message.error);
                        });
                    }
                }
            },
            complete: function (xhr, status) {
                $('#preloader').addClass('d-none');
                $('#recover-submit-button').prop('disabled', false);
            }
        });
    })

    $('#otpForm').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_data = JSON.stringify(form.serializeJSON());
        let formData = JSON.parse(form_data);
        let url = form.attr("action");
        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
            $('#otp-submit-button').prop('disabled', true);
            $('#preloader').removeClass('d-none');
        },
            success: function (response) {
                if(response.status === 'success' && response.form === 'otp_form'){
                    $("#otpForm").addClass("d-none");
                    $("#recoverForm").addClass("d-none");
                    $("#recoverPasswordForm").removeClass("d-none");
                    $("#forget_modal_title").text(response.message);

                }

            },
            error: function (xhr, resp, text) {
                if (xhr && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    if (response.status && response.status === "validate_error") {
                        $.each(response.message, function (index, message) {
                            $("." + message.field).addClass("is-invalid");
                            $("." + message.field + "_label").addClass(
                                "text-danger"
                            );
                            $("." + message.field + "_error").html(message.error);
                        });
                    }
                }
            },
            complete: function (xhr, status) {
                $('#preloader').addClass('d-none');
                $('#otp-submit-button').prop('disabled', false);
            }
        });
    })


    $('#recoverPasswordForm').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_data = JSON.stringify(form.serializeJSON());
        let formData = JSON.parse(form_data);
        let url = form.attr("action");
        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
            $('#recover-password-submit-button').prop('disabled', true);
            $('#preloader').removeClass('d-none');
        },
            success: function (response) {
                if(response.status === 'success'){
                    toastr.success(response.message)

                    setTimeout(function () {
                        location.reload();
                    }, 1000);

                }


            },
            error: function (xhr, resp, text) {
                if (xhr && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    if (response.status && response.status === "validate_error") {
                        $.each(response.message, function (index, message) {
                            $("." + message.field).addClass("is-invalid");
                            $("." + message.field + "_label").addClass(
                                "text-danger"
                            );
                            $("." + message.field + "_error").html(message.error);
                        });
                    }
                }
            },
            complete: function (xhr, status) {
                $('#preloader').addClass('d-none');
                $('#recover-password-submit-button').prop('disabled', false);
            }
        });
    })




    $(document).ready(function () {
        $.ajax({
            url: window.origin + '/api/share-website',
            type: 'GET',
            dataType: "json",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (res) {
                $('#facebook-share').attr('href', res.data.facebook)
                $('#twitter-share').attr('href', res.data.twitter)
            }, error: function (jqXhr, ajaxOptions, thrownError) {
                console.log(jqXhr)
            }
        });


        $.ajax({
            url: window.origin + '/api/admin/setting/get-all',
            type: 'GET',
            dataType: "json",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },

            success: function (res) {
                if (res.status === 'success' && res.data.length) {

                    Object.entries(res.data[0]).forEach(item => {

                        if(item[0] === 'system_name'){
                            $('#footerWebsiteName').text(item[1] ? item[1] : "")
                        }
                        // console.log('footer setting', item)
                        //

                        if (item[0] === 'image') {

                            if(item[1]){
                                item[1].forEach(img=>{
                                    if(img.logo){
                                        $('#footerLogo').attr('src',img.logo)
                                        $('#navLogo').attr('src', img.logo)
                                    }
                                })
                            }
                        }
                        if (item[0] === "legal_information") {
                            if (item[1]) {
                                Object.entries(item[1]).forEach(value => {
                                    if (value[0] === "'description'") {
                                        $('#footerDescription').text(value[1] ? value[1]: '')
                                    }
                                    if (value[0] === "'terms_of_use'") {
                                        $('#confirmDialogTermsCondition').text(value[1] ? value[1]: '')
                                    }
                                    if (value[0] === "'about'") {
                                        $('#aboutUs').text(value[1] ? value[1]: 'Please create an about at admin panel to view in your site')
                                    }
                                    if (value[0] === "'notice'") {
                                        $('#legalInfo').text(value[1] ? value[1]: 'Please create an legal notice at admin panel to view in your site')
                                    }

                                })
                            }

                        }
                        if (item[0] === "partner_site") {
                            if (item[1]) {
                                item[1].forEach(site => {
                                    $('#partnerList').append(`
                                ${site.name ? (`
                                    <li class="col-lg-6 list-item">
                                        <a href="${site.url}" class="list-link">${site.name}</a>
                                    </li>
                                `) : ''}

                                `)
                                })
                            }


                        }

                    })

                }

            }, error: function (jqXhr, ajaxOptions, thrownError) {
                console.log(jqXhr)
            }
        })
    })

    $(function(){
        var userActivity = localStorage.getItem('accessToken')
        if(userActivity){
            $.ajax({
                url: "{{url('/api/user-activity-check')}}",
                method: "patch",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization":userActivity
                },
                success:function (res){

                },
                error:function(err){
                    console.log(err)
                }

            })
        }


    })

</script>

@stack('custom-js')


</body>
</html>
