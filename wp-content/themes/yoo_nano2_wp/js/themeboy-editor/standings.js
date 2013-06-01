(function($) {
		tinymce.create('tinymce.plugins.tb_standings', {
	
				init : function(ed, url){
						ed.addButton('tb_standings', {
								title : 'Insert Standings',
								onclick : function() {
									// triggers the thickbox
									var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
									W = W - 80;
									H = H - 84;
									tb_show( 'Standings', 'admin-ajax.php?action=tb_standings_shortcode&width=' + W + '&height=' + H );
								}
						});
				},
	
				getInfo : function() {
						return {
								longname : 'ThemeBoy Standings Shortcode',
								author : 'Takumi Miyaji',
								authorurl : 'http://www.themeboy.com',
								infourl : 'http://www.themeboy.com/footballclub/',
								version : '2.0.8'
						};
				}
		});
		
		tinymce.PluginManager.add('tb_standings', tinymce.plugins.tb_standings);
		
		// handles the click event of the submit button
		$('body').on('click', '#tb_standings-form #option-submit', function() {
			form = $('#tb_standings-form');
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'limit': '7',
				'comp': '-1',
				'season': '-1',
				'club': '-1',
				'orderby': 'pts',
				'order': 'DESC',
				'linktext': '',
				'linkpage': '',
				'stats': 'p,w,d,l,f,a,gd,pts',
				'title': ''
				};
			var shortcode = '[tb_standings';
			
			for( var index in options) {
				if ( index == 'stats' ) {
					values = form.find('[name="stats[]"]');
					var stats = new Array();
					$.each( values, function( key, val) {
						if ( $(val).attr( 'checked' ))
							stats.push( $(val).val() );
					});
					value = stats.join( ',' );
				} else {
					var value = form.find('#option-' + index).val();
				}
				
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
