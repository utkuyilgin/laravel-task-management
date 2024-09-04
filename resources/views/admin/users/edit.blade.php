@extends('admin.master')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Edit User</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Users
                            </li>
                            
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit
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
                    <input required value="{{$user->name}}" class="form-control" name="name" type="text" placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                <div class="col-sm-12 col-md-10">
                    <input required value="{{$user->email}}" class="form-control" name="email" type="email" placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Roles</label>
                <div class="col-sm-12 col-md-10">
                    <select required class="custom-select col-12 js-example-basic-multiple" name="role_ids[]" multiple="multiple">
                        
                        @foreach($roles as $role)
                        <option value="{{$role->id}}" 
                            
                            @if(in_array($role->id, $user->roles->pluck('id')->toArray()))
                            selected
                            @endif

                            >{{$role->name}}</option>
                        @endforeach
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

    $('#send').on('click', function(e) {
        e.preventDefault();
        var name = $('input[name="name"]').val();
        var email = $('input[name="email"]').val();
        var role_ids = $('select[name="role_ids[]"]').val();
        
        updateData({
            endpoint: '{{ url('api/update/user') }}' + '/' + '{{ $user->id }}',
            data: {
                name: name,
                email: email,
                role_ids: role_ids
            },
            redirect: '{{ url('dashboard/users') }}'
        });
    });
});
</script>
@endsection