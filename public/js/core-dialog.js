/*
*Core Dialog use bootstrap-dialog.min.js at http://nakupanda.github.io/bootstrap3-dialog/
*/
var CORE_DIALOG = {
	/**
	 * confirm dialog 
	 * @title title of popup header
	 * @msg confirmation message
	 * @callBackOK callback function when user confirm OK
	 * @callBackKO callback function when user hit Cancel
	 * @type there are 3 type TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
	 * @btnCancelLabel default value is 'Cancel' you can change it to any
	 * @btnOKLabel default value is 'Ok' you can change it to any
	 */
	 confirmDialog: function(title, msg, callBackOK, callBackKO, type, btnCancel, btnOK) {
	 	type = typeof type !== 'undefined' ? type : 'TYPE_PRIMARY';
	 	var btnCancelLabel = (typeof btnCancel !== 'undefined' && typeof btnCancel.label !== 'undefined') ? btnCancel.label : 'Cancel';
	 	var btnOKLabel = (typeof btnOK !== 'undefined' && typeof btnOK.label !== 'undefined') ? btnOK.label: 'OK';
	 	
        BootstrapDialog.show(
		{
			closable: false,
			type: type,
			title: title,
			message: msg,
			buttons: [{
				label: btnCancelLabel,
				cssClass: '',
				action: function(dialogRef) {
					if(callBackKO)
					{
						callBackKO();
					}
					dialogRef.close();
				}
			}, {
				label: btnOKLabel,
				cssClass: '',
				action: function(dialogRef) {
					dialogRef.close();
					if(callBackOK)
					{
						callBackOK();
					}
				}
			}]
		});
	 },
}
