(function($) {
		tinymce.create('tinymce.plugins.tb_fixtures', {
	
				init : function(ed, url){
						ed.addButton('tb_fixtures', {
								title : 'Insert Fixtures',
								onclick : function() {
									// triggers the thickbox
									var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
									W = W - 80;
									H = H - 84;
									tb_show( 'Fixtures', 'admin-ajax.php?action=tb_fixtures_shortcode&width=' + W + '&height=' + H );
								}
						});
				},
	
				getInfo : function() {
						return {
								longname : 'ThemeBoy Fixtures Shortcode',
								author : 'Takumi Miyaji',
								authorurl : 'http://www.themeboy.com',
								infourl : 'http://www.themeboy.com/footballclub',
								version : '2.0.8'
						};
				}
		});
		
		tinymce.PluginManager.add('tb_fixtures', tinymce.plugins.tb_fixtures);
		
		// handles the click event of the submit button
		$('body').on('click', '#tb_fixtures-form #option-submit', function() {
			form = $('#tb_fixtures-form');
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'limit': '5',
				'comp': '-1',
				'season': '-1',
				'club': '-1',
				'venue': '-1',
				'orderby': 'post_date',
				'order': 'ASC',
				'linktext': '',
				'linkpage': '',
				'title': ''
				};
			var shortcode = '[tb_fixtures';
			
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
