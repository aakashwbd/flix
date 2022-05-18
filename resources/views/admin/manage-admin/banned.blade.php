@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-user">
            <h6 class="portion-title mb-3">Banned User</h6>
        </section>
        <table class="table table-bordered data-table mt-5">
            <thead>
            <tr>
                <th>User Name</th>
                <th>User Email</th>
                <th>Account Created</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </main>
@endsection

@push('custom-js')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('api/admin/user/get-all')}}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush

