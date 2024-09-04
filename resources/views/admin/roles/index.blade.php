@extends('admin.master')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Roles</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Roles
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pb-20">
                <table class="table" id="rolesTable">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="rolesTableBody">
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
                endpoint: '{{ url('api/fetchRoles') }}',
                tableId: 'rolesTable',
                tableBodyId: 'rolesTableBody',
                columns: [
                    { key: 'name', render: item => `<span class="table-plus">${item.name}</span>` },
                    { key: 'created_at' },
                    { 
                        key: 'id', 
                        render: item => `
                            <a href="{{ url('dashboard/edit/role') }}/${item.id}" class="badge badge-primary">
                                <i class="bi-pencil"></i> Edit
                            </a>
                            <a href="#" class="badge badge-danger" onclick="confirmDelete(${item.id}, '{{ url('dashboard/fetchRoles') }}')">
                                <i class="bi-trash"></i> Delete
                            </a>
                        ` 
                    }
                ]
            });
            window.confirmDelete = function (id) {
                if (confirm("Are you sure you want to delete this role?")) {
                    deleteData({
                        endpoint: '{{ url('api/delete/role') }}',
                        id: id,
                        fetchConfig: {
                            endpoint: '{{ url('api/fetchRoles') }}',
                            tableId: 'rolesTable',
                            columns: [
                                { key: 'name', render: item => `<span class="table-plus">${item.name}</span>` },
                                { key: 'created_at', render: item => moment(item.created_at).format('MMMM Do YYYY, h:mm:ss a') },
                                { 
                                    key: 'id', 
                                    render: item => `
                                        <a href="{{ url('dashboard/edit/role') }}/${item.id}" class="badge badge-primary">
                                            <i class="bi-pencil"></i> Edit
                                        </a>
                                        <a href="#" class="badge badge-danger" onclick="confirmDelete(${item.id})">
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
