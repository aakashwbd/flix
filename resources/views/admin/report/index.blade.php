@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-verification">
            <h6 class="portion-title mb-5">Report</h6>


            <table class="table table-bordered data-table mt-5">
                <thead>
                <tr>
                    <th>Reported User</th>
                    <th>Reported User Email</th>
                    <th>By User</th>
                    <th>By User Email</th>
                    <th>Reports</th>
                    <th>message</th>
                    <th>Reported Time</th>
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
        window.location.pathname === '/admin/report'? document.title = 'Dashboard | Reports' : ''




        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('api/admin/alert/all-list')}}",
                columns: [
                    {data: 'reported_user.username', name: 'reported_user.username'},
                    {data: 'reported_user.email', name: 'reported_user.email'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'user.email', name: 'user.email'},
                    {data: 'reports', name: 'reports'},
                    {data: 'message', name: 'message'},
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
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr);
                }
            });
        }
    </script>
@endpush


