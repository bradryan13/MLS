(function($) {
		tinymce.create('tinymce.plugins.tb_player', {
	
				init : function(ed, url){
						ed.addButton('tb_player', {
								title : 'Insert Player Profile',
								onclick : function() {
									// triggers the thickbox
									var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
									W = W - 80;
									H = H - 84;
									tb_show( 'Player Profile', 'admin-ajax.php?action=tb_player_shortcode&width=' + W + '&height=' + H );
								}
						});
				},
	
				getInfo : function() {
						return {
								longname : 'ThemeBoy Player Profile Shortcode',
								author : 'Takumi Miyaji',
								authorurl : 'http://www.themeboy.com',
								infourl : 'http://www.themeboy.com/footballclub/',
								version : '2.0.8'
						};
				}
		});
		
		tinymce.PluginManager.add('tb_player', tinymce.plugins.tb_player);
		
		// handles the click event of the submit button
		$('body').on('click', '#tb_player-form #option-submit', function() {
			form = $('#tb_player-form');
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = {
				'id': ''
			};
			var shortcode = '[tb_player';
			
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
