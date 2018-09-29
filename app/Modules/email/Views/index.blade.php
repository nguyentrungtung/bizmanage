@extends('admin')
@section('external_css')

@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Mẫu email</h1>
		</div>
		<div class="col-lg-12" role="group">
		    <div id="ctrlElement" style="float: right; padding: 0 0 20px;">
		        <a href="{{ url('email/view', 0) }}" class="btn btn-default" aria-expanded="false" style="float:right;">
    		        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
    		    </a>
		        <div class="dropdown" style="float:right; margin-right: 5px;">
    		        <a id="dLabel" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        		        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        		    </a>
        		    
        		    <ul class="dropdown-menu" aria-labelledby="dLabel">
        		        <li>Delete all rows</li>
        		        <li>Delete selected rows</li>
        		        <li>Active all rows</li>
        		        <li>Active selected rows</li>
        		    </ul>
    		    </div>
		    </div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			@include('email::partials.tbl-template', ['templates' => $templates])
		</div>
	</div>
@endsection

@section('script')
 <script>

var EMAIL = {
		_datatable : null,
		init: function()
		{
			EMAIL._datatable = $('#tbl-template').DataTable({
			    "order": [[ 0, "desc" ]],
			    "lengthMenu": [ 15, 25, 50, 75, 100 ],
			    "pageLength": 15,
				aoColumns : [
					{ "sWidth": "5%"},
			      { "sWidth": "50%"},
			      { "sWidth": "25%"},
			      { "sWidth": "20%"}
			    ],
			    "columnDefs": [{
					"targets": 'no-sort',
					"orderable": false,
				}]
			});

			$('#tbl-template tbody').on('click', 'td a.lnk-active', function(){
				var selectedRow = $(this).closest('tr');
				var _data = {};
				_data['template_id'] = $(selectedRow).find('input[name="template_id"]').val();
				_data['is_active'] = $(this).find('span').hasClass('glyphicon-ok') ? 0 : 1;
				
				var activeElement = $(this);
				
				coreAjax.call(
					'/email/active',
					_data,
					function(response)
					{
						if( _data['is_active'] ) {
							$(activeElement).find('span').removeClass('glyphicon-remove').addClass('glyphicon-ok');
						} else {
							$(activeElement).find('span').removeClass('glyphicon-ok').addClass('glyphicon-remove');
						}
					}
				);
			});

			$('#tbl-template tbody').on('click', 'td a.lnk-remove', function(){
				$(this).closest('tr').addClass('removing');
				var lbl_Cancel = 'Hủy';
				var lbl_Ok = 'Xóa';
				CORE_DIALOG.confirmDialog(
						'Cảnh báo', 
						'Bạn muốn xóa bản ghi này?', 
						function(){
							var _data = {};
							_data['template_id'] = $('#tbl-template tbody tr.removing input[name="template_id"]').val();

							coreAjax.call(
								'/email/remove',
								_data,
								function( response ){
									EMAIL._datatable.row('.removing').remove().draw( false );
								}
							);

						}, 
						function(){
							$('#question-list tbody tr').removeClass('removing');
						},
						BootstrapDialog.TYPE_INFO,
						{'label': lbl_Cancel },
						{'label': lbl_Ok}
					);
			});
		}
}

$( document ).ready(function() {
	EMAIL.init();
});
</script>
@endsection
