@extends('admin.master')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Projects</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Projects
                            </li>
                        </ol>
                    </nav>
                    <div class="pb-20 mt-15">
                        <a href="{{route('admin.project.create')}}" class="btn btn-primary btn-sm backbutton" role="button" aria-pressed="true">
                            <span class="icon-copy ti-plus"></span>
                            Add Project</a>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="card-box mb-30">
            <div class="pb-20">
                <table class="table" id="projectTable">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="projectTableBody">
                        <!-- Rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Export Datatable End -->
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/dataRender/datetime.js" charset="utf8"></script>
<script>
$(document).ready(function () {

    // Initialize and fetch projects
    fetchProjects();

    // Fetch projects and populate table
    function fetchProjects() {
        fetchData({
            endpoint: '{{ url("api/fetchProjects") }}',
            tableId: 'projectTable',
            tableBodyId: 'projectTableBody',
            columns: [
                { key: 'name', render: item => `<span class="table-plus">${item.name}</span>` },
                { key: 'created_at', render: item => moment(item.created_at).format('MMMM Do YYYY, h:mm:ss a') },
                { 
                    key: 'id', 
                    render: item => generateActionButtons(item)
                }
            ]
        });
    }

    // Generate action buttons HTML
    function generateActionButtons(item) {
        return `
            @can('view task')
                <a href="{{ url('dashboard/tasks') }}/${item.id}" class="badge badge-primary">
                    <i class="bi-pencil"></i> Tasks
                </a>
            @endcan
            
                <a href="{{ url('dashboard/edit/project') }}/${item.id}" class="badge badge-primary">
                    <i class="bi-pencil"></i> Edit
                </a>
            
            
                <a href="#" class="badge badge-danger" onclick="confirmDelete(${item.id}, '{{ url('api/deleteProject') }}')">
                    <i class="bi-trash"></i> Delete
                </a>    
            
        `;
    }

    // Confirm delete with a modal
    window.confirmDelete = function (id, endpoint) {
        if (confirm("Are you sure you want to delete this item?")) {
            deleteData({
                endpoint: '{{ url('api/delete/project') }}',
                id: id,
                fetchConfig: {
                    endpoint: '{{ url("api/fetchProjects") }}',
                    tableId: 'projectTable',
                    tableBodyId: 'projectTableBody',
                    columns: [
                        { key: 'name', render: item => `<span class="table-plus">${item.name}</span>` },
                        { key: 'created_at', render: item => moment(item.created_at).format('MMMM Do YYYY, h:mm:ss a') },
                        { 
                            key: 'id', 
                            render: item => generateActionButtons(item)
                        }
                    ]
                }
            });
        }
    };

   

    
});
</script>
@endsection
