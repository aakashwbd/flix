@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-package">
            <h6 class="portion-title mb-5">Recent Payment</h6>


            <table class="table table-bordered data-table w-100">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Package Name</th>
                    <th>Buy at</th>
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
        window.location.pathname === '/admin/recent-payment'? document.title = 'Dashboard | Payment' : ''


        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('api/admin/recent-payment/all')}}",
                columns: [
                    {data: 'user.username', name: 'user.username'},
                    {data: 'package.name', name: 'package.name'},
                    {data: 'created_at', name: 'created_at'},
                ]
            });
        });


    </script>
@endpush
