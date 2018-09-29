var COMMON = {
	/* Name of cookie */
	COOKIE_CUSTOM_DATA : 'CUSTOM_DATA',
	
	/* Time expries for cookie */
	COOKIE_EXPRIES : 7, /* expries 7 days */

	/**
	 * Save filter data to cookie
	 */
	saveDataToCookie: function( _prefix, _data, _options )
	{
		if( typeof _options === "undefined")
		{
			_options = {};
		}
		$.cookie(_prefix, JSON.stringify(_data), _options)
	},
	
	getDataFromCookie: function(_prefix)
	{
		var _cookie_data;
		if( typeof $.cookie(_prefix) !== 'undefined' )
		{
			_cookie_data = JSON.parse($.cookie(_prefix));
		}
		return _cookie_data;
	},
	
	htmlDecode: function( str )
	{
		return $('<div/>').html(str).text();
	},
	
	htmlEncode: function( str )
	{
		return $('<div/>').text(str).html();
	},

	toggleFullscreen : function()
	{
		var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;
		if( fullscreenEnabled )
		{
			if(!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement)
			{
				COMMON.launchIntoFullscreen(document.documentElement);
			} else
			{
				COMMON.exitFullscreen();
			}
		}
	},

	launchIntoFullscreen : function( element )
	{
		if(element.requestFullscreen)
		{
			element.requestFullscreen();
		} else if(element.mozRequestFullScreen) {
			element.mozRequestFullScreen();
		} else if(element.webkitRequestFullscreen) {
			element.webkitRequestFullscreen();
		} else if(element.msRequestFullscreen) {
			element.msRequestFullscreen();
		}
	},

	exitFullscreen : function() 
	{
		if(document.exitFullscreen) {
			document.exitFullscreen();
		} else if(document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} else if(document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		}
	},

	resetBlockHtml: function( element_block )
	{
		if( typeof element_block !== 'undefined' )
		{
			$(element_block).find('input[type="checkbox"]').prop('checked', false);
			$(element_block).find('input[type="text"]').val('');
			$(element_block).find('textarea').text('');
		}
	},
	alert: function(type, msg) {
		if (type == 'success') {
			$('#page-wrapper').append('<div class="system_alert alert alert-success" ><button type="button" class="close" data-dismiss="alert">x</button>'+ msg +'</div>')
			$(".alert.system_alert").delay(2000).slideUp(200, function() {
	              $(this).alert('close');
			});
		} else if (type == 'error') {
			$('#page-wrapper').append('<div class="system_alert alert alert-warning" ><button type="button" class="close" data-dismiss="alert">x</button>'+ msg +'</div>')
			$(".alert.system_alert").delay(2000).slideUp(200, function() {
	              $(this).alert('close');
			});
		}
	}
}

$( document ).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});