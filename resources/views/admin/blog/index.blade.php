@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-blog">
            <div class="d-flex align-items-center">
                <h6 class="portion-title me-5">Blog</h6>
                <Button class="btn btn-primary my-3 rounded-32" data-bs-toggle="modal" data-bs-target="#blogModal">
                    <span class="iconify" data-icon="carbon:add" data-width="20" data-height="20"></span>
                    Add Blog
                </Button>

            </div>
            <div class="alert alert-warning d-none w-50" id="no-data">
                Please create a new blog to view the list.
            </div>

            <div class="row my-3" id="blogList"></div>
        </section>

        <div class="modal fade" id="blogModal" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="">Add a new blog</h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('api/admin/blog/store')}}" id="blogForm">
                            <label for="blogImg" class="form-label">Blog Image</label>
                            <input type="hidden" id="blogImg" name="image">
                            <div class="d-flex justify-content-between">
                                <div id="upload-content" class="">
                                    <input type="file" id="logo-uploader" hidden onchange="imageUploader(event)"/>
                                    <label id="uploadLabel" for="logo-uploader"
                                           class="border-dashed cursor-pointer text-black-50  p-2 rounded d-flex align-items-center">
                                    <span class="iconify mx-1" data-icon="ant-design:cloud-upload-outlined"
                                          data-width="20"
                                          data-height="20"></span>
                                        Click here to upload image
                                    </label>
                                </div>
                                <img id="imgPreview" class="d-none" style="width: 100%; height: 200px" src="" alt="">
                            </div>

                            <div class="form-group my-3">
                                <label for="title" id="title_label" class="form-label title_label">Blog Title</label>
                                <input type="text" name="title" id="title" class="form-control title"
                                       placeholder="Blog Title"   onchange="clearError(this)">
                                <span class="text-danger title_error" id="title_error"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label id="description_label" for="description" class="form-label description_label">Blog Description</label>
                                <textarea name="description" id="description" class="form-control description"
                                          placeholder="Blog Description"   onchange="clearError(this)"></textarea>
                                <span id="description_error" class="text-danger description_error"></span>
                            </div>

                            <button type="submit" id="submit-button" class="btn btn-primary">Save</button>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary">Cancel
                            </button>

                        </form>


                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editBlogModal" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="">Update blog information</h6>
                    </div>
                    <div class="modal-body" id="editBlogContent"></div>
                </div>
            </div>
        </div>


    </main>

@endsection

@push('custom-js')
    <script>

        /**
         * Change the current page title
         * */
        window.location.pathname === '/admin/blog'? document.title = 'Dashboard | Blog' : ''


        function imageUploader(event) {
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
                    $('#submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message)
                        $('#blogImg').val(res.data)
                        $('#imgPreview').removeClass('d-none').attr('src', res.data)
                        $('#uploadLabel').text('Edit Blog Image')
                        $('#upload-content').addClass('d-none')

                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }, complete: function (xhr, status) {
                    $('#submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        }

        function editImageUploader(event) {
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
                    $('#update-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message)
                        $('#editBlogImg').val(res.data)
                        $('#editImgPreview').attr('src', res.data)

                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }, complete: function (xhr, status) {
                    $('#update-button').prop('disabled', false);

                }
            });
        }

        function deleteHandler(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to permanently delete the blog. You won't be able to revert the action.",
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
                                'The blog has been deleted.',
                                'success'
                            )

                            window.setTimeout( function() {
                                window.location.reload();
                            }, 2000);

                        },
                        error: function (xhr, resp, text) {
                            console.log(xhr);
                        },
                    });


                }
            })


        }

        function editHandler(url) {
            $('#editBlogModal').modal('show')

            $.ajax({
                type: "GET",
                url: window.origin + url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                beforeSend: function () {
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {
                    if (response.status === 'success') {
                        let image = "{{asset('images/Default_Image_Thumbnail.png')}}"
                        if (response.data.image) {
                            image = response.data.image
                        }
                        $('#editBlogContent').html('')
                        $('#editBlogContent').append(`
                            <form action="{{url('api/admin/blog/${response.data.id}')}}" id="editBlogForm">
                                <label for="editBlogImg" class="form-label">Blog Image</label>
                                <input type="hidden" value="${image}" id="editBlogImg" name="image">

                                <div>
                                    <img id="editImgPreview" class=" mb-3" style="width: 100%; height: 200px" src="${image}" alt="">
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div id="upload-content" class="">
                                        <input type="file" id="uploader" hidden onchange="editImageUploader(event)"/>
                                        <label id="uploadLabel" for="uploader"
                                               class="border-dashed cursor-pointer text-black-50  p-2 rounded  d-flex align-items-center">
                                        <span class="iconify mx-1" data-icon="ant-design:cloud-upload-outlined"
                                              data-width="20"
                                              data-height="20"></span>
                                            Click here to upload image
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group my-3">
                                    <label for="title" class="form-label">Blog Title</label>
                                    <input type="text" value="${response.data.title}" name="title" id="title" class="form-control" placeholder="Blog Title">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Blog Description</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Blog Description">${response.data.description}</textarea>
                                </div>

                                <button type="submit" id='update-button' class="btn btn-primary">Update</button>
                                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-2">Cancel</button>

                            </form>
                        `)


                        $('#editBlogForm').submit(function (e) {
                            e.preventDefault();

                            let form = $(this);
                            let form_data = JSON.stringify(form.serializeJSON());
                            let formData = JSON.parse(form_data)

                            let url = form.attr('action');

                            $.ajax({
                                type: "patch",
                                url: url,
                                data: formData,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },

                                beforeSend: function () {
                                    $('#update-button').prop('disabled', true);
                                    $('#preloader').removeClass('d-none');
                                },
                                success: function (response) {
                                    toastr.success(response.message)


                                    window.setTimeout( function() {
                                        window.location.reload();
                                    }, 2000);

                                }, error: function (xhr, resp, text) {

                                    console.log(xhr && xhr.responseJSON)
                                },
                                complete: function (xhr, status) {
                                    $('#update-button').prop('disabled', false);
                                    $('#preloader').addClass('d-none');
                                }

                            });
                        })
                    }
                }, error: function (xhr, resp, text) {
                    console.log(xhr && xhr.responseJSON)
                },
                complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        }


        $('#blogForm').submit(function (e) {
            let token = localStorage.getItem('adminAccess')
            e.preventDefault();
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
                    'Authorization': token
                },
                beforeSend: function () {
                    $('#submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {
                    toastr.success(response.message)

                    window.setTimeout( function() {
                        window.location.reload();
                    }, 2000);
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
                    $('#submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        })


        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: window.origin + '/api/admin/blog/get-all',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                beforeSend: function () {
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(item => {
                            let image = "{{asset('images/Default_Image_Thumbnail.png')}}"
                            if (item.image) {
                                image = item.image
                            }
                            $('#blogList').append(`
                            <div class="col-lg-4 col-12 mb-3">
                                <div class="card">
                                    <img class="card-img-top border-bottom" style="width: 100%; height: 240px; object-fit: cover;" src="${image}" alt="">
                                    <div class='card-img-overlay'>
                                        <button class="btn bg-white" onclick="editHandler('/api/admin/blog/${item.id}')">
                                            <span class="iconify" data-icon="bxs:edit" data-width="20" data-height="20"></span>
                                        </button>
                                        <button class="btn bg-white" onclick="deleteHandler('/api/admin/blog/${item.id}')">
                                            <span class="iconify" data-icon="ep:delete-filled" data-width="20" data-height="20"></span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <h6>${item.title}</h6>
                                        <p class=" text-wrap">${(item.description).slice(0,100).concat('...')}</p>
                                    </div>
                                </div>
                            </div>
                            `)
                        })
                    }else if(response.status === 'success' && response.data.length === 0){
                        $('#no-data').removeClass('d-none')
                    }
                }, error: function (xhr, resp, text) {
                    console.log(xhr && xhr.responseJSON)
                },
                complete: function (xhr, status) {
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

    </script>
@endpush
