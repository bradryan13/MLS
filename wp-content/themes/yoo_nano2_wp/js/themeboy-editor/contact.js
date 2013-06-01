(function($) {
		tinymce.create('tinymce.plugins.tb_contact', {
	
				init : function(ed, url){
						ed.addButton('tb_contact', {
								title : 'Insert Contact Form',
								onclick : function() {
									// triggers the thickbox
									var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
									W = W - 80;
									H = H - 84;
									tb_show( 'Contact Form', 'admin-ajax.php?action=tb_contact_shortcode&width=' + W + '&height=' + H );
								}
						});
				},
	
				getInfo : function() {
						return {
								longname : 'ThemeBoy Contact Form Shortcode',
								author : 'Takumi Miyaji',
								authorurl : 'http://www.themeboy.com',
								infourl : 'http://www.themeboy.com/footballclub',
								version : '2.0.8'
						};
				}
		});
		
		tinymce.PluginManager.add('tb_contact', tinymce.plugins.tb_contact);
		
		// handles the click event of the submit button
		$('body').on('click', '#tb_contact-form #option-submit', function() {
			form = $('#tb_contact-form');
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = {
				'mailto': '',
				'title': ''
				};
			var shortcode = '[tb_contact';
			
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
