@extends('admin.master')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>New Project</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Project
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

                <a href="{{route('admin.role.index')}}" class="btn btn-danger btn-sm backbutton" role="button" aria-pressed="true">

                    <span class="icon-copy ti-control-backward"></span>
                    Back</a>

            </div>
        </div>


        <form>
            @csrf
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" name="name" type="text" placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Description</label>
                <div class="col-sm-12 col-md-10">
                    <textarea class="form-control" name="description" rows="5"></textarea>
                </div>
            </div>

            <input id="send" type="submit" class="btn btn-success addbutton" value="Save">


        </form>


        <!-- Form End -->

    </div>



</div>
@endsection
@section('js')
<script>

    $(document).ready(function () {
          $('#send').on('click', function (e) {
          e.preventDefault();
          
            postData({
                endpoint: '{{ url('api/create/project') }}',
                data: {
                    name: $('input[name=name]').val(),
                    description: $('textarea[name=description]').val()
                },
                redirect: '{{ url('dashboard') }}'
            });
        });
    });
  </script>

@endsection