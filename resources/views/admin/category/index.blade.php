@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-category">
            <div class="d-flex align-items-center">
                <h6 class="portion-title me-5">Category</h6>
                <Button class="btn btn-primary my-3 rounded-32" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <span class="iconify" data-icon="carbon:add" data-width="20" data-height="20"></span>
                    Add Category
                </Button>
            </div>

            <div class="alert alert-warning d-none w-50" id="no-data">
                Please create a new category to view the list.
            </div>
            <ul class="row  p-0" id="categoryList"></ul>
        </section>


    </main>


    <div class="modal fade" id="categoryModal" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="">Add a new category</h6>
                </div>
                <div class="modal-body">
                    <form action="{{url('api/admin/category/store')}}" id="categoryForm">
                        <div class="form-group mb-3">
                            <label
                                for="name"
                                class="form-label name_label"
                                id="name_label"
                            >
                                Category Name
                            </label>

                            <input
                                type="text"
                                class="form-control name"
                                name="name"
                                id="name"
                                placeholder="Category Name"
                                onchange="clearError(this)"
                            >
                            <span
                                class="text-danger name_error"
                                id="name_error"
                            ></span>
                        </div>


                        <label for="categoryImage" class="form-label">Category Image</label>
                        <input type="hidden" id="categoryImage" name="image">

                        <input type="file" id="logo-uploader" hidden onchange="categoryImageUpload(event)"/>
                        <label for="logo-uploader"
                               class="border-dashed cursor-pointer text-black-50 py-2 rounded  d-flex align-items-center">
                                    <span class="iconify mx-3" data-icon="ant-design:upload-outlined" data-width="20"
                                          data-height="20"></span>
                            Click here to upload image
                        </label>
                        <img style="width: 100%; height: 280px" id="categoryImagePreview" class="d-none my-3" src=""
                             alt="">

                        <button type="submit" id="submit-button" class="btn  btn-primary my-3">Save</button>
                        <button type="button" data-bs-dismiss="modal" class="btn  btn-outline-secondary my-3">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editCategoryModal" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="">Update category information
                    </h6>
                </div>
                <div class="modal-body" id="editCategoryFormContent">

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
        window.location.pathname === '/admin/category'? document.title = 'Dashboard | Category' : ''




        $('#categoryForm').submit(function (e) {
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

        function categoryImageUpload(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'category');

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
                        $('#categoryImage').val(res.data)
                        $('#categoryImagePreview').removeClass('d-none').attr('src', res.data)

                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },

                complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                    $('#submit-button').prop('disabled', false);
                }

            });
        }

        function editCategoryImageUpload(event) {
            event.preventDefault();
            let file = event.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'category');

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
                        $('#editCategoryImage').val(res.data)
                        $('#editCategoryImagePreview').attr('src', res.data)
                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
                ,complete: function (xhr, status) {
                    $('#update-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        }


        $(document).ready(function () {


            $.ajax({
                type: 'get',
                url: window.origin + '/api/admin/category/all',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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

                            $('#categoryList').append(`
                                <li class="col-lg-4 col-12 col-sm-12 mb-3">
                                    <div class="card">
                                        <img style="width:100%; height: 250px;"  src="${image}" alt="">
                                        <div class="card-img-overlay">
                                             <button class="btn border bg-white" onclick="categoryEditHandler('/api/admin/category/'+${item.id})">
                                            <span class="iconify"  data-icon="bxs:edit" data-width="20" data-height="20"></span>
                                        </button>
                                        <button class="btn border bg-white" onclick="categoryDeleteHandler('/api/admin/category/'+${item.id})">
                                            <span class="iconify" data-icon="ep:delete-filled" data-width="20" data-height="20"></span>
                                        </button>
                                        </div>

                                        <div class="card-body">
                                            <h6>${item.name}</h6>
                                        </div>
                                    </div>
                                </li>
                            `)
                        })

                    }else if(response.status === 'success' && response.data.length === 0){
                        $('#no-data').removeClass('d-none')
                    }

                },
                error: function (xhr, resp, text) {
                    console.log(xhr, resp)
                }
                ,complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        })

        function categoryEditHandler(url) {
            $('#editCategoryModal').modal('show')

            $.ajax({
                type: 'get',
                url: url,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }, beforeSend: function () {
                $('#preloader').removeClass('d-none');
            },
                success: function (response) {
                    $('#editCategoryFormContent').html('')
                    if (response.status === 'success') {
                        let image = "{{asset('images/Default_Image_Thumbnail.png')}}"
                        if (response.data.image) {
                            image = response.data.image
                        }

                        $('#editCategoryFormContent').append(`
                            <form action="{{url('api/admin/category/${response.data.id}')}}" id="editCategoryForm">
                                <div class="form-group mb-3">
                                    <label
                                        for="name"
                                        class="form-label name_label"
                                        id="name_label"
                                    >
                                        Category Name
                                    </label>
                                    <input type="text" class="form-control" value='${response.data.name}' name="name" placeholder="category name">
                                </div>
                                <input
                                    type="file" id="uploader" hidden onchange="editCategoryImageUpload(event)"/>
                                 <input type="hidden" id="editCategoryImage" value='${image}' name="image">
                                 <label class='form-label'>Category Image</label>
                                <label for="uploader"
                                       class="border-dashed cursor-pointer text-black-50 py-2 rounded  d-flex align-items-center">
                                            <span class="iconify mx-3" data-icon="fluent:add-12-filled" data-width="20"
                                                  data-height="20"></span>
                                   Click here to upload image
                                </label>
                                <img style='width: 100%; height: 250px;' class='my-3' id="editCategoryImagePreview" src="${image}" alt="">


                                <button type="submit" id='update-button' class="btn  btn-primary">Update</button>

                                 <button type="button"  data-bs-dismiss="modal" class="btn  btn-outline-secondary my-3">Cancel</button>

                            </form>
                        `)
                    }


                    $('#editCategoryForm').submit(function (e) {
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
                            }, beforeSend: function () {
                                $('#update-button').prop('disabled', true);
                                $('#preloader').removeClass('d-none');
                            },
                            success: function (response) {
                                toastr.success(response.message)
                                location.reload()
                            },
                            error: function (xhr, resp, text) {
                                console.log(xhr, resp)
                            }, complete: function (xhr, status) {
                                $('#update-button').prop('disabled', false);
                                $('#preloader').addClass('d-none');
                            }
                        });
                    })
                },
                error: function (xhr, resp, text) {
                    console.log(xhr, resp)
                }, complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        }


        function categoryDeleteHandler(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to permanently delete the category. You won't be able to revert the action.",
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
                                'The category has been deleted.',
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

        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }

    </script>
@endpush
