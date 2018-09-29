@extends('admin') @section('external_css') @endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Thêm mới gói sản phẩm</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	@if (count($errors) > 0)
	<div class="alert alert-danger">
		<ul class="padding-0">
			<li>Dữ liệu không đúng!</li>
		</ul>
	</div>
	@endif
</div>
<form id="form-create-email-template" action="{{ url('package/save') }}"
	method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" /> <input
		type="hidden" name="id" value="-1" />
	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label for="customer_id">Họ và tên:</label> <input
					id="customer_name" type="text" class="form-control"
					name="customer_name">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label for="customer_id">Số điện thoại:</label> <input
					id="customer_name" type="text" class="form-control"
					name="customer_phone">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label for="customer_id">Email:</label> <input id="customer_name"
					type="text" class="form-control" name="customer_email">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label for="customer_id">Địa chỉ:</label> <input id="customer_name"
					type="text" class="form-control" name="customer_address">
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<label>Loại gói:</label>
			<div class="radio">
				<label class="radio-inline"> <input type="radio" checked name="type"
					id="type_biz" value="biz"> biz
				</label>
			</div>
			<div class="radio">
				<label class="radio-inline"> <input type="radio" name="type"
					id="type_pos" value="pos"> pos
				</label>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label for="name">Tên gói:</label> <input id="shop_name" type="text"
					class="form-control" name="shop_name" placeholder="Tên gói">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label for="domain">Tên miền:</label> <input id="domain" type="text"
					class="form-control" name="domain" placeholder="Tên miền">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label for="account">Tài khoản đăng nhập:</label> <input
					id="account" type="text" class="form-control" name="account"
					placeholder="Tài khoản đăng nhập">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label for="account">Mật khẩu:</label> <input id="password"
					type="text" class="form-control" name="password">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6" style="padding-top: 10px;">
			<div class="form-group">
				<label>Loại gói:</label> <select class="select2" name="category"
					style="width: 100%"> @foreach($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12" style="padding-top: 10px;">
			<div class="form-group">
				<label for="settings">Cài đặt gói:</label>
				<textarea type="text" class="form-control tinymce" rows="10"
					name="settings" placeholder="Ghi chú"></textarea>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12" style="margin-top: 20px; margin-bottom: 20px;">
			<input class="btn btn-primary btn-save" type="submit" value="Lưu"> <input
				class="btn btn-danger btn-clear" type="button" value="Hủy">
		</div>
	</div>
</form>

@endsection
