@extends('admin')
@section('external_css')

@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Tạo mẫu email</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<form id="form-create-email-template" action="{{ url('email/save') }}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="id" value="{{ $template->id }}" />
		<div class="row">
			<div id="drop-subjects" class="col-lg-3" style="padding-top: 10px;">
				<label>Loại email:</label>
				<select class="select2" name="type" style="width: 100%">
					@foreach ($types as $type)
					<option value="{{ $type->id }}">{{ $type->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		
		<div class="row">
			<div id="drop-subjects" class="col-lg-12" style="padding-top: 10px;">
				<div class="form-group">
					<label for="email_title">Tiều đề:</label>
					<input type="text" class="form-control" name="email_title" placeholder="tiêu đề" value="{{ $template->title }}">	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div id="drop-subjects" class="col-lg-12" style="padding-top: 10px;">
				<div class="form-group">
					<label for="email_content">Nội dung:</label>
					<textarea type="text" class="form-control tinymce" rows="20" name="email_content" placeholder="tiêu đề">{{ $template->content }}</textarea>	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
				<p>active link: _LINK_</p>
				<p>tên shop: _SHOP_</p>				
				<p>tên gói dịch vụ: _PACKAGE_NAME_</p>
				<p>tên đăng nhập: _ACCOUNT_</p>
				<p>mật khẩu: _PASSWORD_</p>
				<p>thời gian hết hạn : _EXPIRY_TIME_</p>
			</div>
			<div class="col-lg-6">
				<p>tên khách hàng: _CUSTOMER_NAME_</p>
				<p>tên công ty: _CUSTOMER_COMPANY_</p>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12" style="margin-top: 20px; margin-bottom: 20px;">
				<input class="btn btn-primary btn-save" type="submit" value="Lưu">
				<input class="btn btn-danger btn-clear" type="button" value="Hủy">
			</div>
		</div>
	</form>
	
@endsection

@section('script')
<script>
tinymce.init({
	selector: "textarea.tinymce",
	menubar : false,
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste"
	],
	toolbar: "bold italic | bullist numlist outdent indent"
});
</script>
@endsection