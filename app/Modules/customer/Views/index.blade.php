@extends('admin')
@section('external_css')

@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Khách hàng</h1>
		</div>
		
		<div class="col-lg-12" role="group">
		    <div id="ctrlElement" style="float: right; padding: 0 0 20px;">
		        <div class="dropdown" style="float:right; margin-right: 5px;">
    		        <a id="dLabel" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        		        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        		    </a>
        		    
        		    <ul class="dropdown-menu" aria-labelledby="dLabel">
        		    	<li><a id="send_email_manual">Gửi email</a></li>
        		        <li><a>Delete all rows</a></li>
        		        <li><a>Delete selected rows</a></li>
        		        <li><a>Active all rows</a></li>
        		        <li><a>Active selected rows</a></li>
        		    </ul>
    		    </div>
		    </div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			@include('customer::partials.tbl-customer', ['customers' => $customers])
		</div>
	</div>
@endsection

@section('script')
 <script>

var CUSTOMER = {
		_datatable : null,
		init: function()
		{
			CUSTOMER._datatable = $('#tbl-customer').DataTable({
			    "order": [[ 0, "desc" ]],
			    "lengthMenu": [ 15, 25, 50, 75, 100 ],
			    "pageLength": 15,
				aoColumns : [
					{ "sWidth": "5%"},
					{ "sWidth": "23%"},
			      	{ "sWidth": "20%"},
			      	{ "sWidth": "25%"},
			      	{ "sWidth": "15%"},
			      	{ "sWidth": "12%"}
			    ],
			    "columnDefs": [{
					"targets": 'no-sort',
					"orderable": false,
				}]
			});

			$('#tbl-customer tbody').on('click', 'td a.lnk-remove', function(){
				$(this).closest('tr').addClass('removing');
				var lbl_Cancel = 'Hủy';
				var lbl_Ok = 'Xóa';
				CORE_DIALOG.confirmDialog(
						'Cảnh báo', 
						'Bạn muốn xóa bản ghi này?', 
						function(){
							var _data = {};
							_data['id'] = $('#tbl-customer tbody tr.removing').data('id').val();

							coreAjax.call(
								'/customer/remove',
								_data,
								function( response ){
									if (response.success) {
										CUSTOMER._datatable.row('.removing').remove().draw( false );
									} else {
										 BootstrapDialog.alert(response.message);
									}
								}
							);
						}, 
						function(){
							$('#tbl-customer tbody tr').removeClass('removing');
						},
						BootstrapDialog.TYPE_INFO,
						{'label': lbl_Cancel },
						{'label': lbl_Ok}
					);
			});

			$('#tbl-customer tbody').on('click', 'td a.lnk-offline-code', function(){
				$(this).closest('tr').addClass('removing');
				var lbl_Cancel = 'Hủy';
				var lbl_Ok = 'Đồng ý';
				CORE_DIALOG.confirmDialog(
						'Cảnh báo', 
						'Bạn muốn tạo mã code cho bản offline?', 
						function(){
							var _data = {};
							_data['customer_id'] = $('#tbl-customer tbody tr.removing').data('id').val();

							coreAjax.call(
								'/package/offline/generate-code',
								_data,
								function( response ){
									console.log(response);
								}
							);
						}, 
						function(){
							// $('#tbl-customer tbody tr').removeClass('removing');
						},
						BootstrapDialog.TYPE_INFO,
						{'label': lbl_Cancel },
						{'label': lbl_Ok}
					);
			});

			$('#tbl-customer tbody').on( 'click', 'tr', function () {
				$(this).toggleClass('selected');
		    });
			CUSTOMER.bindClickOnShowSendEmailManual();
		},
		bindClickOnShowSendEmailManual: function() {
			$('#send_email_manual').unbind('click').bind('click', function(){
				var _data = {};
				_data['type'] = 'send_email_manual';
				coreAjax.call(
					'/customer/load-modal',
					_data,
					function( response ){
						if (response.success) {
							$('#page-wrapper').append(response.modal_html);
							$('#modal_send_email_manual').modal('show');
							$('#modal_send_email_manual #selected_customers_block').html('');

							$.map(CUSTOMER._datatable.rows('.selected').data(), function (item) {
								$('#modal_send_email_manual #selected_customers_block').append('<span class="selected-customer">'+ item[1].trim() +'</span>')
							});

							CUSTOMER.bindClickOnSendEmailManual();
						}
					}
				);
			});
		},
		bindClickOnSendEmailManual: function() {
			$('#modal_send_email_manual #send').unbind('click').bind('click', function(){
				var _data = {};
				_data['email_template'] = $('#modal_send_email_manual #email_template').val();
				var ids = $.map(CUSTOMER._datatable.rows('.selected').data(), function (item) {
					return item[0];
				});
				_data['customer_ids'] = ids.join();
				coreAjax.call(
					'/email/send',
					_data,
					function( response ){
						$('#modal_send_email_manual').modal('hide');
						if (response.success) {
							COMMON.alert('success', 'Gửi email thành công!');
						} else {
							COMMON.alert('error', 'Lỗi trong quá trình gửi email!');
						}
					}
				);
			});
		},
}

$( document ).ready(function() {
	CUSTOMER.init();
});
</script>
@endsection
