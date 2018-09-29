@extends('admin')
@section('external_css')

@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Gói dịch vụ 4biz</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<div class="row" style="padding: 0 0 20px 0">
		<div id="filter-by-category-block" class="col-lg-4 form-group">
			<label for="by-category">Lọc theo lĩnh vực:</label>
		</div>
		
		<div id="ctrlElement" style="float: right; padding: 20px 10px 0 0; display: none">
	        <a id="dLabel" href="{{ url('/package/view/-1') }}" class="btn btn-default">
		        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> TẠO MỚI
		    </a>
	    </div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			@include('package::partials.tbl-package', ['packages' => $packages])
		</div>
	</div>
@endsection

@section('script')
 <script>
$('.datetimepicker').datetimepicker({
	format: 'YYYY-MM-DD HH:mm:ss',
	showClear: true,
	showClose: true,
	allowInputToggle: true,
});

$( document ).ready(function() {

	$('[data-toggle="tooltip"]').tooltip();
	
	var table = $('#tbl-package').DataTable({
	    initComplete: function () {
	        this.api().column(2).every( function () {
	            var column = this;
	            var select = $('<select id="by-category" class="select2" name="subject" style="width: 100%;"><option value="">All</option></select>')
	                .appendTo( $('#filter-by-category-block') )
	                .on( 'change', function () {
	                    var val = $.fn.dataTable.util.escapeRegex(
	                        $(this).val()
	                    );
	                    
	                    column
	                        .search( val ? '^'+val+'$' : '', true, false )
	                        .draw();
	                } );
	
	            column.data().unique().sort().each( function ( d, j ) {
	                select.append( '<option value="'+d+'">'+d+'</option>' )
	            } );
	        } );
	    },
		"order": [[ 0, "desc" ]],
		"lengthMenu": [ 15, 25, 50, 75, 100 ],
	    "pageLength": 15,
		aoColumns : [
			
	      { "sWidth": "11%"},
	      { "sWidth": "15%"},
	      { "sWidth": "15%"},
	      { "sWidth": "15%"},
	      { "sWidth": "16%"},
	      { "sWidth": "12%"},
	      { "sWidth": "16%"}
	    ],
	    "columnDefs": [{
			"targets": 'no-sort',
			"orderable": false,
		}]
	});

	$('#tbl-package tbody').on('click', 'td a.lnk-refresh', function(){
		var selectedRow = $(this).closest('tr');
		var _data = {};
		_data['id'] = $(selectedRow).find('input[name="package_id"]').val();
		coreAjax.call(
			'/package/uptodate',
			_data,
			function(response){}
		);
	});

	$('#tbl-package tbody').on('click', 'td a.lnk-active', function(){
		var selectedRow = $(this).closest('tr');
		var _data = {};
		_data['id'] = $(selectedRow).find('input[name="package_id"]').val();
		_data['is_active'] = $(this).find('span').hasClass('fa-cloud') ? 0 : 1;
		
		var activeElement = $(this);
		
		coreAjax.call(
			'/package/active',
			_data,
			function(response)
			{
				if( _data['is_active'] ) {
					$(activeElement).find('span').removeClass('fa-question-circle').addClass('fa-cloud');
				} else {
					$(activeElement).find('span').removeClass('fa-cloud').addClass('fa-question-circle');
				}
			}
		);
	});

	$('#tbl-package tbody').on('click', 'td span.expiry_time', function(){
		var selectedRow = $(this).closest('tr');

		$('#tbl-package tbody .datetimepicker').hide();
		$('#tbl-package tbody span.expiry_time').show();
		
		$(this).hide();
		$(selectedRow).find('.datetimepicker').show();
		$(selectedRow).find('.datetimepicker input').focus();
	});

	$('#tbl-package tbody').on('click', 'td span.extend_time', function(){
		var selectedRow = $(this).closest('tr');
		var _data = {};
		_data['id'] = $(selectedRow).find('input[name="package_id"]').val();
		_data['expiry_time_new'] = $(selectedRow).find('input[name="expiry_time_new"]').val();
		var activeElement = $(this);				
		coreAjax.call(
			'/package/extend',
			_data,
			function(response)
			{
				if  (response.success) {
					$(selectedRow).find('span.expiry_time').text(_data['expiry_time_new']);
					$(selectedRow).find('span.expiry_time').show();
					$(selectedRow).find('.datetimepicker').hide();
				} else {
					BootstrapDialog.alert(response.message);
				}
			}
		);
	});

	
});
</script>
@endsection