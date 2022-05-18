@extends('layouts.landing.index')
@section('content')
    <div class="container content-config">
        <div id="specificProfile"></div>
    </div>


    <div class="modal fade" id="testimonialModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6>Add a new testimony</h6>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem, neque.</span>
                    </div>

                    <form action="{{url('api/testimony/store')}}" id="testimonyForm">
                        <div class="form-group mb-3">
                            <input type="hidden" id="testimonyUserId" name="testimony_user_id">
                            <input onchange="clearError(this)" type="text" id="description" name="description"
                                   class="form-control testimony h-25 description"
                                   placeholder="Write your testimony...">
                            <span class="text-danger description_error" id="description_error"></span>
                        </div>

                        <button type="submit" id="submit-button" class="btn btn-primary mb-3">Submit</button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary mb-3">Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-js')
    <script>
        /**
         * GET USER INFO
         ***/
        let currentURL = window.location.href
        let splitURL = currentURL.split('/')
        let userID = splitURL[5]

        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: window.origin + '/api/member/profile/' + userID,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $('#testimonyUserId').val(res.data.id)

                        let date = new Date();
                        let currentDate = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + date.getFullYear()
                        let getDate = new Date(res.data.created_at);
                        let createdDate = ((getDate.getMonth() > 8) ? (getDate.getMonth() + 1) : ('0' + (getDate.getMonth() + 1))) + '-' + ((getDate.getDate() > 9) ? getDate.getDate() : ('0' + getDate.getDate())) + '-' + getDate.getFullYear()

                        let preference = ''
                        if (res.data.preference) {
                            if (res.data.preference === 'both') {
                                preference = 'visit/host'
                            } else {
                                preference = res.data.preference
                            }
                        }
                        $('#specificProfile').append(`
                            <div class="row bg-primary p-2">
                                <div class="col-lg-1">
                                    <span class="text-white"></span>
                                </div>
                                <div class="col-lg-11 ">
                                    <div class="text-center">
                                        <span class="text-white fw-bold">${res.data.username ? res.data.username : ''}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row bg-white p-3">
                                <div class="col-lg-1 col-sm-1 col-3">
                                    <img  class="avatar-sm-1 profile__image"
                                         src="${res.data.image ? res.data.image : window.origin + '/asset/image/default.jpg'}"
                                         alt="">
                                </div>
                                <div class="col-lg-8 col-sm-6 col-6">
                                    <div class="d-flex align-items-center">
                                        ${res.data.address ? (`
                                            <span class="iconify me-2 text-primary" data-icon="entypo:location" data-width="20"
                                                          data-height="20"></span>
                                            <span>${res.data.address}</span>
                                            <span class="mx-3">|</span>

                                        `) : ""}

                                          ${currentDate > createdDate ? '' : (`
                                            <span class="iconify text-danger" data-icon="clarity:new-solid" data-width="20" data-height="20"></span>
                                          `)}
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <span class="iconify text-success me-3" data-icon="ci:dot-03-m" data-width="30"
                                              data-height="30"></span>
                                        <span class="me-2">${res.data.username ? res.data.username : ""}</span>
                                        <span class="me-2">${res.data.age ? res.data.age + 'y.o' : ''}</span>
                                        <span>${preference}</span>
                                    </div>

                                    <span>${res.data.presentation ? res.data.presentation : ''}</span>
                                </div>

                                <div class="col-lg-11 offset-lg-1" id="testimonyList">
                                    <div class="d-flex align-items-center justify-content-between border-top border-bottom py-3">
                                        <div>
                                            <span class="iconify" data-icon="bx:message-alt-detail" data-width="20" data-height="20"></span>
                                            <span id="testimonyCount"></span>
                                            Testimony
                                        </div>
                                        <button class="btn btn-outline-secondary" data-bs-target='#testimonialModal' data-bs-toggle='modal'>Add testimony</button>
                                    </div>
                                </div>
                            </div>

                        `)
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        })


        $('#testimonyForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let token = localStorage.getItem('accessToken')

            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data);


            let url = form.attr("action");

            $.ajax({
                type: "POST",
                url: url,
                data: formData,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": token,
                },
                beforeSend: function () {

                    $('#preloader').removeClass('d-none');
                    $('#submit-button').prop('disabled', true);
                },
                success: function (res) {
                    toastr.success(res.message)
                    location.reload()

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
                    $('#submit-button').prop('disabled', false);
                }
            })
        })

        clearError = function (input) {
            $("#" + input.id).removeClass("is-invalid");
            $("#" + input.id + "_label").removeClass("text-danger");
            $("#" + input.id + "_icon").removeClass("text-danger");
            $("#" + input.id + "_icon_border").removeClass("field-error");
            $("#" + input.id + "_error").html("");
        };

        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: window.origin + '/api/testimony/' + userID,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {
                    if (res.status === 'success' && res.data.length > 0) {
                        $('#testimonyCount').text(res.count)
                        res.data.forEach((item) => {
                            $('#testimonyList').append(`
                                    <ul>
                                        <li class="d-flex my-2">
                                            <img  class="avatar-sm-1 profile__image"
                                                  src="${item.user.image ? item.user.image : window.origin + '/asset/image/default.jpg'}"
                                                  alt="">

                                            <div class="mx-2">
                                                <h6>${item.user.username ? item.user.username : ""} ${item.user.age ? " | " + item.user.age + "y. o." : ""}</h6>
                                                <span>${item.description ? item.description : ""}</span>
                                            </div>
                                        </li>
                                    </ul>
                            `)
                        })

                    } else {
                        $('#testimonyCount').text('No')
                        $('#testimonyList').append(`
                            <p class="text-center my-2"> No one posted any testimony yet.</p>
                        `)

                    }

                },
                error: function (err) {
                    console.log(err)
                }
            })
        })
    </script>
@endpush


