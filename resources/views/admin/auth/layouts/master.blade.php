<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Login</title>

		<!-- Site favicon -->
        <link href="{{asset('favicon.ico')}}" rel="shortcut icon" />

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="{{ asset('adminassets/styles/core.css')}}" />
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('adminassets/styles/icon-font.min.css')}}"
		/>
		<link rel="stylesheet" type="text/css" href="{{ asset('adminassets/styles/style.css')}}" />




	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>


			</div>
		</div>
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
		@yield('content')
		</div>


		<!-- welcome modal end -->
		<!-- js -->
		<script src="{{ asset('adminassets/scripts/core.js') }}"></script>
		<script src="{{ asset('adminassets/scripts/script.min.js') }}"></script>
		<script src="{{ asset('adminassets/scripts/process.js') }}"></script>
		<script src="{{ asset('adminassets/scripts/layout-settings.js') }}"></script>
	</body>
</html>
