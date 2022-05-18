@include('partial.admin.header')
<div class="container-fluid py-5">
    <div class="row py-5">
        <div class="col-lg-4 col-sm-12 offset-lg-4">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <h4>Login</h4>
                        <span></span>
                    </div>

                    <form action="{{url('/api/auth/login')}}" id="adminLoginForm">

                        <div class="form-group mb-3">
                            <label for="email" class="form-label email_label" id="email_label">Email</label>
                            <input type="email" class="form-control py-2 rounded-0 email" id="email"
                                   placeholder="example@example.com" onchange="clearError(this)">
                            <span class="text-danger email_error" id="email_error"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label password_label" id="password_label">Password</label>
                            <input type="password" name="password" class="form-control py-2 rounded-0 password" id="password"
                                   placeholder="******" onchange="clearError(this)">
                            <span class="text-danger password_error" id="password_error"></span>
                        </div>

                        <button type="submit" id="submit-button" class="btn btn-primary text-capitalize mb-3 form-control rounded-0 py-2">
                            login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-js')
    <script>
        /**
        * Change the current page title
        * */
        window.location.pathname === '/admin/auth/login'? document.title = 'Dashboard | Login' : ''

        /**
         * Form submit for admin login
         * */
        $('#adminLoginForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data)
            let url = form.attr('action');

            let email = $('#email').val()

            if( email === "" ){
                $('#email').addClass('is-invalid')
                $('#email_label').addClass('text-danger')
                $('#email_error').text('The email filed is required')
            }else{
                formData.email = email
            }

            $.ajax({
                type: "post",
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }, beforeSend: function () {
                    $('#submit-button').prop('disabled', true);
                },
                success: function (response) {
                    if(response.status === 'success'){
                        toastr.success(response.message)
                        localStorage.setItem('adminAccess', response.data.token)
                        localStorage.setItem('adminInfo',JSON.stringify(response.data.user))
                        window.location.href = window.origin + '/admin'
                    }

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
                },
                complete: function (xhr, status) {
                    $('#submit-button').prop('disabled', false);
                }
            });
        })

        /**
         * Form input remove errors
         * */
        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }

    </script>
@endpush


@include('partial.admin.footer')


