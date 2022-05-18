@extends('layouts.landing.index')
@section('content')

    <div id="inscription" class="inscription">
        <div class="container">

            <div class="bg-primary text-white py-2 my-3 d-flex align-items-center justify-content-center">
                <span class="mx-3 ">Already a Member?</span>
                <button class="btn text-white" data-bs-target="#loginModal" data-bs-toggle="modal">Login</button>
            </div>

            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="text-center my-3">
                        <span class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br> Asperiores aspernatur deleniti dolore eius fugiat fugit illum nemo numquam</span>
                    </div>

                    <form action="{{url('/api/auth/register')}}" id="inscriptionForm">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 mb-4">
                                <div class="form-group">
                                    <input type="text" name="emailorphone" id="emailorphone"
                                           class="form-control emptyEmailPhone emptyEmailPhone email phone" placeholder="Email or Phone"  onchange="clearError(this)">
                                    <span class="text-danger phone_error email_error" id="emailorphone_error"></span>
                                    <span class="text-danger d-none" id="emptyEmailPhone">The email or phone filed is required</span>
                                    <span class="text-danger d-none" id="validateEmailPhone">Please, Enter the valid email or phone.</span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-4">
                                <input type="password" name="password" id="password" class="form-control password"
                                       placeholder="Password"  onchange="clearError(this)">
                                <span class="text-danger password_error" id="password_error"></span>
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-4">
                                <input type="text" maxlength="13" name="username" id="username" class="form-control"
                                       placeholder="Username (Max. 13 characters)">
                                <span class="text-danger username_error" id="username_error"></span>
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-4">
                                <select id="inscriptionBirthYear" name="dob" class="form-select"></select>
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-4">
                                <input type="text" class="form-control" name="address" placeholder="Location">
                            </div>

                            <div class="col-lg-12 col-sm-12 mb-4">
                                <textarea class="form-control" name="presentation"
                                          placeholder="Your presentation (optional)"></textarea>
                            </div>

                            <div class="col-lg-12 col-sm-12 mb-4">
                                <div class="d-flex align-items-center">
                                    <img id="inscriptionPreviewImgURL" class="avatar-sm-2 d-none me-3 border" src=""
                                         alt="">
                                    <input type="hidden" name="image" id="inscriptionImgURL">
                                    <input type="file" id="file-uploader"
                                           onchange="uploader(event,'','', 'inscriptionImgURL','inscriptionPreviewImgURL')"
                                           hidden name="image"/>
                                    <label for="file-uploader"
                                           class="text-white-50 border-white border-dashed p-2 d-flex align-items-center cursor-pointer">
                                    <span class="iconify me-3" data-icon="fa-solid:camera" data-width="20"
                                          data-height="20"></span>
                                        Click here to add your photo (optional)
                                    </label>
                                </div>

                            </div>

                            <div class="col-lg-12 col-sm-12 mb-4">
                                <div class="form-check text-white-50">
                                    <input required class="form-check-input" type="checkbox" value="" id="termsCheck">
                                    <label class="form-check-label text-white" for="termsCheck">
                                        I have read and accept the <a href="{{url('information?tab=terms')}}"
                                                                      class="text-white text-decoration-underline">terms
                                            and policies</a>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6 offset-lg-3 mb-4">
                                <button type="submit" id="submit-button" class="btn btn-primary form-control text-capitalize">submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('custom-js')
    <script>


        /**
         * Change the current page title
         * */
        window.location.pathname === '/inscription'? document.title = 'Inscription' : ''

        let userToken = localStorage.getItem('accessToken')

        $(document).ready(function (){
            if(userToken){
                location.href = window.origin
            }
        })



        $('#inscriptionForm').submit(function (e) {
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
                $('#emptyEmailPhone').removeClass('d-none')
                $('.emptyEmailPhone').addClass("is-invalid")
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
                    $('#submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {
                    if (
                        response.status === "success" &&
                        response.form === "registration"
                    ) {
                        toastr.success(response.message);

                        location.href = window.origin+'?modal=login'


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
                    $('#submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        })

        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#emailorphone').removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
            $('#emptyEmailPhone').addClass('d-none')
            $("#validateEmailPhone").addClass('d-none')
        }



    </script>
@endpush
