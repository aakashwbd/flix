@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-package">
            <div class="d-flex align-items-center mb-5">
                <h6 class="portion-title">Clean Video</h6>

                <button data-bs-target="#videoModal" data-bs-toggle="modal" class="btn btn-primary d-flex align-items-center rounded-32 ms-3">
                    <span class="iconify" data-icon="carbon:add" data-width="20" data-height="20"></span>
                    Add Video
                </button>
            </div>

            <div class="modal fade" id="videoModal" data-bs-keyboard="false" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h6 class="">Add a new video</h6>
                        </div>
                        <div class="modal-body">
                            <form action="{{url('api/admin/video/store')}}" id="videoForm">
                                <div class="form-group mb-3">
                                    <label for="title" id="title_label" class="form-label title_label">Video Title</label>
                                    <input class="form-control title" type="text" id="title" name="title" placeholder="Video Title"  onchange="clearError(this)">
                                    <span class="text-danger title_error" id="title_error"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="category" class="form-label category_id_label" id="category_id_label">Select Category</label>
                                    <select  class="form-select category_id" name="category_id" id="category_id" onchange="clearError(this)">
                                        <option value="">Select category</option>
                                    </select>
                                    <span class="text-danger category_id_error" id="category_id_error"></span>
                                </div>

                                <label for="" class="form-label">Video</label>

                                <div id="videoPreview"></div>



                                <div id="videoUploaderDiv">
                                    <input id="video-uploader" accept="video/*" type="file" hidden onchange="videoUploader(event)">
                                    <label for="video-uploader" class="cursor-pointer btn border form-control">Click here to upload video</label>
                                </div>

                                <button id="re-upload-button" type="button" class="btn form-control border my-2 d-none">
                                    click here to change the video
                                </button>



                                <input type="hidden" id="video" name="video">

                                <button type="submit" id="submit-button" class="btn btn-primary my-3">Save</button>
                                <button type="button" class="btn btn-outline-secondary my-3" data-bs-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editVideoModal" data-bs-keyboard="false" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h6 class="">Update video information</h6>
                        </div>
                        <div class="modal-body" id="editVideoFormContent">

                        </div>
                    </div>
                </div>
            </div>


            <table class="table table-bordered w-100 data-table mt-5">
                <thead>
                <tr>
                    <th>Video Title</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>
    </main>
@endsection


@push('custom-js')
    <script>

        /**
         * Change the current page title
         * */
        window.location.pathname === '/admin/video'? document.title = 'Dashboard | Video' : ''

        $('#re-upload-button').on('click', function (){
            $('#videoUploaderDiv').removeClass('d-none')
            $('#re-upload-button').addClass('d-none')
            $('#videoPreview').addClass('d-none')
            $('#videoPreview').html('')
            $('.uploaded_video').attr('src', '')


        })

        function videoUploader (event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'video');

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
                    if(res.status === 'success'){
                        toastr.success(res.message)
                        $('#video').val(res.data)
                        $('#videoPreview').removeClass('d-none')

                        $('#videoPreview').append(`
                            <video class="uploaded_video" style="width: 100%; height: 200px" controls>
                                <source src="${res.data}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        `)

                        $('#videoUploaderDiv').addClass('d-none')
                        $('#re-upload-button').removeClass('d-none')

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

        $(document).ready(function (){
            $.ajax({
                type: 'get',
                url: window.origin + '/api/admin/category/all',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if(response.status === 'success' && response.data.length > 0){

                        response.data.forEach(item=>{
                            $('#category_id').append(`
                                <option value="${item.id}">${item.name}</option>
                            `)
                        })

                    }

                },
                error: function (xhr, resp, text) {
                    console.log(xhr, resp)
                }
            });
        })

        $('#videoForm').submit(function (e) {
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
                },
                beforeSend: function () {
                    $('#submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
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
                },
                complete: function (xhr, status) {
                    $('#submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        })

        function categoryDeleteHandler(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to permanently delete the video. You won't be able to revert the action.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: window.origin + '/api/admin/video/'+id,
                        type: 'DELETE',
                        dataType: "json",
                        success: function (res) {
                            Swal.fire(
                                'Deleted!',
                                'The video has been deleted.',
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

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('api/admin/video/get-all')}}",
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'category.name', name: 'category.name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });


        function videoEditHandler(id){
            $('#editVideoModal').modal('show')
            $.ajax({
                type: "GET",
                url: window.origin + '/api/admin/video/'+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#editVideoFormContent').html('')
                    if(response.status === 'success'){
                        $('#editVideoFormContent').append(`
                            <form action="{{url('api/admin/video/${response.data.id}')}}" id="editVideoForm">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Video Title</label>
                                    <input value='${response.data.title}' class="form-control" type="text" id="title" name="title" placeholder="Video Title">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Select Category</label>
                                    <select class="form-select" name="category_id" id="editCategorySelect">
                                            <option value='${response.data.category.id}'>${response.data.category.name}</option>
                                    </select>
                                </div>

                                <div id="editVideoPreview">
                                     <video style="width: 100%; height: 200px" controls>
                                        <source src="${response.data.video}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>

                                <input id="edit_video-uploader" type="file" hidden onchange="editVideoUploader(event)">
                                <label for="edit_video-uploader" class="cursor-pointer btn border form-control">Upload a Video</label>

                                <input type="hidden" value='${response.data.video}' id="editVideo" name="video">

                                <button type="submit" id='update-button' class="btn btn-primary my-3">Update</button>
                                <button type="button" data-bs-dismiss='modal' class="btn btn-outline-secondary my-3">Cancel</button>
                            </form>
                        `)

                        $.ajax({
                            type: 'get',
                            url: window.origin + '/api/admin/category/all',
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            success: function (response) {
                                if(response.status === 'success' && response.data.length > 0){
                                    response.data.forEach(item=>{
                                        $('#editCategorySelect').append(`
                                            <option value="${item.id}">${item.name}</option>
                                        `)
                                    })
                                }
                            },
                            error: function (xhr, resp, text) {
                                console.log(xhr, resp)
                            }
                        });


                        $('#editVideoForm').submit(function (e) {
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
                                }, beforeSend: function () {
                                    $('#submit-button').prop('disabled', true);
                                    $('#preloader').removeClass('d-none');
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
                                },
                                complete: function (xhr, status) {
                                    $('#submit-button').prop('disabled', false);
                                    $('#preloader').addClass('d-none');
                                }
                            });
                        })


                        editVideoUploader =function  (event) {
                            event.preventDefault();
                            let file = event.target.files[0];
                            let formData = new FormData()
                            formData.append('file', file);
                            formData.append('folder', 'video');

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
                                    if(res.status === 'success'){
                                        $('#editVideoPreview').html('')
                                        toastr.success(res.message)
                                        $('#editVideo').val(res.data)

                                        $('#editVideoPreview').append(`
                                            <video style="width: 100%; height: 200px" controls>
                                                <source src="${res.data}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        `)
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
                    }


                }, error: function (xhr, resp, text) {
                    console.log(xhr && xhr.responseJSON)
                }
            });
        }




        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }
    </script>
@endpush


