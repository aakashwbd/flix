@extends('layouts.admin.index')
@section('content')

    <main class="main">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <form action="{{url('api/admin/profile-update')}}" id="adminForm">
                    <div class="form-group mb-2">
                        <label for="name" class="form-label name_label" id="name_label">Name</label>
                        <input type="text" class="form-control py-2 rounded-0" id="name" name="name"
                               placeholder="John Doe">
                        <span class="text-danger name_error" id="name_error"></span>
                    </div>


                    <div class="form-group mb-2">
                        <label for="email" class="form-label email_label" id="email_label">Email</label>
                        <input readonly type="email" class="form-control py-2 rounded-0" id="email"
                               placeholder="example@example.com">
                        <span class="text-danger email_error" id="email_error"></span>
                    </div>

                    <div class="form-group mb-2">
                        <label for="phone" class="form-label phone_label" id="phone_label">Phone</label>
                        <input type="text" class="form-control py-2 rounded-0" name="phone" id="phone"
                               placeholder="">
                    </div>



                    <div class="d-flex align-items-center">

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                        <a href="{{url('/admin')}}">
                        <button type="button" class="btn btn-outline-secondary ms-2" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </main>
@endsection
@include('partial.admin.footer')
@push('custom-js')
    <script>
        $(document).ready(function (){
            let admin = JSON.parse(localStorage.getItem('adminInfo'))
            if(admin){
                $('#name').val(admin.name)
                $('#email').val(admin.email)
                $('#phone').val(admin.phone)
            }

        })





        $('#adminForm').submit(function (e) {
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
                    localStorage.removeItem('adminInfo')
                    localStorage.setItem('adminInfo', JSON.stringify(response.user) )

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





