<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<title>4BIZ ...</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="_token" content="{{ csrf_token() }}">
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">

	<!-- CSS Global Compulsory -->
	<link rel="stylesheet" href="{{ asset('/frontend/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/frontend/assets/css/style.css') }}">

	<!-- CSS Header and Footer -->
	<link rel="stylesheet" href="{{ asset('/frontend/assets/css/headers/header-default.css') }}">
	<link rel="stylesheet" href="{{ asset('/frontend/assets/css/footers/footer-v1.css') }}">

	<!-- CSS Implementing Plugins -->
	<link rel="stylesheet" href="{{ asset('/frontend/assets/plugins/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('/frontend/assets/plugins/line-icons/line-icons.css') }}">
	<link rel="stylesheet" href="{{ asset('/frontend/assets/plugins/font-awesome/css/font-awesome.min.css') }}">

	<!-- CSS Page Style -->
	<link rel="stylesheet" href="{{ asset('/frontend/assets/css/pages/page_404_error.css') }}">

	<!-- CSS Theme -->
	<link rel="stylesheet" href="{{ asset('/frontend/assets/css/theme-colors/default.css') }}" id="style_color">
	<link rel="stylesheet" href="{{ asset('/frontend/assets/css/theme-skins/dark.css') }}">

	<!-- CSS Customization -->
	<link rel="stylesheet" href="{{ asset('/frontend/assets/css/custom.css') }}">
	<link href="{{ asset('/css/ajax-loader.css') }}" rel="stylesheet">
	
	@yield('external_css')
	<script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!};
	</script>
</head>

<body>
	<div class="wrapper">
		<!--=== Content Part ===-->
		<div class="container content">
			@yield('content')
		</div>
		<!--=== End Content Part ===-->
	</div><!--/wrapper-->

	<!-- JS Global Compulsory -->
	<script type="text/javascript" src="{{ asset('/frontend/assets/plugins/jquery/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/frontend/assets/plugins/jquery/jquery-migrate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/frontend/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<!-- JS Implementing Plugins -->
	<script type="text/javascript" src="{{ asset('/frontend/assets/plugins/back-to-top.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/frontend/assets/plugins/smoothScroll.js') }}"></script>
	<!-- JS Customization -->
	<script type="text/javascript" src="{{ asset('/frontend/assets/js/custom.js') }}"></script>
	<!-- JS Page Level -->
	<script type="text/javascript" src="{{ asset('/frontend/assets/js/app.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/frontend/assets/js/plugins/style-switcher.js') }}"></script>
	
	<script src="{{ asset('/js/core-ajax.js') }}"></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			App.init();
			StyleSwitcher.initStyleSwitcher();

			jQuery('#register').unbind('click').bind('click', function() {
				var _data = {};

				jQuery('#form-register input').each(function(){
					_data[jQuery(this).attr('name')] = jQuery(this).val();
				});
				_data['category'] = jQuery('#category').val();
				
				coreAjax.call(
					'/package/create',
					_data,
					function(response)
					{
						if (!response.success) {
							jQuery('#error-msg').text('* ' + response.message);
						} else {
							window.location = APP_URL + '/package/register-success';
						}
					}
				);
			});
		});
	</script>
<!--[if lt IE 9]>
	<script src="{{ asset('/frontend/assets/plugins/respond.js') }}"></script>
	<script src="{{ asset('/frontend/assets/plugins/html5shiv.js') }}"></script>
	<script src="{{ asset('/frontend/assets/plugins/placeholder-IE-fixes.js') }}"></script>
	<![endif]-->
	@yield('script')
</body>
</html>
