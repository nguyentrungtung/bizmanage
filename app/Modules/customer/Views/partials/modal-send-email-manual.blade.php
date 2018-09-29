<!-- Small modal -->
<div class="modal fade" id="modal_send_email_manual" tabindex="-1" role="dialog" aria-labelledby="modal_send_email_manual">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Gửi email</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-7">
				<div class="form-group">
					<label for="selected_customers_block">D/S khách hàng</label>
					<div id="selected_customers_block" style="word-wrap: break-word;"></div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<label for="email_template">Chọn mẫu email</label>
					<select id="email_template" class="form-control">
						@foreach ($emailTemplates as $template)
					  	<option value="{{ $template->id }}">{{ $template->title }}</option>
					  	@endforeach
					</select>
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button id="send" type="button" class="btn btn-primary">SEND</button>
      </div>
    </div>
  </div>
</div>