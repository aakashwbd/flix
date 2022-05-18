@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-user">
            <div class="d-flex align-items-center mb-5">
                <h6 class="portion-title">Manage Admin</h6>
                <button class="btn btn-primary btn-sm ms-3 rounded-32" data-bs-toggle="modal"
                        data-bs-target="#adminModal">
                    <span class="iconify" data-icon="fluent:add-12-filled" data-width="15" data-height="15"></span>
                    Add Admin
                </button>
            </div>

            <table class="table table-bordered admin-data-table mt-5">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Account Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


            {{--            <ul class="nav nav-tabs mb-5" id="admin-tab" role="tablist">--}}
            {{--                <li class="nav-item" role="presentation">--}}
            {{--                    <button class="nav-link active" id="admin-tab-button" data-bs-toggle="tab" data-bs-target="#admin-content" type="button" role="tab">Admin</button>--}}
            {{--                </li>--}}

            {{--                <li class="nav-item" role="presentation">--}}
            {{--                    <button class="nav-link" id="super-tab-button" data-bs-toggle="tab" data-bs-target="#super-content" type="button" role="tab">Super Admin</button>--}}
            {{--                </li>--}}
            {{--            </ul>--}}

            {{--            <div class="tab-content" id="admin-tab-content">--}}
            {{--                <div class="tab-pane fade show active" id="admin-content" role="tabpanel">--}}

            {{--                    <table class="table table-bordered admin-data-table mt-5">--}}
            {{--                        <thead>--}}
            {{--                        <tr>--}}
            {{--                            <th>Name</th>--}}
            {{--                            <th>Email</th>--}}
            {{--                            <th>Phone</th>--}}
            {{--                            <th>Account Created</th>--}}
            {{--                            <th>Action</th>--}}
            {{--                        </tr>--}}
            {{--                        </thead>--}}
            {{--                        <tbody>--}}
            {{--                        </tbody>--}}
            {{--                    </table>--}}

            {{--                </div>--}}

            {{--                <div class="tab-pane fade" id="super-content" role="tabpanel">--}}

            {{--                    <table class="table table-bordered super-data-table w-100">--}}
            {{--                        <thead>--}}
            {{--                        <tr>--}}
            {{--                            <th>User Name</th>--}}
            {{--                            <th>User Email</th>--}}
            {{--                            <th>Account Created</th>--}}
            {{--                            <th>Action</th>--}}
            {{--                        </tr>--}}
            {{--                        </thead>--}}
            {{--                        <tbody>--}}
            {{--                        </tbody>--}}
            {{--                    </table>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </section>

        <div class="modal fade" id="adminModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="">Add a new admin
                        </h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('api/auth/register')}}" id="adminForm">

                            <div class="form-group mb-2">
                                <label for="role" class="form-label role_label" id="role_label">Role</label>
                                <select name="user_role_id" id="role" class="form-select py-2 rounded-0">
                                    <option value="2">Admin</option>
                                    <option value="1">Super Admin</option>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="name" class="form-label name_label" id="name_label">Name</label>
                                <input type="text" class="form-control py-2 rounded-0" id="name" name="name"
                                       placeholder="John Doe">
                                <span class="text-danger name_error" id="name_error"></span>
                            </div>


                            <div class="form-group mb-2">
                                <label for="email" class="form-label email_label" id="email_label">Email</label>
                                <input type="email" class="form-control py-2 rounded-0" id="email" name='email'
                                       placeholder="example@example.com">
                                <span class="text-danger email_error" id="email_error"></span>
                            </div>

                            <div class="form-group mb-2">
                                <label for="phone" class="form-label phone_label" id="phone_label">Phone</label>
                                <input type="text" class="form-control py-2 rounded-0" name="phone" id="phone"
                                       placeholder="">
                                <span class="text-danger phone_error" id="phone_error"></span>
                            </div>

                            <div class="form-group mb-2">
                                <label for="password" class="form-label password_label"
                                       id="password_label">Password</label>

                                <div class="input-group">
                                    <input type="password" class="form-control py-2 rounded-0" id="password"
                                           name="password"
                                           placeholder="******">
                                    <span class="input-group-text rounded-0 cursor-pointer toggle-password"
                                          onclick="togglePassword();">
                                        <span class="iconify showIcon" data-icon="codicon:eye" data-width="20"
                                              data-height="20"></span>
                                        <span class="iconify d-none hideIcon" data-icon="codicon:eye-closed"
                                              data-width="20" data-height="20"></span>
                                    </span>
                                </div>

                                <span class="text-danger password_error" id="password_error"></span>
                            </div>

                            <div class="d-flex align-items-center">

                                <button type="submit" id="submit-button" class="btn btn-primary">
                                    Save
                                </button>
                                <button type="button" class="btn btn-outline-secondary ms-2" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>




        <div class="modal fade" id="editAdminModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="">Update admin information
                        </h6>
                    </div>
                    <div class="modal-body" id="updateAdminModal">
                        <form action="" id="editAdminForm">

                            <div class="form-group mb-2">
                                <label for="role" class="form-label role_label" id="role_label">Role</label>
                                <select name="user_role_id" id="editRole" class="form-select py-2 rounded-0">
                                    <option value="2">Admin</option>
                                    <option value="1">Super Admin</option>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="name" class="form-label name_label" id="name_label">Name</label>
                                <input type="text" class="form-control py-2 rounded-0" id="editName" name="name"
                                       placeholder="John Doe">
                                <span class="text-danger name_error" id="name_error"></span>
                            </div>





                            <div class="d-flex align-items-center">

                                <button type="submit" id="update-button" class="btn btn-primary">
                                    Update
                                </button>
                                <button type="button" class="btn btn-outline-secondary ms-2" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                            </div>

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
        window.location.pathname === '/admin/manage-admin'? document.title = 'Dashboard | Manage Admin' : ''



        function adminEditHandler(id) {
            $('#editAdminModal').modal('show')
            $.ajax({
                type: 'get',
                url: window.origin + '/api/admin/'+id,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    $('#editRole').val(response.data.user_role_id)
                    $('#editName').val(response.data.name)

                    $('#editAdminForm').attr('action', window.origin + '/api/admin/'+response.data.id)



                },
                error: function (xhr, resp, text) {
                    console.log(xhr)
                }
            });


        }

        $('#editAdminForm').submit(function (e) {
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
                success: function (response) {
                    toastr.success(response.message)
                    location.reload()
                },
                beforeSend: function () {
                    $('#update-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
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
                }, complete: function (xhr, status) {
                    $('#update-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        })

        function adminDeleteHandler(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to permanently delete the admin. You won't be able to revert the action.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: window.origin + "/api/admin/" + id,
                        type: 'DELETE',
                        dataType: "json",
                        success: function (res) {
                            Swal.fire(
                                'Deleted!',
                                'The admin has been deleted.',
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

        $('#adminForm').submit(function (e) {
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
                    // $('#adminModal').modal('hide')
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
                },complete: function (xhr, status) {
                    $('#submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        })




        function togglePassword() {
            let passwordFiled = document.querySelector('#password');
            let show = document.querySelector('.showIcon');
            let hide = document.querySelector('.hideIcon');

            if (passwordFiled.type === 'password') {
                passwordFiled.type = 'text'
                show.classList.add('d-none')
                hide.classList.remove('d-none')
            } else {
                passwordFiled.type = 'password'
                hide.classList.add('d-none')
                show.classList.remove('d-none')
            }
        }

        // let url = {
        //     adminURL: window.origin + '/api/admin/' + 2,
        //     superAdminURL: window.origin + '/api/admin/' + 3,
        // }

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.admin-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{url('api/admin/all')}}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });




        });
    </script>
@endpush

