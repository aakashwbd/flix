<?php
    $currentControllerName = Request::segment(1);
    $currentFullRouteName = Route::getFacadeRoot()
        ->current()
        ->uri();
?>


@extends('layouts.landing.index')
@section('content')
    <div id="profile" class="profile">
        <div class="container">
            <ul class="nav nav-tabs justify-content-center border-0 bg-primary" id="profileNav" role="tablist">
                <li class="nav-item" role="presentation">
                    <button onclick="tabChangeHandler('information')" class="nav-link {{ ((request()->get('tab')) == "information") ? "active" : ''}}"
                            id="info-tab" data-bs-toggle="tab" data-bs-target="#information" type="button" role="tab"
                            aria-controls="home" aria-selected="true">Information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="tabChangeHandler('photos')" class="nav-link {{ ((request()->get('tab')) == "photos") ? "active" : ''}}" id="photos-tab"
                            data-bs-toggle="tab" data-bs-target="#photos" type="button" role="tab"
                            aria-controls="profile" aria-selected="false">Photos/videos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="tabChangeHandler('settings')" class="nav-link {{ ((request()->get('tab')) == "setting") ? "active" : ''}}"
                            id="setting-tab" data-bs-toggle="tab" data-bs-target="#setting"
                            type="button" role="tab" aria-controls="contact" aria-selected="false">Setting
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button onclick="tabChangeHandler('favorite')" class="nav-link {{ ((request()->get('tab')) == "favorite") ? "active" : ''}}"
                            id="favorite-tab" data-bs-toggle="tab" data-bs-target="#favorite"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Favorite
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="tabChangeHandler('block')" class="nav-link {{ ((request()->get('tab')) == "blacklist") ? "active" : ''}}"
                            id="blacklist-tab" data-bs-toggle="tab" data-bs-target="#blocklist"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Block List
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="tabChangeHandler('premium')" class="nav-link {{ ((request()->get('tab')) == "premium") ? "active" : ''}} "
                            id="premium-tab" data-bs-toggle="tab" data-bs-target="#premiumList"
                            type="button" role="tab" aria-controls="contact" aria-selected="false">Premium Access
                    </button>
                </li>
            </ul>
            <div class="tab-content bg-white" id="profileNavContent">
                <div class="tab-pane fade show {{ ((request()->get('tab')) == "information") ? "active" : ''}}"
                     id="information" role="tabpanel">
                    <form action="{{url('/api/auth/profile')}}" id="informationForm" class="text-white p-4">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label username_label" id="username_label"
                                           for="username">Username</label>
                                    <input class="form-control username" type="text" id="username" name="username"
                                           placeholder="Username">
                                </div>
                            </div>


                            <div class="col-lg-6 mb-3">
                                <div id="userPhone" class="d-none">
                                    <div class="form-group">
                                        <label class="form-label" id="phone_label" for="phone">Mobile</label>
                                        <input class="form-control" readonly type="text" id="phone" name="phone"
                                               placeholder="">
                                    </div>
                                </div>

                                <div id="userEmail" class="d-none">
                                    <div class="form-group">
                                        <label class="form-label" id="email_label" for="email">Email</label>
                                        <input class="form-control" readonly type="email" id="email" name="email"
                                               placeholder="">
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="birth_label" for="infoBirthYear">Birth Year</label>
                                    <select id="infoBirthYear" name="dob" class="form-select"></select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="city_label" for="address">City</label>
                                    <input class="form-control" type="text" id="address" name="address"
                                           placeholder="City">
                                </div>
                            </div>


                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="hiv_label" for="hiv">HIV Status</label>
                                    <select class="form-select" id="hiv" name="test">
                                        <option value="positive">Positive</option>
                                        <option value="negative">Negative</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="preference_label" for="preference">Preference</label>
                                    <select class="form-select" id="preference" name="preference">
                                        <option value="both">Host and/or Visitor</option>
                                        <option value="visitor">Visitor</option>
                                        <option value="host">Host</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="presentation">Your Presentation (optional)</label>
                                <textarea class="form-control" id="presentation" name="presentation"
                                          placeholder="Your Presentation (optional)"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 offset-lg-3 mb-3">
                            <div class="d-flex align-items-center">
                                <button type="button" onclick="cancleHandler()"
                                        class="btn btn-outline-secondary form-control text-capitalize me-2">cancel
                                </button>
                                <button type="submit" id="information-submit-button" class="btn btn-primary form-control text-capitalize">save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade show p-4 {{ ((request()->get('tab')) == "photos") ? "active" : ''}}"
                     id="photos" role="tabpanel">


                    <div class="row align-items-center p-2">
                        <div class="col-lg-2">
                            <img id="showImg" style="height: 200px; width: 100%"
                                 src=""
                                 alt="">
                        </div>

                        <div class="col-lg-2">
                            <div class="custom-file-upload mb-3">
                                <input type="file" id="image-uploader" hidden onchange="profileUploader(event)"/>
                                <input type="hidden" id="imgURL"/>
                                <label for="image-uploader"
                                       class="px-4 py-2 text-white text-uppercase fw-bold d-flex align-items-center justify-content-center">
                                    <span class="iconify me-3" data-icon="fluent:add-12-filled" data-width="20"
                                          data-height="20"></span>
                                    add
                                </label>
                            </div>

                            <button id="editButton"
                                    class="btn btn-primary form-control p-2 text-uppercase fw-bold mb-3 d-none">edit
                            </button>
                            <button id="removeButton"
                                    class="btn btn-primary form-control p-2 text-uppercase fw-bold d-none">delete
                            </button>
                        </div>
                    </div>

                    <div class="gallery my-3">
                        <span class="text-capitalize">photos/videos gallery</span>

                        <div class="row cloneContainer"></div>

                    </div>

                    {{--                    <div class="gallery my-3">--}}
                    {{--                        <span class="text-capitalize">private photos/videos (for chat use)</span>--}}
                    {{--                        <div class="row cloneContainer"></div>--}}
                    {{--                    </div>--}}
                </div>

                <div class="tab-pane fade show p-4 {{ ((request()->get('tab')) == "setting") ? "active" : ''}}"
                     id="setting" role="tabpanel">
                    <form action="" class="text-white p-4">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="alert_email_label" for="alert_email">
                                        Alert by email in case of a message:
                                    </label>
                                    <select
                                        id="alert_by_email"
                                        name="alert_by_email"
                                        class="form-select"
                                        onchange="profileSettingHandler(this)"
                                    >
                                        <option value="week">Once a week</option>
                                        <option value="month">Once a month</option>
                                        <option value="everyday">Everyday</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="premium_status_label" for="premium_status">
                                        Premium status
                                        <span class="iconify" data-icon="mdi:chess-queen" data-width="20"
                                              data-height="20"></span>
                                        :
                                    </label>
                                    <select
                                        id="premium_status"
                                        name="premium_status"
                                        class="form-select"
                                        onchange="profileSettingHandler(this)"
                                    >
                                        <option value="hide">Hide my status</option>
                                        <option value="show">Show everyone</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="premium_status_label" for="reminder_message">
                                        Reminder message after 1 month absence :</label>
                                    <select
                                        id="reminder_message"
                                        name="reminder_message"
                                        class="form-select"
                                        onchange="profileSettingHandler(this)"
                                    >
                                        <option value="agree">I agree to be connected again by email</option>
                                        <option value="disagree">I disagree to be connected again by email</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="colorblind_mode_label" for="colorblind_mode">
                                        Colorblind mode :
                                    </label>
                                    <select
                                        id="colorblind_mode"
                                        name="colorblind_mode"
                                        class="form-select"
                                        onchange="profileSettingHandler(this)"
                                    >
                                        <option value="enabled">Enable</option>
                                        <option value="disabled">Disable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="premium_status_label" for="exhibits_notification">
                                        Exhibits notifications in the menu :
                                    </label>
                                    <select
                                        id="exhibits_notification"
                                        name="exhibits_notification"
                                        class="form-select"
                                        onchange="profileSettingHandler(this)"
                                    >
                                        <option value="enabled">Enable</option>
                                        <option value="disabled">Disable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" id="premium_status_label"
                                           for="languages">Language :</label>
                                    <select
                                        id="languages"
                                        name="language"
                                        class="form-select"
                                        onchange="profileSettingHandler(this)"
                                    ></select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label
                                        class="form-label"
                                        id="premium_status_label"
                                        for="premium_status"

                                    >
                                        Sound notifications</label>
                                    <select
                                        id="sound_notification"
                                        name="sound_notification"
                                        class="form-select"
                                        onchange="profileSettingHandler(this)"
                                    >
                                        <option value="enabled">Enable</option>
                                        <option value="disabled">Disable</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-5">


                        </div>

                    </form>
                    <div class="col-lg-6 offset-lg-3 mb-3">
                        <div class="d-flex align-items-center">
                            <button
                                data-bs-toggle="modal"
                                data-bs-target="#suspendModal"
                                class="btn btn-outline-secondary form-control text-capitalize me-2"
                            >
                                Suspend My Account
                            </button>

                            <button

                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                class="btn btn-primary form-control text-capitalize"
                            >
                                Delete My Account
                            </button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show p-4 {{ ((request()->get('tab')) == "favorite") ? "active" : ''}}"
                     id="favorite" role="tabpanel">
                    <div class="row" id="favouriteListShow">

                    </div>

                </div>
                <div class="tab-pane fade show p-4 {{ ((request()->get('tab')) == "blacklist") ? "active" : ''}}"
                     id="blocklist" role="tabpanel">
                    <div class="row" id="blockListShow">

                    </div>
                </div>

                <div class="tab-pane fade show p-4 {{ ((request()->get('tab')) == "premium") ? "active" : ''}} "
                     id="premiumList" role="tabpanel">
                    <div class="container">
                        <div class="card">
                            <div class="card-header">
                                <h6>Payment By Credit</h6>
                                <span class="text-black-50" id="premiumPackageHeading">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita, nostrum!</span>
                            </div>

                            <div class="card-body">
                                <div id="premiumPackageList"></div>
                                <div class="text-center">
{{--                                    <p class="my-2" id="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga,--}}
{{--                                        nam.</p>--}}
                                    <button id="premiumPackageOfferButton" class="btn btn-primary w-25">Submit</button>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="suspendModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="">Are you sure you want to suspend?</h6>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, nemo.</span>

                        <div class="my-4">
                            <button
                                data-bs-dismiss="modal"
                                class="btn btn-outline-secondary me-2"
                            >
                                Cancel
                            </button>
                            <button
                                onclick="applySuspendHandler()"
                                class="btn btn-primary me-2"
                            >
                                Submit
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="">Permanently delete your account</h6>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, nemo.</span>

                        <div class="my-4">
                            <button
                                data-bs-dismiss="modal"
                                class="btn btn-outline-secondary me-2"
                            >
                                Cancel
                            </button>
                            <button
                                onclick="applyDeleteAccountHandler()"
                                class="btn btn-primary me-2"
                            >
                                Submit
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="packageOfferModal" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="text-capitalize">Payment: </h6>
                </div>
                <div class="modal-body">

                    <span id="modal-package-name4"></span>
                    <h6 id="modal-package-price4"></h6>

                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-js')
    <script
        src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}&currency={{env('PAYPAL_CURRENCY')}}"></script>

    <script>


        tabChangeHandler = function (tab){
            if(tab === 'information'){
                location.href = window.origin + '/profile?tab=information'
            }


            if(tab === 'photos'){
                location.href = window.origin + '/profile?tab=photos'
            }

            if(tab === 'settings'){
                location.href = window.origin + '/profile?tab=setting'
            }

            if(tab === 'favorite'){
                location.href = window.origin + '/profile?tab=favorite'
            }

            if(tab === 'favorite'){
                location.href = window.origin + '/profile?tab=favorite'
            }

            if(tab === 'block'){
                location.href = window.origin + '/profile?tab=blacklist'
            }

            if(tab === 'premium'){
                location.href = window.origin + '/profile?tab=premium'
            }
        }



        let token = localStorage.getItem('accessToken')


        /***
         * Fetch all languages for user can change his languages
         */
        Object.entries(isoLangs).forEach(item => {
            $('#languages').append(`
                <option value='${item[1].nativeName}'>${item[1].nativeName}</option>
            `)
        })


        /***
         * The function is active when user want to his account in suspend mode
         */
        function applySuspendHandler() {
            $.ajax({
                url: window.origin + '/api/auth/profile/settings/suspend',
                type: 'patch',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                success: function (res) {
                    toastr.success(res.message)
                    localStorage.removeItem('accessToken')
                    localStorage.removeItem('user')
                    setTimeout(function () {
                        window.location.href = window.origin
                    }, 1000)
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });
        }

        /***
         * The function is active when user want to permanently delete his account
         */
        function applyDeleteAccountHandler() {
            $.ajax({
                url: window.origin + '/api/auth/profile/settings/delete',
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                success: function (res) {
                    toastr.success(res.message)
                    localStorage.removeItem('accessToken')
                    localStorage.removeItem('user')

                    setTimeout(function () {
                        window.location.href = window.origin
                    }, 1000)
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });
        }

        /***
         * The function is active when user want to change his profile settings
         */
        function profileSettingHandler(input) {
            $.ajax({
                url: window.origin + '/api/auth/profile/settings',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                data: {
                    [input.name]: input.value
                },
                success: function (res) {
                    toastr.success(res.message)
                    location.reload()
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });
        }

        $(document).ready(function () {
            $.ajax({
                url: window.origin + '/api/auth/profile/settings',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                success: function (res) {

                    if (res.status === 'success') {
                        $('#alert_by_email').val(res.data.alert_by_email)
                        $('#premium_status').val(res.data.premium_status ? res.data.premium_status : "hide")
                        $('#colorblind_mode').val(res.data.colorblind_mode ? res.data.colorblind_mode : 'enabled')
                        $('#exhibits_notification').val(res.data.exhibits_notification ? res.data.exhibits_notification : "enabled")
                        $('#reminder_message').val(res.data.reminder_message ? res.data.reminder_message : 'enabled')
                        $('#languages').val(res.data.language ? res.data.language : 'english')
                        $('#sound_notification').val(res.data.sound_notification ? res.data.sound_notification : 'enabled')
                    }
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });
        })

        function cancleHandler() {
            location.href = window.origin
        }

        function profileUploader(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let token = localStorage.getItem('accessToken')

            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'profile');


            $.ajax({
                url: window.origin + '/api/image-uploader',
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

                    $('#showImg').attr('src', res.data)
                    formData.append('image', res.data);
                    $.ajax({
                        url: window.origin + '/api/auth/profile',
                        type: 'POST',
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Authorization': token
                        },
                        data: formData,
                        success: function (res) {
                            toastr.success(res.message)
                            location.reload()

                            localStorage.removeItem("user")
                            localStorage.setItem(
                                "user",
                                JSON.stringify(res.user)
                            );
                        },
                        error: function (jqXhr, ajaxOptions, thrownError) {
                            console.log(jqXhr)
                        }
                    });
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },
                complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        }


        $(document).ready(function () {
            for (let step = 1; step <= 5; step++) {
                cloneUploadContainer('cloneContainer', step)
                if (step === 5) {
                    $('.cloneContainer').append(`
                            <div class="col-lg-2 col-sm-4 col-12 my-2 ">
                                <button class="btn form-control btn-primary" onclick="loadMore()">More</button>
                            </div>
                    `)
                }
            }


            function cloneUploadContainer(contentID, step) {
                $('.' + contentID).append(`
                    <div class="col-lg-2 col-sm-4 col-12 my-2 ">
                      <div class="gallery-item">
                          <video style="width: 100%; height: 100%" class="d-none"  id="videoPriview${step}" src=""></video>

                           <img class="d-none imagePreview" id="imagePriview${step}" src="" alt="">

                           <span class="iconify icon dropdown" data-bs-toggle="dropdown"
                                    data-icon="fluent:add-circle-24-filled" data-width="25"
                                    data-height="25"></span>

                          <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-item border-bottom">
                                <input id="image-uploader${step}" type="file" hidden
                                       onchange="fileUploadHandler(event, 'image', 'imageURL${step}', 'imagePriview${step}', 'uploadForm${step}', 'image_previewer${step}')">
                                <label for="image-uploader${step}" class="cursor-pointer">Upload a Photo</label>
                            </li>

                            <li class="dropdown-item border-bottom">
                                <input id="video-uploader${step}" type="file" hidden
                                       onchange="fileUploadHandler(event, 'video','videoURL${step}', 'videoPriview${step}', 'uploadForm${step}', 'video_previewer${step}')">
                                <label for="video-uploader${step}" class="cursor-pointer">Upload a
                                    Video</label>
                            </li>
                            <li class="dropdown-item">
                                <span class="cursor-pointer">Cancel</span>
                            </li>
                        </ul>
                       </div>
                        <form id="uploadForm${step}" onsubmit="fileUploadForm(event, ${step})" class="uploadForm d-none my-2">
                            <input type="hidden" id="videoURL${step}" class="videoURL" name="video">
                            <input type="hidden" id="imageURL${step}" class="imageURL" name="image">


                            <input type="hidden" id="image_previewer${step}" class="image_previewer" >
                            <input type="hidden" id="video_previewer${step}" class="video_previewer" >

                            <input type="hidden" id="privacyValue"  name="privacy">

                            <div class="form-check mb-3">
                              <input class="form-check-input p-0" type="checkbox" value="" id="privacy">
                              <label class="form-check-label" for="privacy">
                                Make Private
                              </label>
                            </div>
                            <button type="submit" id='video-submit-button' class="btn btn-primary form-control p-1 rounded">save</button>
                        </form>
                    </div>
                `)

                let i = 0

                loadMore = function () {
                    ++i;
                    cloneUploadContainer('cloneContainer', i)
                }


                fileUploadHandler = function (event, filetype, fileUrl, filePreviewer, submitForm, formFileViewer){
                    // console.log(event, filetype, fileUrl, filePreviewer, submitForm)
                    event.preventDefault();
                    let file = event.target.files[0];

                    let formData = new FormData();
                    formData.append("file", file);
                    formData.append("folder", filetype);

                    $.ajax({
                        url: window.origin + "/api/image-uploader",
                        type: "POST",
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: formData,
                        beforeSend: function () {
                            $('#preloader').removeClass('d-none');
                        },
                        success: function (res) {

                            $("#" + fileUrl).val(res.data);

                            $("#" + formFileViewer).val(filePreviewer);

                            $("#" + filePreviewer).removeClass("d-none").attr("src", res.data);

                            $("#" + submitForm).removeClass("d-none");

                            toastr.success("File Upload successfully");

                        },
                        error: function (jqXhr, ajaxOptions, thrownError) {
                            console.log(jqXhr);
                        },
                        complete: function (xhr, status) {
                            $('#preloader').addClass('d-none');
                        },
                    });

                }
            }


            let getUser = localStorage.getItem('user')
            let user = JSON.parse(getUser)

            $('#username').val(user.username)

            if (user && user.email) {
                $('#userEmail').removeClass('d-none')
                $('#email').val(user.email)
            }
            if (user && user.phone) {
                $('#userPhone').removeClass('d-none')
                $('#phone').val(user.phone)
            }

            $('#infoBirthYear').val(user.dob)
            $('#address').val(user.address)
            $('#presentation').val(user.presentation)

            $('#showImg').attr('src', user.image ? user.image : window.origin + '/asset/image/default.jpg')
        })

        $('#informationForm').submit(function (e) {
            e.preventDefault();
            let accessToken = localStorage.getItem('accessToken')

            let form = $(this);

            let url = form.attr("action");

            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data);

            $.ajax({
                type: 'post',
                url: url,
                data: formData,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': accessToken
                },
                beforeSend: function () {
                    $('#information-submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {
                    toastr.success(response.message)
                    location.reload()
                    localStorage.removeItem('user')
                    localStorage.setItem('user', JSON.stringify(response.user))
                }, error: function (xhr, resp, text) {
                    console.log(resp)
                },
                complete: function (xhr, status) {
                    $('#information-submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }

            });
        })

        $('#uploadForm').submit(function (e) {
            let token = localStorage.getItem('accessToken')
            e.preventDefault();
            let form = $(this);
            formSubmit("post", form, token);
        })

        $(document).on('click', '#privacy', function () {
            let x = $(this).prop('checked')

            if (x === true) {
                $('#privacyValue').val('private')
            }
        })


        function fileUploadForm(event, step) {
            event.preventDefault()

            let videoURL = $('#videoURL'+step).val()
            let imageURL = $('#imageURL'+step).val()
            let videoPreviewer = $('#video_previewer'+step).val()
            let imagePreviewer = $('#image_previewer'+step).val()
            let privacy = $('#privacyValue').val()



            // let constant = {
            //     token: localStorage.getItem('accessToken'),
            //     videoURL: document.querySelector('.videoURL').value,
            //     imageURL: document.querySelector('.imageURL').value,
            //     imagePreviewer: document.querySelector('.image_previewer').value,
            //     videoPreviewer: document.querySelector('.video_previewer').value,
            //     privacy: document.querySelector('#privacyValue').value,
            //     fileUploadURL: '/api/file/store',
            // }
            //
            let formData = new FormData();

            if(videoURL){
                formData.append('video', videoURL)
            }
            if(imageURL){
                formData.append('image', imageURL)
            }
            if(videoPreviewer){
                formData.append('video_previewer', videoPreviewer)
            }
            if(imagePreviewer){
                formData.append('image_previewer', imagePreviewer)
            }
            if (privacy === '') {
                formData.append('privacy', 'public')
            } else {
                formData.append('privacy', privacy)
            }

            $.ajax({
                type: 'POST',
                url: window.origin + '/api/file/store',
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },  beforeSend: function () {
                    $('#video-submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },

                success: function (response) {
                    toastr.success(response.message)
                    location.reload()
                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                }
                ,
                complete: function (xhr, status) {
                    $('#video-submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        }

        $(document).ready(function (){
            $.ajax({
                type: 'GET',
                url: window.origin + '/api/file/fetch-all',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if(response.status === 'success' && response.data.length > 0){
                        response.data.forEach(item =>{
                           // console.log(item)

                            if(item.image && item.image_preview){
                                $('#' + item.image_preview).removeClass('d-none').attr('src', item.image)
                            }

                            if(item.video && item.video_preview){
                                $('#' + item.video_preview).removeClass('d-none').attr('src', item.video)
                            }


                        })
                    }

                   console.log(response)
                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                }
            });
        })

        $(document).ready(function () {
            let token = localStorage.getItem('accessToken')
            $.ajax({
                type: 'GET',
                url: window.origin + '/api/favourite',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                success: function (response) {
                    favouriteList(response)
                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                }
            });
        })

        $(document).ready(function () {
            let token = localStorage.getItem('accessToken')
            $.ajax({
                type: 'GET',
                url: window.origin + '/api/block',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                success: function (response) {
                    blockList(response)
                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                }
            });
        })

        function favouriteList(res) {
            if(res.data.length > 0){
                res.data.forEach(item => {
                    $('#favouriteListShow').append(`
                    <div class="col-lg-6 col-12 col-sm-12 mb-3">
                            <div class="d-flex border-bottom p-2">
                                <img class="avatar-sm" src="${item.favourite_user.image ? item.favourite_user.image : window.origin + "/asset/image/default.jpg"}" alt="">
                                <div class="ms-3">
                                   <h6>${item.favourite_user.username ? item.favourite_user.username : ""}</h6>
                                   <span>${item.favourite_user.address ? item.favourite_user.address : ""}</span>
                                   <p>${item.favourite_user.age ? item.favourite_user.age + 'y.o' : ''}</p>

                                </div>
                            </div>
                        </div>
                `)
                })

            }else{
                $('#favouriteListShow').append(`
                    <div class="alert alert-warning text-center">
                            Use
                            <span class="iconify" data-icon="carbon:favorite" data-width="20" data-height="20"></span>
                            button
                            <br/>
                            to save your favorites

                    </div>

                `)
            }

        }

        function blockList(res) {
            if(res.data.length > 0){
                res.data.forEach(item => {
                    $('#blockListShow').append(`
                    <div class="col-lg-6 col-12 col-sm-12 mb-3">
                            <div class="d-flex border-bottom p-2">
                                <img class="avatar-sm" src="${item.block_user.image ? item.block_user.image : window.origin + "/asset/image/default.jpg"}" alt="">
                                <div class="ms-3">
                                   <h6>${item.block_user.username ? item.block_user.username : ''}</h6>
                                   <span>${item.block_user.address ? item.block_user.address : ''}</span>
                                   <p>${item.block_user.age ? item.block_user.age + 'y.o' : ''}</p>

                                </div>
                            </div>
                        </div>
                `)
                })
            }else{
                $('#blockListShow').append(`
                    <div class="alert alert-warning text-center">
                            Use
                            <span class="iconify" data-icon="akar-icons:block" data-width="20" data-height="20"></span>
                            button
                            <br/>
                            to save your block list

                    </div>

                `)
            }

        }


        let packageId = null
        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: window.origin + '/api/admin/invite-code/get-by-user',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                success: function (response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(item => {

                            $('#premiumPackageList').append(`
                                 <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                    <div class="form-check">

                                        <input class="form-check-input p-0 rounded-circle" type="radio" value='{"price": ${item.price}, "package_id": ${item.package.id}}' name="package_id" id="package${item.id}">

                                        <label class="form-check-label align-items-center" for="flexRadioDefault1">
                                            <span class="text-tweeter fw-bold">${item.price ? item.price + '$ / ' : ''} ${item.duration ? item.duration + ' month ' : ''}</span>
                                            <br>
                                            <span class="fw-lighter text-black-50">${item.package.name ? item.package.name : ''}</span>
                                        </label>
                                    </div>
                                    <span class="bg-warning p-2">${item.reduction ? item.reduction + ' % reduction' : ''}</span>
                                </div>
                            `)
                        })
                    }else{
                        $('#premiumPackageOfferButton').hide()

                        $('#premiumPackageHeading').html(`
                            <span>
                                    For premium access don't forget to bye <a href="{{url('/package')}}" class="text-decoration-underline">visit</a> our packages

                            </span>

                        `)

                        //
                    }
                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                }
            });
        })


        $(document).on('click', '#premiumPackageOfferButton', function () {
            let value = $("input[name='package_id']:checked").val();
            let packageInfo = JSON.parse(value);
            let price = packageInfo.price
            // console.log(packageInfo.price)


            $('#packageOfferModal').modal('show')

            const paypalButtonsComponent = paypal.Buttons({
                style: {
                    color: "gold",
                    shape: "rect",
                    layout: "vertical"
                },

                createOrder: (data, actions) => {
                    const createOrderPayload = {
                        intent: "CAPTURE",
                        purchase_units: [
                            {
                                reference_id: "REFID-000-1001",
                                amount: {
                                    value: price
                                }

                            }
                        ],
                    };

                    return actions.order.create(createOrderPayload);
                },

                onApprove: (data, actions) => {
                    const captureOrderHandler = (details) => {
                        // let token = localStorage.getItem('accessToken')
                        // let list = JSON.parse(packageList)
                        // $.ajax({
                        //     url: window.origin + '/api/checkout',
                        //     type: 'POST',
                        //     data: list,
                        //     headers: {
                        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        //         'Authorization': token
                        //     },
                        //     success: function (res) {
                        //         console.log(res)
                        //     }, error: function (jqXhr, ajaxOptions, thrownError) {
                        //         console.log(jqXhr)
                        //     }
                        // });
                    };
                    return actions.order.capture().then(captureOrderHandler);
                },
                onError: (err) => {
                    console.error('An error prevented the buyer from checking out with PayPal');
                }
            });

            paypalButtonsComponent
                .render("#paypal-button-container")
                .catch((err) => {
                    console.error('PayPal Buttons failed to render');
                });
        })


        /**
         * Change the current page title
         * */
        let currentPath = window.location.search

        currentPath === '?tab=information' ? document.title = 'Profile | Information' : ''
        currentPath === '?tab=photos' ? document.title = 'Profile | Gallery' : ''
        currentPath === '?tab=setting' ? document.title = 'Profile | Settings' : ''
        currentPath === '?tab=favorite' ? document.title = 'Profile | Favourites' : ''
        currentPath === '?tab=blacklist' ? document.title = 'Profile | Blacklists' : ''
        currentPath === '?tab=premium' ? document.title = 'Profile | Premium Status' : ''

    </script>

@endpush
