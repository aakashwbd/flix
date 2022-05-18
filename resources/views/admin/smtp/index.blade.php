@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <h6 class="portion-title mb-5">Manage SMTP</h6>
        <form action="{{url('api/admin/smtp/store')}}" class="w-50" id="smtpForm">
            <div class="form-group mb-3">
                <label for="host" id="host_label" class="form-label host_label">Host</label>
                <input type="text" class="form-control host" name="host" id="host" placeholder="Host" onchange="clearError(this)">
                <span class="text-danger host_error" id="host_error"></span>
            </div>

            <div class="form-group mb-3">
                <label for="port" id="port_label" class="form-label port_label">Port</label>
                <input type="text" class="form-control port" name="port" id="port" placeholder="Port" onchange="clearError(this)">
                <span class="text-danger port_error" id="port_error"></span>
            </div>

            <div class="form-group mb-3">
                <label for="host" id="username_label" class="form-label username_label">Username</label>
                <input type="text" class="form-control username" name="username" id="username" placeholder="Username" onchange="clearError(this)">
                <span class="text-danger username_error" id="username_error"></span>
            </div>

            <div class="form-group mb-3">
                <label for="port" id="password_label" class="form-label password_label">Password</label>
                <input type="text" class="form-control password" name="password" id="password" placeholder="Password" onchange="clearError(this)">
                <span class="text-danger password_error" id="password_error"></span>
            </div>

            <div class="form-group mb-3">
                <label for="encryption" class="form-label">Encryption</label>
                <select name="encryption" class="form-select" id="encryption">
                    <option value="tls" selected>TLS</option>
                    <option value="ssl">SSL</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary my-3" id="submit-button">Save</button>
            <a href="{{url('/admin')}}" class="btn btn-outline-secondary my-3">Cancel</a>
        </form>


    </main>

@endsection

@push('custom-js')
    <script>
        /**
         * Change the current page title
         * */
        window.location.pathname === '/admin/smtp'? document.title = 'Dashboard | SMTP' : ''

        $('#smtpForm').submit(function (e) {
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



        $(document).ready(function () {
            $.ajax({
                type: 'get',
                url: window.origin + '/api/admin/smtp/fetch',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    $('#host').val(response.data[0].host)
                    $('#port').val(response.data[0].port)
                    $('#username').val(response.data[0].username)
                    $('#password').val(response.data[0].password)
                    $('#encryption').val(response.data[0].encryption)
                    $('#submit-button').text('Update')
                },
                error: function (xhr, resp, text) {
                    console.log(xhr, resp)
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
