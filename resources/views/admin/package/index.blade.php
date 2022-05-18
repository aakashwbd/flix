@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-package">
            <h6 class="portion-title mb-5">Package</h6>

            <table class="table table-striped table-bordered data-table mt-5">
                <thead>
                <tr>
                    <th>Package Name</th>
                    <th>Package Price</th>
                    <th>Package List</th>
                    <th>Duration in month (limited)</th>
                    <th>Duration in month (unlimited)</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div class="modal fade" id="packageModal" tabindex="-1">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h6 class="text-capitalize">Update package information</h6>
                        </div>
                        <div class="modal-body">

                            <form action="{{url('api/admin/package/update')}}" id="packageForm">
                                <input type="hidden" id="package_id" name="package_id">
                                <div class="form-group mb-3">
                                    <label for="package_name" class="form-label">Package Name</label>
                                    <input type="text" name="package_name" id="package_name"
                                           class="form-control">
                                </div>

                                <div class="form-group mb-3" id="freePrice">
                                    <label for="price" class="form-label price_label" id="price_label">Price</label>
                                    <input onchange="clearError(this)" type="text" class="form-control price" name="price" id="price">
                                    <span class="text-danger price_error" id="price_error"></span>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <div class="form-group mb-3">
                                            <label for="unlimited" class="form-label unlimited_label" id="unlimited_label">Duration (unlimited)</label>
                                            <input onchange="clearError(this)" type="number" class="form-control unlimited" name="unlimited" id="unlimited">
                                            <span class="text-danger unlimited_error" id="unlimited_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <div class="form-group mb-3">
                                            <label for="limited" class="form-label limited_label" id="limited_label">Duration (free)</label>
                                            <input onchange="clearError(this)" type="text" class="form-control limited" name="limited" id="limited">
                                            <span class="text-danger limited_error" id="limited_error"></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group mb-3">
                                    <label for="list" class="form-label">Add list</label>
                                    <input type="text" class="form-control" id="list1">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="list" class="form-label">Add list</label>
                                    <input type="text" class="form-control" id="list2">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="list" class="form-label">Add list</label>
                                    <input type="text" class="form-control" id="list3">
                                </div>

                                <button type="submit" id="update-button" class="btn btn-primary">Update</button>
                                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary">Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </section>


    </main>
@endsection

@push('custom-js')
    <script>

        /**
         * Change the current page title
         * */
        window.location.pathname === '/admin/package'? document.title = 'Dashboard | Package' : ''

        let constantData = {
            getPackageUrl: '/api/admin/package',
            getSinglePackageUrl: '/api/admin/package/id',
        }

        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }

        function packageHandler(id) {
            $.ajax({
                url: window.origin + constantData.getSinglePackageUrl.replace('id', id),
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
                    // $('.modal-body').html('')
                    if (res.status === 'success') {
                        $('#package_name').val(res.data.name)
                        $('#package_id').val(res.data.id)
                        $('#price').val(res.data.price)
                        $('#limited').val(res.data.limited)
                        $('#unlimited').val(res.data.unlimited)

                        if (res.data.list) {
                            $('#list1').val(res.data.list[0])
                            $('#list2').val(res.data.list[1])
                            $('#list3').val(res.data.list[2])
                        }

                        // if (res.data.name === 'Free') {
                        //     $('#freePrice').html('')
                        // }else{
                        //     $('#freePrice').html(`
                        //         <label for="price" class="form-label price_label" id="price_label">Price</label>
                        //         <input onchange="clearError(this)" type="text" class="form-control price" name="price" id="price">
                        //         <span class="text-danger price_error" id="price_error"></span>
                        //
                        //     `)
                        // }
                    }
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }, complete: function (xhr, status) {
                    $('#preloader').addClass('d-none');
                }
            });
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
                ajax: "{{url('api/admin/package/list/get-all')}}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'list', name: 'list'},
                    {data: 'limited', name: 'limited'},
                    {data: 'unlimited', name: 'unlimited'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });


        $('#packageForm').submit(function (e) {
            let token = localStorage.getItem('adminAccess')
            e.preventDefault();
            let form = $(this);

            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data)

            let listArr = []
            let list1 = $('#list1').val()
            let list2 = $('#list2').val()
            let list3 = $('#list3').val()

            if (list1) {
                listArr.push(list1)
            }
            if (list2) {
                listArr.push(list2)
            }
            if (list3) {
                listArr.push(list3)
            }

            formData.list = listArr

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
                }, complete: function (xhr, status) {
                    $('#update-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        })
    </script>
@endpush



