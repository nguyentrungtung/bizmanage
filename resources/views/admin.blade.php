<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="_token" content="{{ csrf_token() }}">
	<title>Hệ thống quản lý dịch vụ 4biz</title>
	
	<!-- Core CSS - Include with every page -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/plugins/dataTables/jquery.dataTables.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('/js/plugins/bootstrap-dialog/css/bootstrap-dialog.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/plugins/bootstrap-datetimepicker.css') }}" rel="stylesheet">
	
	<link href="{{ asset('/css/sb-admin.css') }}" rel="stylesheet">
	@yield('external_css')

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!};
	</script>
	
</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			@include('partials.navbar-header')
			@include('partials.navbar-right')
			@include('partials.slidebar-left')
		</nav>
		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
	</div>
    <!-- /#wrapper -->
	<!-- Scripts -->
	<script src="{{ asset('/js/jquery-1.10.2.js') }}"></script>
	<script src="{{ asset('/js/jquery-ui.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/plugins/metisMenu/metisMenu.min.js') }}"></script>
	<script src="{{ asset('/js/plugins/dataTables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('/js/plugins/bootstrap-dialog/js/bootstrap-dialog.js') }}"></script>
	<script src="{{ asset('/js/plugins/tinymce/tinymce.min.js') }}"></script>
	
	<script src="{{ asset('/js/plugins/moment.js') }}"></script>
	<script src="{{ asset('/js/plugins/bootstrap-datetimepicker.js') }}"></script>
	<script src="{{ asset('/js/plugins/moment-with-locales.js') }}"></script>
		
	<script src="{{ asset('/js/common.js') }}"></script>
	<script src="{{ asset('/js/validate.js') }}"></script>
	<script src="{{ asset('/js/core-ajax.js') }}"></script>
	<script src="{{ asset('/js/core-dialog.js') }}"></script>
	<script src="{{ asset('/js/sb-admin.js') }}"></script>
	@yield('script')
</body>
</html>
