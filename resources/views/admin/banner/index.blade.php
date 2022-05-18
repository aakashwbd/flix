@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-banner">
            <div class="d-flex align-items-center">
                <h6 class="portion-title">Manage Banner</h6>
                <button class="btn btn-primary rounded-32 my-4 ms-3 text-capitalize" data-bs-target="#bannerModal" data-bs-toggle="modal">
                    <span class="iconify" data-width="20" data-height="20" data-icon="fluent:add-12-filled"></span>
                    add banner image
                </button>
            </div>

            <div class="alert alert-warning d-none w-50" id="no-data">
                Please create a new banner to view the list.
            </div>

            <ul class="row p-0" id="bannerImgList"></ul>

        </section>
    </main>

    <div id="bannerModal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="">Add a new banner</h6>
                </div>
                <div class="modal-body">
                    <form action="{{url('api/admin/banner-image/store')}}" id="bannerForm">
                        <label for="" class="form-label image_label">
                            Banner Image
                        </label>
                        <input type="hidden" id="bannerImg" name="image">

                        <input type="file" id="logo-uploader" hidden onchange="bannerImgUpload(event)"/>

                        <label for="logo-uploader"
                               class="border-dashed cursor-pointer text-black-50 py-2 rounded d-flex align-items-center">
                                    <span class="iconify mx-1" data-icon="ant-design:cloud-upload-outlined"
                                          data-width="20"
                                          data-height="20"></span>
                            Click here to upload image
                        </label>

                        <span class="text-danger image_error d-block"></span>


                        <img style="width: 100%; height: 280px;" class="my-2 d-none" id="bannerImgPreview"
                             src=""
                             alt="">
                        <button type="submit" id="submit-button" class="btn btn-primary my-2">Save</button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-2">Cancel</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


    <div id="editBannerModal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="">Update banner information</h6>
                </div>
                <div class="modal-body">
                    <div id="editBannerFormContent"></div>
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
        window.location.pathname === '/admin/banner-image'? document.title = 'Dashboard | Banner' : ''

        function bannerImgUpload(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'banner');

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
                beforeSend: function () {
                    $('#submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                data: formData,
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message)
                        $('#bannerImg').val(res.data)
                        $('#bannerImgPreview').removeClass('d-none').attr('src', res.data)

                    }
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },
                complete: function (xhr, status) {
                    $('#submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        }

        function editBannerImgUpload(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'banner');

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
                        $('#editBannerImg').val(res.data)
                        $('#editBannerImgPreview').attr('src', res.data)

                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }, complete: function (xhr, status) {
                    $('#update-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        }

        $('#bannerForm').submit(function (e) {
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

        function bannerEditHandler(url) {
            $('#editBannerModal').modal('show')

            $.ajax({
                type: 'get',
                url: url,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },

                beforeSend: function () {
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {
                    $('#editBannerFormContent').html('')
                    if (response.status === 'success') {

                        $('#editBannerFormContent').append(`
                <form action="{{url('api/admin/banner-image/${response.data.id}')}}" id="editBannerForm">
                        <label class="form-label">Banner Image</label>
                        <input type="file" id="uploader" hidden onchange="editBannerImgUpload(event)"/>
                        <input type="hidden" id="editBannerImg" value="${response.data.image}" name="image">
                        <label for="uploader"
                               class="border-dashed cursor-pointer text-black-50 py-2 rounded d-flex align-items-center">
                                    <span class="iconify mx-1" data-icon="ant-design:cloud-upload-outlined"
                                          data-width="20"
                                          data-height="20"></span>
                                Click here to upload image
                        </label>


                        <img style="width: 100%; height: 280px;" class="my-2" id="editBannerImgPreview"
                             src="${response.data.image}"
                             alt="">
                        <button type="submit" id="update-button" class="btn btn-primary my-2">Update</button>
                        <button data-bs-dismiss='modal' type="button" class="btn btn-outline-secondary my-2">Cancel</button>
                               </form>
                    `)
                    }

                    $('#editBannerForm').submit(function (e) {
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
                                console.log(xhr, resp)
                            },complete: function (xhr, status) {
                                $('#update-button').prop('disabled', false);
                                $('#preloader').addClass('d-none');
                            }
                        });
                    })

                },
                error: function (xhr, resp, text) {
                    console.log(xhr, resp)
                },
                complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        }


        $(document).ready(function () {
            $.ajax({
                url: window.origin + '/api/admin/banner-image/index',
                type: 'GET',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                beforeSend: function () {
                    $('#preloader').removeClass('d-none');
                },
                success: function (res) {
                    if (res.status === 'success' && res.data.length > 0) {
                        res.data.forEach(item => {
                            $('#bannerImgList').append(`
                           <li class="col-lg-3 mb-3">
                               <div class="card">
                                    <img
                                        style="width: 100%; height: 250px"
                                        src="${item.image}"
                                         alt=""
                                    >
                                    <div class="card-body">
                                        <button class="btn" onclick="bannerEditHandler('/api/admin/banner-image/'+${item.id})">
                                            <span class="iconify" data-icon="bxs:edit" data-width="20" data-height="20"></span>
                                        </button>
                                        <button class="btn" onclick="bannerDeleteHandler('/api/admin/banner-image/'+${item.id})">
                                            <span class="iconify" data-icon="ep:delete-filled" data-width="20" data-height="20"></span>
                                        </button>
                                    </div>
                                </div>
                           </li>
                           `)
                        })
                    }else if(res.status === 'success' && res.data.length === 0){
                        $('#no-data').removeClass('d-none')
                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },
                complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        })

        function bannerDeleteHandler(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to permanently delete the banner image. You won't be able to revert the action.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: window.origin + url,
                        type: 'DELETE',
                        dataType: "json",
                        success: function (res) {
                            Swal.fire(
                                'Deleted!',
                                'The banner image has been deleted.',
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

    </script>
@endpush
