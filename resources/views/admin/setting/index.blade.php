@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-setting">
            <form action="{{url('api/admin/setting/store')}}" id="settingForm">
                <span class="portion-title">Basic Setting</span>
                <div class="row my-3">
                    <div class="col-lg-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="system_name" id="system_name_label" class="form-label system_name_label">System
                                Name *</label>
                            <input type="text" id="system_name" name="system_name" class="form-control system_name"   onchange="clearError(this)">
                            <span class="text-primary system_name_error" id="system_name_error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="web_version" id="web_version_label" class="form-label web_version_label">Web
                                Version</label>
                            <input type="text" id="web_version" name="web_version" class="form-control web_version">
                            <span class="text-primary web_version_error" id="web_version_error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-12 mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" id="logo-uploader" hidden onchange="logoUploader(event)"/>
                        <input type="hidden" id="logo">
                        <label for="logo-uploader" id="logo-uploader-label"
                               class="border-dashed cursor-pointer text-black-50 py-2 rounded  d-flex align-items-center">
                                    <span class="iconify mx-3" data-icon="ant-design:upload-outlined" data-width="20"
                                          data-height="20"></span>
                            <span id="upload-logo-text">
                                            Click here to upload logo
                            </span>

                        </label>
                        <img style="width: 30%; height: 220px; border-radius: 50%; margin: auto;" id="logoImgPreview" class="d-none my-3" src="" alt="">


                    </div>

                    <div class="col-lg-6 col-sm-12 col-12 mb-3">
                        <label for="logo-icon" class="form-label">Logo Icon</label>
                        <input type="file" id="logo-icon-uploader" hidden onchange="iconUploader(event)"/>
                        <input type="hidden" id="logo-icon" >
                        <label for="logo-icon-uploader"
                               class="border-dashed cursor-pointer text-black-50 py-2 rounded d-flex align-items-center">
                                    <span class="iconify mx-3" data-icon="ant-design:upload-outlined" data-width="20"
                                          data-height="20"></span>
                            <span id="upload-logo-icon-text">
                                Click here to upload logo icon
                            </span>

                        </label>

                        <img style="width: 30%; height: 220px; border-radius: 50%; margin: auto;" id="logoIconImgPreview" class="d-none my-3" src="" alt="">
                    </div>

                    <div class="col-lg-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="copyright" id="copyright_label" class="copyright_label form-label">Copyrights
                                *</label>
                            <input type="text" id="copyright" name="copyright" class="form-control copyright"   onchange="clearError(this)">
                            <span class="text-primary copyright_error" id="copyright_error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="email" id="email_label" class="form-label email_label">Mail Address *</label>
                            <input type="text" id="email" name="email" class="form-control email"   onchange="clearError(this)">
                            <span class="text-primary email_error" id="email_error"></span>
                        </div>
                    </div>
                </div>


                <div class="d-flex align-items-center">
                    <span class="portion-title">Social Account</span>

                    {{--                    <button class="btn btn-primary rounded-32 mx-3" data-bs-target="#socialModal" data-bs-toggle="modal">Add More Social Account</button>--}}
                </div>

                <div class="row my-3">
                    <div class="col-lg-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="text" id="facebook" name="social[facebook]" class="form-control">
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="text" id="twitter" name="social[twitter]" class="form-control">
                        </div>
                    </div>

                </div>


                <div class="d-flex align-items-center">
                    <span class="portion-title">Help</span>
                    <button class="btn btn-primary rounded-32 mx-3" id="addFaqButton">Add FAQ's</button>
                </div>

                <div class="row my-3" id="faqInputList">
                    <div class="col-lg-6 col-12 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" name="help[][question]" id="question" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="answer1" class="form-label">Answer</label>
                            <textarea type="text" name="help[][answer]" id="answer1" class="form-control"></textarea>
                        </div>
                    </div>
                </div>


                <span class="portion-title">Age Range</span>

                <div class="row my-3">
                    <div class="col-lg-6 col-12 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="min-age" class="form-label">Minimum</label>
                            <input type="text" name="age[min_age]" id="min-age" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="max-age" class="form-label">Maximum</label>
                            <input type="text" name="age[max_age]" id="max-age" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="d-flex align-items-center">
                    <span class="portion-title">Partner Site's</span>
                    <button class="btn btn-primary rounded-32 mx-3" id="addPartnerBtn">Add</button>
                </div>

                <div class="row my-3" id="partnerInputList">
                    <div class="col-lg-6 col-12 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="website-name" class="form-label">Website Name </label>
                            <input type="text" name="partner_site[][name]" id="website-name" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="website-url" class="form-label">Website URL </label>
                            <input type="text" name="partner_site[][url]" id="website-url" class="form-control">
                        </div>
                    </div>

                </div>

                <span class="portion-title">Legal Information</span>

                <div class="form-group my-3">
                    <label for="description" class="form-label">Web Description</label>
                    <textarea type="text" name="legal_information['description']" id="description"
                              class="form-control"></textarea>
                </div>

                <div class="form-group my-3">
                    <label for="about" class="form-label">About Us (About Company)</label>
                    <textarea type="text" name="legal_information['about']" id="about"
                              class="form-control"></textarea>
                </div>

                <div class="form-group my-3">
                    <label for="terms_of_use" class="form-label">Terms of Use</label>
                    <textarea type="text" name="legal_information['terms_of_use']" id="terms_of_use"
                              class="form-control"></textarea>
                </div>

                <div class="form-group my-3">
                    <label for="notice" class="form-label">Legal Notice</label>
                    <textarea type="text" name="legal_information['notice']" id="notice"
                              class="form-control"></textarea>
                </div>

                <div class="form-group my-3">
                    <label for="privacy_policy" class="form-label">Privacy Policy</label>
                    <textarea type="text" name="legal_information['privacy_policy']" id="privacy_policy"
                              class="form-control"></textarea>
                </div>

                <div class="form-group my-3">
                    <label for="refund_policy" class="form-label">Refund Policy</label>
                    <textarea type="text" name="legal_information['refund_policy']" id="refund_policy"
                              class="form-control"></textarea>
                </div>


                <button type="submit" class="btn btn-primary my-3">Save</button>
                <a href="{{url('/admin')}}" class="btn btn-outline-secondary my-3">Cancel</a>

            </form>
        </section>
    </main>

@endsection

@push('custom-js')
    <script>
        /**
         * Change the current page title
         * */
        window.location.pathname === '/admin/settings'? document.title = 'Dashboard | Settings' : ''




        function logoUploader(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'blog');

            let showURL = window.origin + '/api/image-uploader';
            $.ajax({
                url: showURL,
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: formData,

                beforeSend: function () {
                    $('#preloader').removeClass('d-none');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message)
                        $('#logo-uploader').text('change logo image')
                        $('#logoImgPreview').removeClass('d-none').attr('src', res.data)
                        $('#logo').val(res.data)
                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },
                complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        }

        function iconUploader(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'blog');

            let showURL = window.origin + '/api/image-uploader';
            $.ajax({
                url: showURL,
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: formData,
                beforeSend: function () {
                    $('#preloader').removeClass('d-none');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message)
                        $('#logo-uploader').text('change logo image')
                        $('#logoIconImgPreview').removeClass('d-none').attr('src', res.data)
                        $('#logo-icon').val(res.data)
                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },
                complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        }

        $(document).on('click', '#addPartnerBtn', function (e) {
            e.preventDefault();
            $('#partnerInputList').append(`
                    <div class="col-lg-6 col-12 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="website-name" class="form-label">Website Name </label>
                            <input type="text" name="partner_site[][name]" id="website-name" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="website-url" class="form-label">Website URL </label>
                            <input type="text" name="partner_site[][url]" id="website-url" class="form-control">
                        </div>
                    </div>
            `)
        })

        $(document).on('click', '#addFaqButton', function (e) {
            e.preventDefault();
            $('#faqInputList').append(`

                     <div class="col-lg-6 col-12 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" name="help[][question]" id="question" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="answer1" class="form-label">Answer</label>
                            <textarea type="text" name="help[][answer]" id="answer1" class="form-control"></textarea>
                        </div>
                    </div>
            `)
        })


        $('#settingForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data)

            let logoArr = []
            let logo = $('#logo').val()
            let logoIcon = $('#logo-icon').val()
            if(logo){
                logoArr.push({logo: logo})
            }

            if(logoIcon){
                logoArr.push({logo_icon: logoIcon})
            }

            formData.image = logoArr


            let url = form.attr('action');
            console.log(formData)

            $.ajax({
                type: "post",
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    toastr.success(response.message)

                    setTimeout(function () {
                        location.reload();
                    }, 1000);

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
                }
            });
        })

        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: window.origin + '/api/admin/setting/get-all',
                success: function success(response) {
                    if (response.status === 'success') {
                        response.data.forEach(item => {
                            Object.entries(item).forEach(value => {
                                $('#' + value[0]).val(value[1]);

                                // console.log(value[0])

                                if (value[0] === 'legal_information') {

                                    Object.entries(value[1]).forEach(item => {
                                        let id = item[0].replace(/["']/g, "")
                                        $('#' + id).val(item[1]);

                                    })
                                }

                                if (value[0] === 'age') {
                                    if(value[1]){
                                        $('#min-age').val(value[1].min_age)
                                        $('#max-age').val(value[1].max_age)
                                    }
                                }

                                if (value[0] === 'social') {
                                    Object.entries(value[1]).forEach(item => {
                                        let id = item[0].replace(/["']/g, "")
                                        $('#' + id).val(item[1]);
                                    })
                                }
                                if (value[0] === 'image') {
                                    if(value[1]){
                                        value[1].forEach(img=>{
                                            if(img.logo){
                                                $('#adminPanelLogo').attr('src', img.logo)
                                                $('#logo').val(img.logo)
                                                $('#logoImgPreview').removeClass('d-none').attr('src', img.logo)
                                            }

                                            if(img.logo_icon){
                                                $('#logo-icon').val(img.logo_icon)
                                                $('#logoIconImgPreview').removeClass('d-none').attr('src', img.logo_icon)
                                            }


                                        })
                                    }

                                }

                                if (value[0] === 'partner_site') {
                                    $('#partnerInputList').html(" ")
                                    value[1].forEach(item => {
                                        $('#partnerInputList').append(`
                                                    <div class="col-lg-6 col-12 col-sm-12">
                                                        <div class="form-group mb-3">
                                                            <label for="website-name" class="form-label">Website Name </label>
                                                            <input type="text" name="partner_site[][name]" id="website-name" value="${item.name ? item.name : '' }" class="form-control">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="website-url" class="form-label">Website URL </label>
                                                            <input type="text" name="partner_site[][url]" id="website-url" value="${item.url ? item.url :''}"  class="form-control">
                                                        </div>
                                                    </div>
                                            `)
                                    })
                                }

                                if (value[0] === 'help') {
                                    $('#faqInputList').html(" ")
                                    value[1].forEach(item => {
                                        $('#faqInputList').append(`
                                                    <div class="col-lg-6 col-12 col-sm-12">
                                                        <div class="form-group mb-3">
                                                            <label for="question" class="form-label">Question</label>
                                                            <input type="text" name="help[][question]" id="question" value="${item.question ? item.question : ''}" class="form-control">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="answer1" class="form-label">Answer</label>
                                                            <textarea type="text" name="help[][answer]" id="answer"  class="form-control">${item.answer ? item.answer : ""}</textarea>
                                                        </div>
                                                    </div>
                                            `)
                                    })
                                }
                            })
                        })
                    }

                },
                error: function error(xhr, resp, text) {
                    console.log(xhr, resp);
                }
            });
        })

        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }


    </script>
@endpush
