(function($) {
		tinymce.create('tinymce.plugins.tb_staff', {
	
				init : function(ed, url){
						ed.addButton('tb_staff', {
								title : 'Insert Staff',
								onclick : function() {
									// triggers the thickbox
									var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
									W = W - 80;
									H = H - 84;
									tb_show( 'Staff', 'admin-ajax.php?action=tb_staff_shortcode&width=' + W + '&height=' + H );
								}
						});
				},
	
				getInfo : function() {
						return {
								longname : 'ThemeBoy Staff Shortcode',
								author : 'Takumi Miyaji',
								authorurl : 'http://www.themeboy.com',
								infourl : 'http://www.themeboy.com/footballclub/',
								version : '2.0.8'
						};
				}
		});
		
		tinymce.PluginManager.add('tb_staff', tinymce.plugins.tb_staff);
		
		// handles the click event of the submit button
		$('body').on('click', '#tb_staff-form #option-submit', function() {
			form = $('#tb_staff-form');
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'limit': '-1',
				'season': '-1',
				'club': '-1',
				'team': '-1',
				'linktext': '',
				'linkpage': '',
				'title': ''
				};
			var shortcode = '[tb_staff';
			
			for( var index in options) {
				var value = form.find('#option-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
		
		
		
})(jQuery);
