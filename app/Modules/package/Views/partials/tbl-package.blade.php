<table id="tbl-package" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>TÊN GÓI</th>
			<th>KHÁCH HÀNG</th>
			<th>LĨNH VỰC</th>
			<th>DOMAIN</th>
			<th>NGÀY HẾT HẠN</th>
			<th class="no-sort">LOẠI GÓI</th>
			<th class="no-sort">&nbsp;</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($packages as $package)
		<tr>
			
			<td>
				<input type="hidden" name="package_id" value="{{$package->id}}" />
			{{ $package->name }}</td>
			<td>@if (!empty($package->customer->name)) {{ $package->customer->name }} @endif</td>
			<td>@if (!empty($package->category)) {{ $package->category->name }} @endif</td>
			<td>{{ $package->domain}}</td>
			<td>
				<div class='input-group date datetimepicker' style="display:none;">
					<input type='text' class="form-control" name="expiry_time_new" value="{{ $package->expiry_time }}"/>
                    <span class="input-group-addon extend_time">
						<span class="glyphicon glyphicon-ok"></span>
					</span>
                </div>
				<span class="expiry_time">{{ $package->expiry_time }}</span>
			</td>
			<td style="font-size: 10px;">
				<span class="label label-default">{{ strtoupper($package->status) }}</span>
				<?php if($package->is_custom) { ?>
					<span class="label label-info">CUSTOM</span>
				<?php } else { ?>
					<span class="label label-default">CORE</span>
				<?php } ?>
			</td>
			<td class="text-center">
				<div class="btn-group">
					<a type="button" class="btn btn-default lnk-refresh" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="{{ $package->uptodate_at }}">
						<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
					</a>
					<a type="button" href="{{ url('package/view', $package->id) }}"
						class="btn btn-default" aria-label="Right Align"><span
						class="fa fa-edit" aria-hidden="true"></span> </a>
					<a type="button" class="btn btn-default lnk-active" aria-label="Left Align">
						<span class="fa {{$package->active ? 'fa-cloud' : 'fa-question-circle'}}" aria-hidden="true"></span>
					</a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
