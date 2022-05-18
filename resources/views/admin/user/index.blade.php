@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-user">
            <h6 class="portion-title mb-5">Manage User</h6>

            <table class="table table-bordered data-table mt-5">
                <thead>
                <tr>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Created Time</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>

    </main>
@endsection

@push('custom-js')
    <script>
        /**
         * Change the current page title
         * */
        window.location.pathname === '/admin/manage-users'? document.title = 'Dashboard | Users' : ''

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('api/admin/user/all-users')}}",
                columns: [
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                ]
            });
        });

        function userHandler(id){

            let form_data = new FormData();
            form_data.append('status', 'active')
            $.ajax({
                url: window.origin + '/api/user/'+id,
                type: "POST",
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: form_data,
                success: function (res) {
                    toastr.success(res.message)

                    window.setTimeout( function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr);
                }
            });
        }

        function userBannedHandler(id){

            let form_data = new FormData();
            form_data.append('status', 'suspend')
            $.ajax({
                url: window.origin + '/api/user/'+id,
                type: "POST",
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: form_data,
                success: function (res) {
                    toastr.success(res.message)

                    window.setTimeout( function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr);
                }
            });
        }
    </script>
@endpush

