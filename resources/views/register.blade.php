<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="_token" content="{{ csrf_token() }}">
<title>Laravel</title>

<!-- Core CSS - Include with every page -->
<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}"
	rel="stylesheet">
<link
	href="{{ asset('/js/plugins/bootstrap-dialog/css/bootstrap-dialog.css') }}"
	rel="stylesheet">
	<link href="{{ asset('/css/ajax-loader.css') }}" rel="stylesheet">
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
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Đăng ký dịch vụ 4biz</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div id="form-register" class="form-horizontal">
					<div class="form-group">
						<label for="category" class="col-sm-2 control-label">Loại dịch vụ</label>
						<div class="col-sm-10">
							<select id="category", name="category" class="form-control">
								@foreach ($categories as $category)
								  <option value="{{ $category->id }}">{{ $category->name }}</option>
								  @endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="shop_name" class="col-sm-2 control-label">Tên shop</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="shop_name" name="shop_name">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email">
						</div>
					</div>
					<div class="form-group">
						<label for="address" class="col-sm-2 control-label">Address</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="address" name="address">
						</div>
					</div>
					<div class="form-group">
						<label for="city" class="col-sm-2 control-label">Thành phố</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="city" name="city">
						</div>
					</div>
					<div class="form-group">
						<label for="domain" class="col-sm-2 control-label">Domain</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="domain" name="domain">
						</div>
					</div>
					<div class="form-group">
						<label for="account" class="col-sm-2 control-label">Tên đăng nhập</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="account" name="account">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">Mật khẩu</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="password" name="password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button id="register" type="button" class="btn btn-default">Đăng ký</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /#wrapper -->
	<!-- Scripts -->
	<script src="{{ asset('/js/jquery-1.10.2.js') }}"></script>
	<script src="{{ asset('/js/jquery-ui.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/js/plugins/bootstrap-dialog/js/bootstrap-dialog.js') }}"></script>
	<script src="{{ asset('/js/common.js') }}"></script>
	<script src="{{ asset('/js/validate.js') }}"></script>
	<script src="{{ asset('/js/core-ajax.js') }}"></script>
	<script src="{{ asset('/js/core-dialog.js') }}"></script>
	<script>
	$( document ).ready(function() {
		$('#register').unbind('click').bind('click', function() {
			var _data = {};

			$('#form-register input').each(function(){
				_data[$(this).attr('name')] = $(this).val();
			});
			_data['category'] = $('#category').val();
			
			coreAjax.call(
				'/package/create',
				_data,
				function(response)
				{
					if (response.success) {
						BootstrapDialog.alert('Bạn đã đăng ký dịch vụ 4biz! Để sử dụng hãy kích hoạt dịch vụ qua email. Thanks!');
					} else {
						BootstrapDialog.alert(response.message);
					}
				}
			);
		});
	});
	</script>
</body>
</html>
