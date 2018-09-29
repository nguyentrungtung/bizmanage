@extends('frontend')

@section('content')
<div class="row margin-bottom-30">
<div class="col-md-12 mb-margin-bottom-30">
	<div class="headline">
		<h2>Đăng ký sử dụng dịch vụ 4BIZ</h2>
	</div>
	<br />
	<form id="form-register" class="sky-form contact-style">
		<fieldset class="no-padding">
			<label>Loại dịch vụ <span class="color-red">*</span></label>
			<div class="row sky-space-20" style="padding-bottom: 15px;">
				<div class="col-md-12">
					<select id="category", name="category" class="form-control">
						@foreach ($categories as $category)
						<option value="{{ $category->id }}">{{ $category->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<label>Tên shop <span class="color-red">*</span></label>
			<div class="row sky-space-20" style="padding-bottom: 15px;">
				<div class="col-md-12">
					<div>
						<input type="text" name="shop_name" id="shop_name" class="form-control">
					</div>
				</div>
			</div>

			<label>Email <span class="color-red">*</span></label>
			<div class="row sky-space-20" style="padding-bottom: 15px;">
				<div class="col-md-12">
					<div>
						<input type="email" class="form-control" id="email" name="email">
					</div>
				</div>
			</div>

			<label>Địa chỉ <span class="color-red">*</span></label>
			<div class="row sky-space-20" style="padding-bottom: 15px;">
				<div class="col-md-12">
					<div>
						<input type="text" class="form-control" id="address" name="address">
					</div>
				</div>
			</div>
			
			<label>Thành phố <span class="color-red">*</span></label>
			<div class="row sky-space-20" style="padding-bottom: 15px;">
				<div class="col-md-12">
					<div>
						<input type="text" class="form-control" id="city" name="city">
					</div>
				</div>
			</div>
			
			<label>Domain <span class="color-red">*</span></label>
			<div class="row sky-space-20" style="padding-bottom: 15px;">
				<div class="col-md-6">
					<div class="input-group">
						<input type="text" class="form-control" id="domain" name="domain">
						<div class="input-group-addon">.4biz.vn</div>
					</div>
				</div>
			</div>
			
			<label>Tên đăng nhập <span class="color-red">*</span></label>
			<div class="row sky-space-20" style="padding-bottom: 15px;">
				<div class="col-md-12">
					<div>
						<input type="text" class="form-control" id="account" name="account">
					</div>
				</div>
			</div>
			
			<label>Mật khẩu <span class="color-red">*</span></label>
			<div class="row sky-space-20" style="padding-bottom: 15px;">
				<div class="col-md-12">
					<div>
						<input type="password" class="form-control" id="password" name="password">
					</div>
				</div>
			</div>

			<p>
				<button id="register" type="button" class="btn btn-default btn-u">Đăng ký</button>
			</p>
		</fieldset>
	</form>
	<div>
		<h4 id="error-msg"></h4>
	</div>
</div>
<!--/col-md-9-->
</div>
	
@endsection