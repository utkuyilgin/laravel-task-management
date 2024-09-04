@extends('admin.master')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Create Task</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tasks
                            </li>
                            
                            <li class="breadcrumb-item active" aria-current="page">
                                Create
                            </li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>



        <div class="card-box mb-30">

            <div class="pb-20">

                <a href="{{route('admin.user.index')}}" class="btn btn-danger btn-sm backbutton" role="button" aria-pressed="true">

                    <span class="icon-copy ti-control-backward"></span>
                    Back</a>

            </div>
        </div>


        <!-- Form Start -->


        <form>
            @csrf
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                <div class="col-sm-12 col-md-10">
                    <input required value="" class="form-control" name="name" type="text" placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Description</label>
                <div class="col-sm-12 col-md-10">
                    <input required value="" class="form-control" name="description" type="text" placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Project</label>
                <div class="col-sm-12 col-md-10">
                    <select required class="form-control" name="project_id">
                        @foreach($projects as $project)
                        <option
                        
                        @if ($project->id == $currentProject->id)
                            selected
                            
                        @endif

                        value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Status</label>
                <div class="col-sm-12 col-md-10">
                    <select required class="form-control" name="status">
                        <option value="todo">Todo</option>
                        <option value="in_progress">In Progress</option>
                        <option value="done">Done</option>
                    </select>
                </div>
            </div>

           

            <input id="send" type="submit" class="btn btn-success addbutton" value="Save">


        </form>


        <!-- Form End -->

    </div>



</div>
@endsection
@section('js')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script> 
$(document).ready(function() {
    $('select').select2();

    let project_id = '{{ $currentProject->id }}';

    $('#send').on('click', function(e) {
        e.preventDefault();
        postData({
            endpoint: '{{ url('api/create/task') }}',
            data: {
                name: $('input[name=name]').val(),
                description: $('input[name=description]').val(),
                project_id: $('select[name=project_id]').val(),
                status: $('select[name=status]').val()
            },
            redirect: '{{ url('dashboard/tasks/') }}' + '/' + project_id
        });
    });

});



</script>
@endsection