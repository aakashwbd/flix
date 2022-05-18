@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-package">
            <div class="d-flex align-items-center">
                <h6 class="portion-title">Invitation Code</h6>

                <button class="btn btn-primary rounded-32 d-flex align-items-center my-3 ms-3" data-bs-target="#inviteModal" data-bs-toggle="modal">
                    <span class="iconify" data-icon="carbon:add" data-width="20" data-height="20"></span>
                    Generate Invite Code
                </button>

            </div>


            <table class="table table-striped table-bordered data-table mt-5">
                <thead>
                <tr>
                    <th>Code title</th>
                    <th>Username</th>
                    <th>Package name</th>
                    <th>Duration in month</th>
                    <th>Reduction (%)</th>
                    <th>Price </th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>


        <div class="modal fade" id="inviteModal" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="text-capitalize">Generate a new code</h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('api/admin/invite-code/store')}}" id="inviteForm">
                            <div class="form-group my-3">
                                <label for="title" class="form-label title_label" id="title_label">Code title</label>
                                <input type="text" id="title" name="title" class="form-control title" placeholder="Code title" onchange="clearError(this)">
                                <span class="text-danger title_error" id="title_error"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="user_id" class="form-label user_id_label" id="user_id_label">Select user</label>
                                <select name="user_id" id="user_id" class="form-select user_id" onchange="clearError(this)">
                                    <option value="" selected>Select a user</option>
                                </select>
                                <span class="text-danger user_id_error" id="user_id_error"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="package_id" class="form-label package_id_label" id="package_id_label">Select package</label>
                                <select onchange="clearError(this)" name="package_id" id="package_id" class="form-select package_id">
                                    <option value="" selected>Select a package</option>
                                </select>
                                <span class="text-danger package_id_error" id="package_id_error"></span>
                            </div>


                            <div class="form-group mb-3">
                                <label for="duration" class="form-label duration_label" id="duration_label">Duration (in month)</label>
                                <input onchange="clearError(this)" type="number" id="duration" name="duration" class="form-control duration" placeholder="3">
                                <span class="text-danger duration_error" id="duration_error"></span>
                            </div>


                            <div class="form-group mb-3">
                                <label for="reduction" class="form-label reduction_label" id="reduction_label">Reduction in percentage (%)</label>
                                <input onchange="clearError(this)" type="number" id="reduction" name="reduction" class="form-control reduction" placeholder="50%">
                                <span class="text-danger reduction_error" id="reduction_error"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="price" class="form-label price_label" id="price_label">Price</label>
                                <input onchange="clearError(this)" type="number" id="price" name="price" class="form-control price" placeholder="$">
                                <span class="text-danger price_error" id="price_error"></span>
                            </div>

                            <button type="submit" id="submit-button" class="btn btn-primary my-3">Save</button>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-3">Cancel</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editInviteModal">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="text-capitalize">Update generate code information</h6>
                    </div>
                    <div class="modal-body" id="updateModalBody">

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
        window.location.pathname === '/admin/invite-code'? document.title = 'Dashboard | Invite Code' : ''


        function fetchData (url, fetchList){
            $.ajax({
                type: "GET",
                url: window.origin+ url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if(response.status === 'success'){
                        fetchList(response)
                    }


                }, error: function (xhr, resp, text) {
                    console.log(resp)
                }
            });
        }

        function fetchPackage(res){
            res.data.forEach(item => {
                $('#package_id').append(`
                    <option value="${item.id}">${item.name}</option>
                `)
            })
        }

        function fetchUser(res){

            res.data.forEach(item => {
                $('#user_id').append(`
                    <option value="${item.id}">${item.username}</option>
                `)
            })
        }

        $(document).ready(function (){
            fetchData('/api/admin/package/all-list', fetchPackage)
            fetchData('/api/user/all-users', fetchUser)
        })


        $('#inviteForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            // formSubmit("post", form);

            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data);

            let url = form.attr("action");


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
                    location.reload()
                }, error: function (xhr, resp, text) {

                    if (xhr && xhr.responseJSON) {
                        let response = xhr.responseJSON;
                        if (response.status && response.status === 'validate_error') {
                            $.each(response.message, function (index, message) {
                                $('.' + message.field).addClass('is-invalid');
                                $('.' + message.field + '_label').addClass('text-danger');
                                $('.' + message.field + '_error').html(message.error);
                            });
                        }
                    }
                },complete: function (xhr, status) {
                    $('#submit-button').prop('disabled', false);
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
                ajax: "{{url('api/admin/invite-code/get-all')}}",
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'package.name', name: 'package.name'},
                    {data: 'duration', name: 'duration'},
                    {data: 'reduction', name: 'reduction'},
                    {data: 'price', name: 'price'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }

        function codeEditHandler(id){
            $.ajax({
                url: window.origin + '/api/admin/invite-code/'+id,
                type: 'get',
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
                    if(res.status === 'success'){
                        $('#updateModalBody').html('')
                        $('#updateModalBody').append(`
                            <form action="{{url('api/admin/invite-code/${id}')}}" id="updateInviteForm">

                                <div class="form-group my-3">
                                    <label for="title" class="form-label title_label" id="title_label">Code title</label>
                                    <input value='${res.data.title}' type="text" id="title" name="title" class="form-control title" placeholder="Code title">
                                    <span class="text-danger title_error" id="title_error"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="user_id" class="form-label user_id_label" id="user_id_label">Select user</label>
                                    <select disabled name="user_id" id="user_id" class="form-select">
                                        <option value="${res.data.user.id}" selected>${res.data.user.username}</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="package_id" class="form-label package_id_label" id="package_id_label">Select package</label>
                                    <select disabled name="package_id" id="update_package_id" class="form-select">
                                        <option value="${res.data.package.id}" selected>${res.data.package.name}</option>
                                    </select>
                                </div>


                                <div class="form-group mb-3">
                                    <label for="duration" class="form-label title_label" id="title_label">Duration (in month)</label>
                                    <input value='${res.data.duration}' type="text" id="duration" name="duration" class="form-control duration" placeholder="3">
                                    <span class="text-danger title_error" id="title_error"></span>
                                </div>


                                <div class="form-group mb-3">
                                    <label for="reduction" class="form-label title_label" id="title_label">Reduction in percentage (%)</label>
                                    <input value='${res.data.reduction}' type="text" id="reduction" name="reduction" class="form-control reduction" placeholder="50%">
                                    <span class="text-danger title_error" id="title_error"></span>
                                </div>


                                <div class="form-group mb-3">
                                    <label for="price" class="form-label price_label" id="price_label">Price</label>
                                    <input value='${res.data.price}' type="number" id="price" name="price" class="form-control price" placeholder="$">
                                    <span class="text-danger price_error" id="price_error"></span>
                                </div>

                                <button type="submit" id="update-button" class="btn btn-primary my-3">Update</button>
                                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-3">Cancel</button>
                            </form>
                        `)


                        $('#updateInviteForm').submit(function (e) {
                            e.preventDefault();
                            let form = $(this);
                            // formSubmit("post", form);

                            let form_data = JSON.stringify(form.serializeJSON());
                            let formData = JSON.parse(form_data);

                            let url = form.attr("action");


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
                                    location.reload()
                                }, error: function (xhr, resp, text) {

                                    if (xhr && xhr.responseJSON) {
                                        let response = xhr.responseJSON;
                                        if (response.status && response.status === 'validate_error') {
                                            $.each(response.message, function (index, message) {
                                                $('.' + message.field).addClass('is-invalid');
                                                $('.' + message.field + '_label').addClass('text-danger');
                                                $('.' + message.field + '_error').html(message.error);
                                            });
                                        }
                                    }
                                },complete: function (xhr, status) {
                                    $('#update-button').prop('disabled', false);
                                    $('#preloader').addClass('d-none');
                                }
                            });
                        })
                    }

                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                },complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
        }
        function inviteCodeDeleteHandler(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to permanently delete the generate code. You won't be able to revert the action.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: window.origin + '/api/admin/invite-code/'+id,
                        type: 'DELETE',
                        dataType: "json",
                        success: function (res) {
                            Swal.fire(
                                'Deleted!',
                                'The generate code has been deleted.',
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
