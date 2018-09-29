@extends('admin')
@section('external_css')

@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Thông tin khách hàng</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<form id="form-create-email-template" action="{{ url('customer/save') }}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="id" value="{{ $customer->id }}" />
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="name">Khách hàng</label>
					<input id="name" type="text" class="form-control" name="name" placeholder="Khách hàng" value="{{ $customer->name }}">	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="company">Công ty</label>
					<input id="company" type="text" class="form-control" name="company" placeholder="Công ty" value="{{ $customer->company }}">	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="address">Địa chỉ</label>
					<input id="address" type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $customer->address }}">	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="email">Email</label>
					<input id="email" type="text" class="form-control disabled" name="email" placeholder="Email" value="{{ $customer->email }}">	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label for="phone">Điện thoại</label>
					<input id="phone" type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $customer->phone }}">	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label>Giới tính</label>
					<select class="select2" name="sex" style="width: 100%">
						<option value=""></option>
						<option value="Nam" <?php if($customer->sex == 'Nam') echo 'selected' ?>>Nam</option>
						<option value="Nữ" <?php if($customer->sex == 'Nữ') echo 'selected' ?>>Nữ</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6" style="padding-top: 10px;">
				<div class="form-group">
					<label>Thành phố</label>
					<select class="select2" name="city" style="width: 100%">
						@foreach($cities as $city)
						<option value="{{ $city }}" <?php if ($customer->city == $city) echo 'selected' ?>>{{ $city }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12" style="padding-top: 10px;">
				<div class="form-group">
					<label for="note">Ghi chú</label>
					<textarea type="text" class="form-control tinymce" rows="20" name="note" placeholder="Ghi chú">{{ $customer->note }}</textarea>	
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