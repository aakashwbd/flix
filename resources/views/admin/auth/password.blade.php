@extends('layouts.admin.index')
@section('content')

    <main class="main">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <form action="{{url('api/admin/update-password')}}" id="adminLoginForm">

                    <div class="form-group mb-3">
                        <label for="password" class="form-label password_label" id="password_label">Password</label>
                        <input type="password" name="password" class="form-control py-2 rounded-0 password" id="password"
                               placeholder="******">
                        <span class="text-danger password_error" id="password_error"></span>
                    </div>
{{--                    <div class="form-group mb-3">--}}
{{--                        <label for="password" class="form-label password_label" id="password_label">Confirm Password</label>--}}
{{--                        <input type="password" name="password" class="form-control py-2 rounded-0 password" id="password"--}}
{{--                               placeholder="******">--}}
{{--                        <span class="text-danger password_error" id="password_error"></span>--}}
{{--                    </div>--}}

                    <button type="submit" class="btn btn-primary text-capitalize mb-3 form-control rounded-0 py-2">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

    </main>
@endsection
@include('partial.admin.footer')
@push('custom-js')
    <script>
        $('#adminLoginForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let token = localStorage.getItem('adminAccess')


            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data)

            let url = form.attr('action');

            $.ajax({
                type: "patch",
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                success: function (response) {
                    toastr.success(response.message)

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
                }
            });
        })

    </script>
@endpush





