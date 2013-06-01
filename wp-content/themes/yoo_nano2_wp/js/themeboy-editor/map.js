(function($) {
		tinymce.create('tinymce.plugins.tb_map', {
	
				init : function(ed, url){
						ed.addButton('tb_map', {
								title : 'Insert Map',
								onclick : function() {
									// triggers the thickbox
									var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
									W = W - 80;
									H = H - 84;
									tb_show( 'Map', 'admin-ajax.php?action=tb_map_shortcode&width=' + W + '&height=' + H );
								}
						});
				},
	
				getInfo : function() {
						return {
								longname : 'ThemeBoy Map Shortcode',
								author : 'Takumi Miyaji',
								authorurl : 'http://www.themeboy.com',
								infourl : 'http://www.themeboy.com/footballclub',
								version : '2.0.8'
						};
				}
		});
		
		tinymce.PluginManager.add('tb_map', tinymce.plugins.tb_map);
		
		// handles the click event of the submit button
		$('body').on('click', '#tb_map-form #option-submit', function() {
			form = $('#tb_map-form');
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'width': '584',
				'height': '320',
				'address': '',
				};
			var shortcode = '[tb_map';
			
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
