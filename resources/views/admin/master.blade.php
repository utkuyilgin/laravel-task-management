<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Trial</title>
		<!-- Site favicon -->
        <link href="{{asset('images.png')}}" rel="shortcut icon" />
		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>
		
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="{{ asset('adminassets/styles/core.css') }}" />
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('adminassets/styles/icon-font.min.css') }}"
		/>
		<link rel="stylesheet" type="text/css" href="{{ asset('adminassets/styles/style.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('adminassets/styles/system.css') }}" />

		<style>
			.tox-statusbar {
				display: none !important;
			}
		</style>
	</head>
	<body>
		<div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-progress" id="progress_div">
					<div class="bar" id="bar1"></div>
				</div>
				<div class="percent" id="percent1">0%</div>
				<div class="loading-text">Loading...</div>
			</div>
		</div>
		<div class="header">
			<div class="header-left">
				<div class="menu-icon bi bi-list"></div>
				<div
					class="search-toggle-icon bi bi-search"
					data-toggle="header_search"
				></div>
			</div>
			<div class="header-right">				
				<div class="user-info-dropdown">
					<div class="dropdown">
						<a
							class="dropdown-toggle"
							href="#"
							role="button"
							data-toggle="dropdown"
						>
							<span class="user-icon"></span>
							<span class="user-name">{{ Auth::user()->name }}</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
							<a class="dropdown-item" href="{{route('admin.logout')}}"><i class="dw dw-logout"></i> Logout</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="left-side-bar">
			<div class="brand-logo">
				<a href="{{ url('admin/home') }}">
					<img src="{{asset('images.png')}}" alt="" class="dark-logo" />
					<img
						src="{{asset('images.png')}}"
						alt=""
						class="light-logo"
					/>
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
						<li class="dropdown">
							<a href="{{url('dashboard')}}" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-house"></span
								><span class="mtext">Home</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="{{route('admin.user.index')}}" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-person"></span
								><span class="mtext">Users</span>
							</a>
						</li>
						<li>
							<a href="javascript:;" class="dropdown-toggle">
							<i class="micon icon-copy fa fa-sitemap" aria-hidden="true"></i>
							<span class="mtext">Role</span>
							</a>
							<ul class="submenu">
								<li><a href="{{route('admin.role.create')}}">Create A Role</a></li>
								<li><a href="{{route('admin.role.index')}}">List Roles</a></li>
							</ul>
						</li>
					
						
					</ul>
				</div>
			</div>
		</div>
		<div class="mobile-menu-overlay"></div>
		<div class="main-container">
            @yield('content')
		</div>
		<!-- welcome modal end -->
		<!-- js -->

        <script src="{{ asset('adminassets/scripts/core.js') }}"></script>
		<script src="{{ asset('adminassets/scripts/script.min.js') }}"></script>
		<script src="{{ asset('adminassets/scripts/process.js') }}"></script>
		<script src="{{ asset('adminassets/scripts/layout-settings.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
		<!-- buttons for Export datatable -->
		<script src="{{ asset('src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/pdfmake.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/vfs_fonts.js') }}"></script>
		<!-- Datatable Setting js -->
		<script src="{{ asset('adminassets/scripts/datatable-setting.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		
		<script src="http://{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
		<script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>

        <script>
            $(function (){
                $(".editLesson").click(function (){
                    var id = $(this).attr("attr");
                    var name = $(this).attr("nameattr");
                    var type = $(this).attr("typeattr");
                    var video = $(this).attr("videoattr");
                    var description = $(this).attr("descriptionattr");

                    $("#uid").val(id);
                    $("#uname").val(name);
                    $("#utype").val(type);
                    $("#uvideo").val(video);
                    $("#udescription").val(description);


                });

                $(".editTown").click(function (){
                    var id = $(this).attr("attr");
                    var name = $(this).attr("nameattr");
                    var status = $(this).attr("statusattr");


                    $("#uid").val(id);
                    $("#uname").val(name);
                    $("#ustatus").val(status);

                });
            });
        </script>


<script>
	// public/js/fetchData.js
	$(document).ready(function () {
		function fetchData(config) {
			const { endpoint, tableId, tableBodyId, columns } = config;
			const table = $(`#${tableId}`).DataTable();

			$.ajax({
				url: endpoint,
				method: 'GET',
				success: function (response) {
					const data = response.data || response;
					
					if (!Array.isArray(data)) {
						console.error('Expected an array of data, but received:', data);
						return;
					}

					const rows = data.map(item => {
						let row = '<tr>';
						columns.forEach(column => {
							const value = typeof column.render === 'function' 
								? column.render(item)
								: item[column.key];
							row += `<td>${value}</td>`;
						});
						row += '</tr>';
						return row;
					}).join('');

					$(`#${tableBodyId}`).html(rows);
					table.rows.add($(`#${tableBodyId}`).find('tr')).draw();
				},
				error: function (xhr) {
					console.error('Error fetching data:', xhr);
				}
			});
		}

		function postData(config) {
			const { endpoint, data, redirect } = config;

			$.ajax({
				url: endpoint,
				method: 'POST',
				data: data,
				success: function (response) {
					toastr.success(response.message);
					if (redirect) {
						setTimeout(() => {
							window.location.href = redirect;	
						}, 1500);
					}
				},
				error: function (xhr) {
					console.error('Error posting data:', xhr);
				}
			});
		}
		
		function updateData(config) {
			
			const { endpoint, data, redirect } = config;
			console.log(redirect);
			$.ajax({
				url: endpoint,
				method: 'POST',
				data: data,
				success: function (response) {
					toastr.success(response.message);
					if (redirect) {
						setTimeout(() => {
							window.location.href = redirect;	
						}, 1500);
					}
					
				},
				error: function (xhr) {
					console.error('Error updating data:', xhr);
				}
			});
		}

		window.confirmDelete = function (id, endpoint) {
			if (confirm("Are you sure you want to delete this item?")) {
				window.location.href = `${endpoint.replace('/fetch', '/delete')}/${id}`;
			}
		};
		window.fetchData = fetchData;
		window.postData = postData;
		window.updateData = updateData;
	});

	function beep() {
		var snd = new Audio("https://restaurant.ban-go.com/assets/restaurant/bell-172780.mp3");  
		snd.play();
	}


	window.Echo.channel('laravel_database_new-task')
    .listen('NewTask', (e) => {
    
        var data = e.data;

		
        

        let message = 'New task has been created';

        toastr.success(message);
        beep();

        
            data.created_at = moment(data.created_at).format('MMMM Do YYYY, h:mm:ss a');
console.log(data);
			var tr = [
                data.name,
				data.project.name,
				data.created_at,
				`
					<a href="{{ url('dashboard/edit/task') }}/${data.id}" class="badge badge-primary">
						<i class="bi-pencil"></i> Edit </a> <a href="#" class="badge badge-danger" onclick="confirmDelete(${data.id}, '{{ url('api/fetchTasks') }}')">
						<i class="bi-trash"></i> Delete
					</a>

				`
            ];
            
            $('#taskTableBody').prepend(`<tr><td>${tr.join('</td><td>')}</td></tr>`);
            
            
            
            
        
    });

</script>

	</script>

	

	@yield('js')

    </body>
</html>
