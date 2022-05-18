@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-package">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <div class="d-flex align-items-center ">
                    <h6 class="portion-title">Notification</h6>
                    <button
                        class="
                        btn
                        btn-primary
                        rounded-32
                        ms-4
                        my-3
                        d-flex
                        justify-content-center
                        align-items-center
                        "
                        data-bs-target="#notificationModal"
                        data-bs-toggle="modal"
                    >
                    <span
                        class="
                                iconify
                                me-2

                            "
                        data-icon="bi:send-plus"
                        data-width="16"
                        data-height="16"
                    ></span>
                        Send
                    </button>

                </div>
                <button
                    class="
                        btn
                        btn-outline-secondary
                        rounded-32
                        ms-4
                        my-3
                        d-flex
                        justify-content-center
                        align-items-center
                        "
                    data-bs-target="#manageNotificationModal"
                    data-bs-toggle="modal"
                >
                    <span
                        class="
                                iconify
                                me-2

                            "
                        data-icon="ant-design:setting-filled"
                        data-width="16"
                        data-height="16"
                    ></span>
                    Manage Notification
                </button>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Package Name</th>
                    <th>Video Title</th>
                    <th>External Link</th>
                    <th>Created Time</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>


        <div class="modal fade" id="notificationModal" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="">Send a new notification</h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('api/admin/notification/store')}}" id="notificationForm">
                            <div class="form-group mb-3">
                                <label for="title" id="title_label" class="form-label title_label">Notification title</label>
                                <input type="text" id="title" name="title" class="form-control title"
                                       placeholder="Notification title" onchange="clearError(this)">
                                <span class="text-danger title_error" id="title_error"></span>
                            </div>

                            <div class="form-group my-3">
                                <label for="description" id="description_label" class="form-label description_label">Notification
                                    description</label>
                                <textarea id="description" name="description" class="form-control description"
                                          placeholder="Notification description"   onchange="clearError(this)"></textarea>
                                <span class="text-danger description_error" id="description_error"></span>
                            </div>


                            <div class="form-group my-3" id="package-input">
                                <label for="packages" class="form-label package_id_label">For packages</label>
                                <select name="package_id" id="packages" class="form-select package_id">
                                    <option value="" selected>Select a package</option>
                                </select>
                            </div>

                            <div class="form-group my-3" id>
                                <label for="videos" class="form-label package_id_label">For videos</label>
                                <select name="video_id" id="videos" class="form-select video_id">
                                    <option value="" selected>Select a video</option>
                                </select>
                            </div>

                            <div class="form-group my-3">
                                <label for="link" class="form-label link_label">External link</label>
                                <input id="link" type="text" name="link" class="form-control "
                                       placeholder="External link">
                            </div>

                            <button type="submit" class="btn btn-primary my-3">Send</button>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-3">
                                Cancel
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="manageNotificationModal" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="">OneSignal API</h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('api/admin/notification/manage-api')}}" id="oneSignalForm">
                            <div class="form-group mb-3">
                                <label for="app_id" id="app_id_label" class="form-label app_id_label">OneSignal app id</label>
                                <input type="text" id="app_id" name="app_id" class="form-control app_id"
                                       placeholder="Onesignal app id"   onchange="clearError(this)">
                                <span class="text-danger app_id_error" id="app_id_error"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="api_key" id="api_key_label" class="form-label api_key_label">OneSignal api key</label>
                                <input type="text" id="api_key" name="api_key" class="form-control api_key"
                                       placeholder="Onesignal api key"   onchange="clearError(this)">
                                <span class="text-danger api_key_error" id="api_key_error"></span>
                            </div>

                            <button type="submit" class="btn btn-primary my-3" id="oneSignalSaveButton">Save</button>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-3">
                                Cancel
                            </button>

                        </form>
                    </div>
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
        window.location.pathname === '/admin/notification'? document.title = 'Dashboard | Notification' : ''


        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }

        $(document).ready(function () {
            const package_data = {
                method: 'GET',
                url: '/api/admin/package/all-list',
            }

            const video_data = {
                method: 'GET',
                url: '/api/admin/video/fetch-all',
            }
            const onesignal_data = {
                method: 'GET',
                url: '/api/admin/notification/manage-api/fetch',
            }
            ajax(package_data, fetchPackages)
            ajax(video_data, fetchVideo)
            ajax(onesignal_data, fetchAPI)
        })

        function fetchPackages(data) {
            data.data.forEach(item => {
                $('#packages').append(`
                        <option value="${item.id}">${item.name}</option>
                    `)
            })
        }

        function fetchVideo(data) {
            data.data.forEach(item => {
                $('#videos').append(`
                        <option value="${item.id}">${item.title}</option>
                    `)
            })
        }

        function fetchAPI(data) {
            $('#app_id').val(data.data[0].app_id)
            $('#api_key').val(data.data[0].api_key)
            $('#oneSignalSaveButton').text('Update')
        }

        function ajax(options, fetch) {
            $.ajax({
                type: options.method,
                url: window.origin + options.url,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    fetch(response)
                },
                error: function (xhr, resp, text) {
                    console.log(xhr, resp)
                }
            });
        }

        function notificationDeleteHandler(id) {
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
                        url: window.origin + '/api/admin/notification/' + id,
                        type: 'DELETE',
                        dataType: "json",
                        success: function (res) {
                            Swal.fire(
                                'Deleted!',
                                'The notification has been deleted.',
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


        $('#notificationForm').submit(function (e) {
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
                    $('#preloader').addClass('d-none');
                }
            });
        })

        $('#oneSignalForm').submit(function (e) {
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
                    $('#preloader').addClass('d-none');
                }
            });
        })


        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('api/admin/notification/get-all')}}",
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'package.name', name: 'package.name'},
                    {data: 'video.title', name: 'video.title'},
                    {data: 'link', name: 'link'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });



    </script>
@endpush
