@extends('admin.master')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tasks</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tasks - {{$project->name}}
                            </li>
                        </ol>
                    </nav>
                    <div class="pb-20 mt-15">
                        <a href="{{route('admin.task.create', $project->id)}}" class="btn btn-primary btn-sm backbutton" role="button" aria-pressed="true">
                            <span class="icon-copy ti-plus"></span>
                            Add Task</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pb-20">
                <table class="table" id="taskTable">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th>Project</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="taskTableBody">
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

    let project_id = '{{ $project->id }}';

    console.log(project_id);
    
    fetchData({
        endpoint: '{{ url('api/fetchTasks') }}/' + project_id,
        tableId: 'taskTable',
        tableBodyId: 'taskTableBody',
        columns: [
            { key: 'name', render: item => `<span class="table-plus">${item.name}</span>` },
            { key: 'project.name', render: item => item.project.name },
            { key: 'created_at', render: item => moment(item.created_at).format('MMMM Do YYYY, h:mm:ss a') },
            { 
                key: 'id', 
                render: item => `
                    <a href="{{ url('dashboard/edit/task') }}/${item.id}" class="badge badge-primary">
                        <i class="bi-pencil"></i> Edit
                    </a>
                    <a href="#" class="badge badge-danger" onclick="confirmDelete(${item.id}, '{{ url('api/fetchTasks') }}')">
                        <i class="bi-trash"></i> Delete
                    </a>
                ` 
            }
        ]
    });
        

    window.confirmDelete = function (id) {
        if (confirm("Are you sure you want to delete this role?")) {
            deleteData({
                endpoint: '{{ url('api/delete/task') }}',
                id: id,
                fetchConfig: {
                    endpoint: '{{ url('api/fetchTasks') }}' + '/' + project_id,
                    tableId: 'taskTable',
                    columns: [
                        { key: 'name', render: item => `<span class="table-plus">${item.name}</span>` },
                        { key: 'project.name', render: item => item.project.name },
                        { key: 'created_at', render: item => moment(item.created_at).format('MMMM Do YYYY, h:mm:ss a') },
                        { 
                            key: 'id', 
                            render: item => `
                                <a href="{{ url('dashboard/edit/task') }}/${item.id}" class="badge badge-primary">
                                    <i class="bi-pencil"></i> Edit
                                </a>
                                <a href="#" class="badge badge-danger" onclick="confirmDelete(${item.id}, '{{ url('api/fetchTasks') }}')">
                                    <i class="bi-trash"></i> Delete
                                </a>
                            ` 
                        }
                    ]
                }
            });
        }
    };

    // Export the fetchData function
    window.fetchData = fetchData;
    window.deleteData = deleteData;
});

</script>
@endsection