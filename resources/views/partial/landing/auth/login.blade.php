<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <div class="login-content">
                    <h4 class="text-capitalize text-center">login</h4>
                    <hr>
                    <div class="d-flex align-items-center justify-content-center">
                        <span>Not a member yet? </span>
                        <a class="btn text-primary text-decoration-underline" href="{{url('/inscription')}}">Sign Up</a>
                    </div>

                    <form action="{{url('/api/auth/login')}}" id="loginForm">

                        <div class="form-group mb-3">
                            <label for="email" id="email_label"
                                   class="form-label email_label phone_label loginEmptyEmailPhone_label">Email or
                                Phone</label>

                            <input type="text" name="emailorphone" id="emailorphone"
                                   class="form-control emptyEmailPhone loginEmptyEmailPhone_input emptyEmailPhone email phone"
                                   placeholder="Email or Phone" onchange="clearError(this)">
                            <span class="text-danger phone_error email_error" id="emailorphone_error"></span>

                            <span class="text-danger d-none" id="loginEmptyEmailPhoneError">The email or phone filed is required</span>

                            <span class="text-danger d-none" id="validateEmailPhone">Please, Enter the valid email or phone.</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" id="password_label" class="form-label password_label">Password</label>
                            {{--                            <input class="form-control password" type="password" id="password" name="password" placeholder="*******">--}}
                            <input type="password" name="password" id="password" class="form-control password"
                                   placeholder="*****" onchange="clearError(this)">

                            <span class="text-danger password_error " id="password_error"></span>

                            <div class="text-end">
                                <a href="#" class="text-decoration-underline" data-bs-target="#forgotModal"
                                   data-bs-toggle="modal">forget password?</a>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" id="login-submit-button" class="btn btn-primary form-control">Login</button>
                        </div>
                        <div class="text-center mb-3">
                            <span>or</span>
                        </div>

                        <div class="form-group mb-3">
                            <a href="{{url('/auth/twitter')}}"
                               class="btn btn-tweeter form-control d-flex align-items-center justify-content-center">
                                <span class="iconify me-3" data-icon="akar-icons:twitter-fill" data-width="20" data-height="20"></span>
                                Connect with Twitter
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('custom-js')
    <script>
        $('#loginForm').submit(function (e) {
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


                if (emailRegex.test(formData.emailorphone)) {
                    data.email = formData.emailorphone;
                    formData.email = data.email;
                } else if (numberRegex.test(formData.emailorphone)) {
                    data.phone = formData.emailorphone;
                    formData.phone = data.phone;
                } else {
                    $("#validateEmailPhone").removeClass('d-none')
                    $('.emptyEmailPhone').addClass("is-invalid")
                }

            } else {
                $('#loginEmptyEmailPhoneError').removeClass('d-none')
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
                }
                ,
                beforeSend: function () {
                $('#login-submit-button').prop('disabled', true);
                $('#preloader').removeClass('d-none');
            },
                success: function (response) {

                    if (response.status === "success" && response.form === "login") {
                        toastr.success(response.message);
                        localStorage.setItem("accessToken", response.data.token);
                        localStorage.setItem(
                            "user",
                            JSON.stringify(response.data.user)
                        );
                        $("#loginModal").modal("hide");
                        location.href = window.origin
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
                    $('#login-submit-button').prop('disabled', false);
                }
            });
        })


        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#emailorphone').removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('.loginEmptyEmailPhone_label').removeClass('text-danger');
            $('.emptyEmailPhone').removeClass("is-invalid")
            $('#password').removeClass("is-invalid")
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
            $('#loginEmptyEmailPhoneError').addClass('d-none')
            $("#validateEmailPhone").addClass('d-none')
        }

    </script>
@endpush
