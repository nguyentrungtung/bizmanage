@extends('frontend')

@section('content')
<div class="row">
	<input type="hidden" name="package_installed" value="<?php echo $package->installed;?>"/>
	<div id="result" class="col-md-12" style="padding-top: 200px;">
		<div class="error-v1">
			<span>Chúc mừng! Bạn đã kích hoạt thành công dịch vụ.</span>
			<p>Bắt đầu sử dụng dịch vụ <a href="https://{{ $package->domain }}">tại đây</a></p>
		</div>
	</div>
	@if ($package && !$package->installed)
	<div class="col-md-12" style="text-align: center; padding-top: 200px;">
		<input type="hidden" name="id" value="<?php echo $inputs['id'];?>"/>
		<input type="hidden" name="token" value="<?php echo $inputs['token'];?>"/>
		<button id="btn_deploy" type="button" class="btn btn-success btn-lg ">
          <span class="glyphicon glyphicon-hand-right"></span> KHỞI TẠO GÓI DỊCH VỤ
        </button>
	</div>
	@endif
</div>
@endsection

@section('script')
 <script>
$( document ).ready(function() {
	if ($('input[name="package_installed"]').val() == 0) {
    	$('#result').hide();
    	$('#btn_deploy').unbind('click').bind('click', function(){
    		var _data = {};
    		_data['id'] = $('input[name="id"]').val();
    		_data['token'] = $('input[name="token"]').val();
    		coreAjax.call(
    			'/package/deploy',
    			_data,
    			function( response ){
    				$('#result').show();
    				$('#btn_deploy').hide();
        			if (!response.success) {
        				$('.error-v1').html('<span>' + response.message + '</span>');
        			}
    			}
    		);
    	});
	}	
});
</script>
@endsection

