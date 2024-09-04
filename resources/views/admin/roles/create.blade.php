@extends('admin.master')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>New Role</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Role
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
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input required type="text" name="name" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permission:</strong>
                            <br/>
                            @php
                                $count = 0;
                            @endphp
                            @foreach($permissions as $permission)
                                @php
                                    $parts = explode('-', $permission->name);
                                    $index = $parts[0];
                                    $groupedPermissions[$index][] = $permission;
                                @endphp
                            @endforeach
                            @foreach($groupedPermissions as $index => $permissionGroup)
                                @if($count % 3 == 0)
                                    <div class="row">
                                        @endif

                                        <div class="col-md-4">
                                            <div class="container">
                                                <h4 style="margin-bottom: 10px;">{{ ucfirst($index) }}</h4>
                                                <ul class="list-group">
                                                    @foreach($permissionGroup as $permission)
                                                        <label>
                                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}" class="name"
                                                                >
                                                            {{  $permission->name }}
                                                        </label>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        @if($count % 3 == 2 || $loop->last)
                                    </div>
                                @endif
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            <input id="send" type="submit" class="btn btn-success addbutton" value="Save">
        </form>
    </div>
</div>
@endsection
@section('js')

<script>
    $(document).ready(function () {
        $('#send').on('click', function (e) {
            e.preventDefault();
            let permission = [];
            $.each($("input[name='permission[]']:checked"), function(){
                permission.push($(this).val());
            });
            postData({
                endpoint: '{{url('api/create/role')}}',
                data: {
                    name: $('input[name=name]').val(),
                    permission: permission,
                },
                redirect: '{{ route('admin.role.index') }}'
            });
        });
    });
</script>

@endsection