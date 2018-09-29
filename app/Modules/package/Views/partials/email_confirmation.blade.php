<html>
	<head>
		<title>Laravel</title>
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p>Bạn vừa đăng ký sử dụng dịch vụ của 4BIZ kích hoạt theo đường dẫn sau:</p>
					<a href="<?php echo url('/'); ?>/package/confirm?id=<?php echo $package->id; ?>&token=<?php echo md5($package->id . env('APP_KEY')); ?>" target="_blank">Click link để kích hoạt</a>
					<br/>
					<p>THÔNG TIN SHOP:</p>
					<p>Tên shop: {{$package->name}}</p>
					<p>Domain: http://{{$package->domain}}.4biz.vn</p>
					<p>Tên đăng nhập: {{$package->account}}</p>
					<p>Mật khẩu: {{$package->password}}</p>
					<br/>
					<br/>
					<br/>
				</div>
			</div>
		</div>
	</body>
</html>
