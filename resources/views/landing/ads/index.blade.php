@extends('layouts.landing.index')
@section('content')
    <div class="container content-config">
        <div id="searchBannerImg">
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-12 order-sm-2 order-lg-1 mb-3">
                    <div class="row">
                        <div class="col-lg-10 col-12 offset-lg-1">
                            <button class="btn btn-primary mb-3" onclick="showLoginForm('placeButton')"
                                    id="advertisementButton">Place your advertisement
                            </button>
                            <h6 class="text-white text-capitalize">filter ads:</h6>
                            <form action="{{url('/api/news/search')}}" id="newsSearchForm">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="address" class="form-control mb-3"
                                               placeholder="Search Location">
                                    </div>
                                    <div class="col-lg-12">
                                        <select name="preference" class="form-select mb-3">
                                            <option value="" selected>Select preference</option>
                                            <option value="both">Who Hosts and/or Visits</option>
                                            <option value="host">Who Hosts</option>
                                            <option value="visitor">Who Visits</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-flex align-items-center justify-content-center mb-3">
                                            <input type="text" class="form-control" name="min_age" placeholder="10">
                                            <label class="text-capitalize mx-3 text-white">to</label>
                                            <input type="text" class="form-control" name="max_age" placeholder="49">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" name="presentation" class="form-control mb-3"
                                               placeholder="keyword">
                                    </div>

                                    <div class="col-lg-12">
                                        <select name="member" class="form-select mb-3">
                                            <option value="" selected>The Closest</option>
                                            <option value="online">Online Members</option>
                                            <option value="recent">Recent Members</option>
                                        </select>
                                    </div>
                                </div>
                                <button id="place-search-submit-button" class="btn btn-primary form-control mb-3">
                                    search
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-sm-12 order-sm-1 order-lg-2 mb-3">
                    <img class="bannerImg"
                         src=""
                         alt="">
                </div>
            </div>
        </div>

        <div id="adsResultDiv"
             class="d-none py-2 my-5 bg-primary text-white d-flex align-items-center justify-content-center">
            {{--                <span class="iconify me-5 cursor-pointer" data-icon="ant-design:reload-outlined" data-width="20"--}}
            {{--                      data-height="20"></span>--}}
            <span id="adSearchlistheading"></span>
            {{--            <span class="iconify ms-5 cursor-pointer" data-icon="ep:close" data-width="20" data-height="20"></span>--}}
        </div>
        <div class="row" id="placeList">

        </div>

        <div class="modal" id="placeModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-bottom justify-content-center">
                        <h6>Place an your new advertisement</h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('api/place/store')}}" id="placeForm">
                            <div class="text-center">
                                <span>Your ad will expire in</span>

                                <div class="d-flex align-items-center justify-content-center my-2">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" value="month" name="duration"
                                               id="month">
                                        <label class="form-check-label" for="month">
                                            1 month
                                        </label>
                                    </div>

                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" value="week" name="duration"
                                               id="week">
                                        <label class="form-check-label" for="week">
                                            1 week
                                        </label>
                                    </div>

                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" value="hour" name="duration"
                                               id="hour">
                                        <label class="form-check-label" for="hour">
                                            24 hours
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="title" class="form-label title_label" id="title_label">Message title</label>
                                <input type="text" id="title" name="title" class="form-control title"
                                       placeholder="Message title" onchange="clearError(this)">
                                <span class="text-danger title_error" id="title_error"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="address" class="form-label address_label"
                                       id="address_label">Location</label>
                                <input type="text" id="address" name="address" class="form-control address"
                                       placeholder="Location" onchange="clearError(this)">
                                <span class="text-danger address_error" id="address_error"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label description_label" id="description_label">Description</label>
                                <textarea name="description" id="description" placeholder="Description"
                                          class="form-control description" onchange="clearError(this)"></textarea>
                                <span class="text-danger description_error" id="description_error"></span>
                            </div>


                            <div>
                                <label for="" class="form-label">Advertisement image</label>

                                <input type="hidden" name="image" id="placeImageURL">

                                <img style="width: 100%; height: 200px;" class=" d-none my-3" id="imagePreview" src=""
                                     alt="">

                                <input type="file" id="file-uploader" hidden name="image"
                                       onchange="placeImgUpload(event)"/>

                                <label for="file-uploader"
                                       class="d-flex form-control w-100 border-dashed align-items-center cursor-pointer">
                                    <span class="iconify me-3" data-icon="fa-solid:camera" data-width="20"
                                          data-height="20"></span>
                                    Click here to upload image
                                </label>
                            </div>

                            <button type="submit" id="submit-button" class="btn btn-primary my-3">Save</button>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-3">
                                Cancel
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>






    {{--    <div class="modal fade" id="commentModal" data-bs-keyboard="false" tabindex="-1">--}}
    {{--        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header justify-content-center">--}}
    {{--                    <h6 class="text-capitalize">Ad Comment</h6>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    <div class="form-group">--}}
    {{--                        <input type="text" name="comment" class="form-control " placeholder="Write Your Comment">--}}
    {{--                        <span class="locationError text-danger d-none">Please select your city</span>--}}
    {{--                    </div>--}}
    {{--                    <div class="text-center my-3">--}}
    {{--                        <button id="location-btn" class="btn btn-primary w-75  form-control">Submit</button>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection

@push('custom-js')
    <script>
        let token = localStorage.getItem('accessToken')

        function showLoginForm(buttonName) {
            if (buttonName) {
                if (token) {
                    $('#placeModal').modal('show')
                } else {
                    $('#loginModal').modal('show')
                }
            }
        }


        function placeImgUpload(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'place');

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
                    $('#submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },


                success: function (res) {

                    if (res.status === 'success') {
                        toastr.success(res.message)
                        $('#imagePreview').removeClass('d-none').attr('src', res.data)
                        $('#placeImageURL').val(res.data)

                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },
                complete: function (xhr, status) {
                    $('#submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        }

        function editPlaceImgUpload(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'place');

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
                    $('#update-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },


                success: function (res) {

                    if (res.status === 'success') {
                        toastr.success(res.message)
                        $('#editImagePreview').removeClass('d-none').attr('src', res.data)
                        $('#editPlaceImageURL').val(res.data)

                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },
                complete: function (xhr, status) {
                    $('#update-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        }

        $('#placeForm').submit(function (e) {
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
                    "Authorization": token,
                },
                beforeSend: function () {
                    $('#submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {
                    toastr.success(response.message)
                    location.reload()

                },
                error: function (xhr, resp, text) {

                    if (xhr && xhr.responseJSON) {
                        let response = xhr.responseJSON;
                        if (response.status && response.status === "validate_error") {
                            $.each(response.message, function (index, message) {
                                $("." + message.field).addClass("is-invalid");
                                $("." + message.field + "_label").addClass("text-danger");
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
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }


        $('#newsSearchForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let token = localStorage.getItem('accessToken')
            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data)


            let url = form.attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                }
                ,
                beforeSend: function () {
                    $('#preloader').removeClass('d-none');
                    $('#place-search-submit-button').prop('disabled', true);

                },

                success: function (response) {
                    // console.log(response)
                    if (response.status === 'success' && response.data.length > 0) {
                        $('#placeList').html('')
                        $('#adSearchlistheading').text('Result : from ' + formData.minage + ' years old to ' + formData.maxage + ' years old - who ' + ' - in ' + formData.type + " " + formData.address + ' and around ')
                        $('#adsResultDiv').removeClass('d-none')
                        placeItem(response)

                    } else if (response.status === 'success' && response.data.length === 0) {
                        $('#placeList').html('')
                        $('#adSearchlistheading').text('Result : from ' + formData.min_age + ' years old to ' + formData.max_age + ' years old - who ' + ' - in ' + formData.preference + " " + formData.address + ' and around ')
                        $('#adsResultDiv').removeClass('d-none')
                    }

                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                },
                complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                    $('#place-search-submit-button').prop('disabled', false);
                }
            });
        })


        $(document).ready(function () {
            $.ajax({
                url: window.origin + '/api/place/get-all',
                type: 'GET',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {
                    if (res.status === 'success') {
                        placeItem(res)
                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });
        })

        function flashDeleteHandler(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to permanently delete the advertisement. You won't be able to revert the action.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: window.origin + '/api/place/' + id,
                        type: 'DELETE',
                        dataType: "json",
                        success: function (res) {
                            Swal.fire(
                                'Deleted!',
                                'The advertisement has been deleted.',
                                'success'
                            )
                            setInterval(function () {
                                location.reload();
                            }, 1000)

                        },
                        error: function (xhr, resp, text) {
                            console.log(xhr);
                        },
                    });
                }
            })
        }


        function placeItem(res) {
            let user = JSON.parse(localStorage.getItem('user'))
            res.data.forEach((item, index) => {

                let image = window.origin + '/asset/image/place.jpg'

                if (item.image) {
                    image = item.image
                }

                $('#placeList').append(`
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    ${item.title ? (`
                                                          <h6>${item.title}</h6>
                                                    `) : ''}

                                                     ${item.description ? (`
                                                         <p>${item.description}</p>
                                                    `) : ''}
                                                </div>
                                                <div class="col-lg-4">
                                                    ${item.image ? (`
                                                         <img id="adsImage" class="" style="width: 100px; height: 100px;" src="${item.image}" alt="">
                                                    `) : ''}
                                                </div>

                                                <div class="col-lg-6">
                                                    ${item.address ? (`
                                                        <h6>${item.address}</h6>
                                                    `) : ""}

                                                    ${item.user.username ? (`
                                                      <span>${item.user.username}</span>
                                                    `) : ""}
                                                </div>
                                            </div>
                                        </div>
                                         <div id='postAction${item.id}' class="d-none card-action text-center p-2 border-top">
                                             <span data-bs-target="#editPlaceModal${item.id}" data-bs-toggle='modal' class="iconify me-3 cursor-pointer" data-icon="bxs:edit" data-width="20" data-height="20"></span>

                                              <span onclick='flashDeleteHandler(${item.id})' class="iconify cursor-pointer" data-icon="ep:delete" data-width="20" data-height="20"></span>
                                           </div>

                                    </div>
                                </div>

                                <div class="modal" id="editPlaceModal${item.id}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-bottom justify-content-center">
                                                <h6>Update advertisement information</h6>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{url('api/place/${item.id}')}}" id="editPlaceForm${item.id}">

                                                    <div class="text-center">
                                                        <span>Your ad will expire in</span>

                                                        <div class="d-flex align-items-center justify-content-center my-2">

                                                            <div class="form-check me-3">
                                                                <input ${item.duration.month ? "checked" : ""} class="form-check-input" type="radio" value="month" name="duration" id="monthEdit">
                                                                <label class="form-check-label" for="month">1 month</label>
                                                            </div>

                                                            <div class="form-check me-3">
                                                                <input ${item.duration.week ? "checked" : ""} class="form-check-input" type="radio" value="week" name="duration"id="weekEdit">
                                                                <label class="form-check-label" for="week">
                                                                    1 week
                                                                </label>
                                                            </div>

                                                            <div class="form-check me-3">
                                                                <input ${item.duration.hour ? "checked" : ""} class="form-check-input" type="radio" value="hour" name="duration"
                                                                       id="hourEdit">
                                                                <label class="form-check-label" for="hour">
                                                                    24 hours
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="title" class="form-label title_label" id="title_label">Message title</label>
                                                        <input type="text" value='${item.title}' id="titleEdit" name="title" class="form-control title"
                                                               placeholder="Message title" onchange="clearError(this)">
                                                        <span class="text-danger title_error" id="title_error"></span>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="address" class="form-label address_label"
                                                               id="address_label">Location</label>
                                                        <input type="text" value='${item.address}' id="addressEdit" name="address" class="form-control address"
                                                               placeholder="Location" onchange="clearError(this)">
                                                        <span class="text-danger address_error" id="address_error"></span>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="description" class="form-label description_label" id="description_label">Description</label>
                                                        <textarea name="description" id="descriptionEdit" placeholder="Description"
                                                                  class="form-control description" onchange="clearError(this)">${item.description}</textarea>
                                                        <span class="text-danger description_error" id="description_error"></span>
                                                    </div>


                                                    <div>
                                                        <label for="" class="form-label">Advertisement image</label>

                                                        <input type="hidden" name="image" value=${image} id="editPlaceImageURL">

                                                        <img style="width: 100%; height: 200px;" class=" my-3" id="editImagePreview" src="${image}" alt="">




                                                        <input type="file" id="file-uploader" hidden name="image"
                                                               onchange="editPlaceImgUpload(event)"/>

                                                        <label for="file-uploader"
                                                               class="d-flex form-control w-100 border-dashed align-items-center cursor-pointer">
                                                            <span class="iconify me-3" data-icon="fa-solid:camera" data-width="20"
                                                                  data-height="20"></span>
                                                            Click here to upload image
                                                        </label>
                                                    </div>

                                                    <button type="submit" id='update-button' class="btn btn-primary my-3">Update</button>
                                                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-3">
                                                        Cancel
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `)
                if (user) {
                    if (user.id === item.user.id) {
                        // console.log('user:', typeof(user.id) , "item User id:", typeof(item.user.id) )
                        $('#postAction' + item.id).removeClass('d-none')
                    }
                }

                $('#editPlaceForm' + item.id).submit(function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let form_data = JSON.stringify(form.serializeJSON());
                    let formData = JSON.parse(form_data);


                    let url = form.attr("action");

                    $.ajax({
                        type: 'patch',
                        url: url,
                        data: formData,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            "Authorization": token,
                        },
                        beforeSend: function () {
                            $('#update-button').prop('disabled', true);
                            $('#preloader').removeClass('d-none');
                        },
                        success: function (response) {

                            toastr.success(response.message)
                            location.reload()

                        },
                        error: function (xhr, resp, text) {
                            console.log(xhr);
                        },
                        complete: function (xhr, status) {
                            $('#upload-button').prop('disabled', false);
                            $('#preloader').addClass('d-none');
                        }
                    });
                })


            })
        }

        /**
         * Change the current page title
         * */
        window.location.pathname === '/ads' ? document.title = 'Advertisement' : ''


    </script>
@endpush

