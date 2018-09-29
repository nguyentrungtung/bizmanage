<table id="tbl-customer" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>ID</th>
			<th>TÊN KHÁCH HÀNG</th>
			<th>EMAIL</th>
			<th>ĐỊA CHỈ</th>
			<th>THÀNH PHỐ</th>
			<th class="no-sort">&nbsp;</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($customers as $customer)
		<tr data-id="{{$customer->id}}">
			<td>{{$customer->id}}</td>
			<td>{{$customer->name}}</td>
			<td>{{$customer->email}}</td>
			<td>{{$customer->address}}</td>
			<td>{{$customer->city}}</td>
			<td class="text-center">
				<div class="btn-group">
					<a type="button" href="{{ url('customer/view', $customer->id) }}"
						class="btn btn-default" aria-label="Right Align"><span
						class="fa fa-edit" aria-hidden="true"></span> </a>
						
					<a type="button"
						class="btn btn-default lnk-remove" aria-label="Right Align"><span
						class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>
						
						<a type="button"
						class="btn btn-default lnk-offline-code" aria-label="Right Align"><span
						class="glyphicon glyphicon-qrcode" aria-hidden="true"></span> </a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>