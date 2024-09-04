@extends('admin.master')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Users</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Users
                            </li>
                        </ol>
                    </nav>
                    <div class="pb-20 mt-15">
                        <a href="{{route('admin.user.create')}}" class="btn btn-primary btn-sm backbutton" role="button" aria-pressed="true">
                            <span class="icon-copy ti-plus"></span>
                            Add User</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pb-20">
                <table class="table" id="usersTable">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            fetchData({
                endpoint: '{{ url('api/fetchUsers') }}',
                tableId: 'usersTable',
                tableBodyId: 'usersTableBody',
                columns: [
                    { key: 'name', render: item => `<span class="table-plus">${item.name}</span>` },
                    { key: 'email' },
                    { key: 'created_at' },
                    { 
                        key: 'id', 
                        render: item => `
                            <a href="{{ url('dashboard/edit/user') }}/${item.id}" class="badge badge-primary">
                                <i class="bi-pencil"></i> Edit
                            </a>
                            <a href="#" class="badge badge-danger" onclick="confirmDelete(${item.id}, '{{ url('dashboard/fetchUsers') }}')">
                                <i class="bi-trash"></i> Delete
                            </a>
                        ` 
                    }
                ]
            });

            window.confirmDelete = function (id) {
                if (confirm("Are you sure you want to delete this user?")) {
                    deleteData({
                        endpoint: '{{ url('api/delete/user') }}',
                        id: id,
                        fetchConfig: {
                            endpoint: '{{ url('api/fetchUsers') }}',
                            tableId: 'usersTable',
                            columns: [
                                { key: 'name', render: item => `<span class="table-plus">${item.name}</span>` },
                                { key: 'email' },
                                { key: 'created_at' },
                                { 
                                    key: 'id', 
                                    render: item => `
                                        <a href="{{ url('dashboard/edit/user') }}/${item.id}" class="badge badge-primary">
                                            <i class="bi-pencil"></i> Edit
                                        </a>
                                        <a href="#" class="badge badge-danger" onclick="confirmDelete(${item.id}, '{{ url('dashboard/fetchUsers') }}')">
                                            <i class="bi-trash"></i> Delete
                                        </a>
                                    ` 
                                }
                            ]
                        }
                    });
                }
            };
        });
    </script>
@endsection
