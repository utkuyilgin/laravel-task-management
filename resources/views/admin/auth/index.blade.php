@extends('admin.auth.layouts.master')

@section('content')
<div class="container">
	<div class="row align-items-center">
		<div class="col-md-6 col-lg-7">
			<img src="{{ asset('adminassets/images/login-page-img.png')}}" alt="" />
		</div>
		<div class="col-md-6 col-lg-5">
			<div class="login-box bg-white box-shadow border-radius-10">
				<div class="login-title">
					<h2 class="text-center text-primary">Login</h2>
				</div>
				<form method="post" action="{{route('admin.login')}}">
					@csrf
					<div class="input-group custom">
						<input
							type="email"
							class="form-control form-control-lg"
							placeholder="E-Mail"
							name="email"
							value="{{ old('email') }}"
						/>
						<div class="input-group-append custom">
							<span class="input-group-text"
								><i class="icon-copy dw dw-user1"></i
							></span>
						</div>
					</div>
					<div class="input-group custom">
						<input
							type="password"
							class="form-control form-control-lg"
							placeholder="**********"
							name="password"
						/>
						<div class="input-group-append custom">
							<span class="input-group-text"
								><i class="dw dw-padlock1"></i
							></span>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="input-group mb-0">

							<input type="submit" class="btn btn-primary btn-lg btn-block" value="Login">
							</div>


						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
