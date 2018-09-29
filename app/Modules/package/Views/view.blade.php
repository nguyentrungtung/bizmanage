@extends('admin')
@section('external_css')

@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Thông tin gói sản phẩm</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<form id="form-create-email-template" action="{{ url('package/save') }}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="id" value="{{ $package->id }}" />
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="customer_id">Khách hàng:</label>
					<input id="customer_id" type="text" class="form-control" disabled name="customer_id" placeholder="Khách hàng" value="{{ $package->customer->name }}">	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="name">Tên gói:</label>
					<input id="name" type="text" class="form-control" disabled name="name" placeholder="Tên gói" value="{{ $package->name }}">	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="domain">Tên miền:</label>
					<input id="domain" type="text" class="form-control" disabled name="domain" placeholder="Tên miền" value="{{ $package->domain }}">	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="account">Tài khoản đăng nhập:</label>
					<input id="account" type="text" class="form-control" disabled name="account" placeholder="Tài khoản đăng nhập" value="{{ $package->account }}">	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label>Loại gói:</label>
					<select class="select2" name="category" disabled style="width: 100%">
						@foreach($categories as $category)
						<option value="{{ $category->id }}" <?php if ($package->category_id == $category->id) echo 'selected' ?>>{{ $category->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
                <div class="row">
                    <div class="col-lg-12" style="padding-top: 10px;">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_custom" value="1" {{$package->is_custom ? 'checked="checked"' : ''}}>Custom source code
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
		<div class="row">
			<div class="col-lg-12" style="padding-top: 10px;">
				<div class="form-group">
					<label for="settings">Cài đặt gói:</label>
					<textarea type="text" class="form-control tinymce" rows="10" name="settings" placeholder="Ghi chú">{{ $package->settings }}</textarea>	
				</div>
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
