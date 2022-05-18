<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <div class="signup-content">
                    <h4 class="text-capitalize text-center">Sign Up</h4>
                    <hr>
                    <div class="d-flex align-items-center justify-content-center">
                        <span>already have account? </span>
                        <button class="btn text-capitalize">login</button>
                    </div>

                    <form action="{{url('/api/auth/register')}}" id="registerForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" id="name_label" class="form-label name_label">Name</label>
                            <input class="form-control rounded-0 py-2 name" id="name" name="name" type="text"
                                   placeholder="Name"
                                   onchange="clearError(this)">
                            <span class="text-danger name_error" id="name_error"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" id="email_label" class="form-label email_label">Email</label>
                            <input class="form-control rounded-0 py-2 email" id="email" name="email" type="email"
                                   placeholder="Email"
                                   onchange="clearError(this)">
                            <span class="text-danger email_error" id="email_error"></span>
                        </div>


                        <div class="form-group mb-3">
                            <label for="password" class="form-label password_label" id="password_label">Password</label>
                            <input class="form-control rounded-0 py-2 password" id="password" name="password" type="password"
                                   placeholder="Password" onchange="clearError(this)">
                            <span class="text-danger password_error" id="password_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label confirm_password_label" id="confirm_password_label">Confirm
                                Password</label>
                            <input class="form-control rounded-0 py-2 password_confirmation" id="password_confirmation"
                                   name="password_confirmation"
                                   type="password" placeholder="Confirm Password" onchange="clearError(this)">
                            <span class="text-danger password_confirmation_error" id="password_confirmation_error"></span>
                        </div>

                        <button type="submit" class="btn btn-primary form-control text-capitalize my-3 rounded-0 py-2">
                            register
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('custom-js')
    <script>
        $('#registerForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            formSubmit("post", form);
        })

    </script>
@endpush
