<table id="tbl-template" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>#ID</th>
			<th>TIÊU ĐỀ</th>
			<th>LOẠI</th>
			<th class="no-sort">&nbsp;</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($templates as $template)
		<tr>
			<td><input type="hidden" name="template_id" value="{{$template->id}}" />
				{{$template->id}}</td>
			<td>{{$template->title}}</td>
			<td>{{$template->type->name}}</td>
			<td class="text-center">
				<div class="btn-group">
					<a type="button" class="btn btn-default lnk-active"
						aria-label="Left Align"> <span
						class="glyphicon {{ $template->active ? 'glyphicon-ok' : 'glyphicon-remove'}}"
						aria-hidden="true"></span></a>
					<a type="button" href="{{ url('email/view', $template->id) }}"
						class="btn btn-default" aria-label="Right Align"><span
						class="fa fa-edit" aria-hidden="true"></span> </a>
					<a type="button"
						class="btn btn-default lnk-remove" aria-label="Right Align"><span
						class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>