(function() {
	tinymce.PluginManager.add( 'boc_shortcodes_dropdown', function( editor, url ) {
		editor.addButton( 'boc_shortcodes_dropdown', {
			text: 'Shortcodes',
			type: 'menubutton',
			icon: false,
			menu: [
				{
				text: 'Icon',
					onclick: function() {
						editor.insertContent('[boc_icon size="normal" icon_position="center" icon_color="#333333" has_icon_bg="" icon_bg="#ffffff" icon_bg_border="#ffffff" border_radius="100%" icon="icon icon-star" margin_top="" margin_bottom=""]');
					}
				},
				{
				text: 'Spacing',
					onclick: function() {
						editor.insertContent('[boc_spacing height="20px"]');
					}
				},
				{
				text: 'Table',
					onclick: function() {
						editor.insertContent('<div class="responsive_table_container"><table class="artsmarket_table" width="100%"><tr><th>Header 1</th><th>Header 2</th><th>Header 3</th></tr><tr><td>Item 1</td><td>Description of Item 1</td><td>$200</td></tr><tr><td>Item 2</td><td>Description of Item 2</td><td>$300</td></tr></table></div>');
					}
				},
				{
				text: 'Tooltip',
					onclick: function() {
						editor.insertContent('[tooltip title="Tooltip Text"]' + editor.selection.getContent() + '[/tooltip]');
					}
				},
				{
				text: 'Text Message',
					onclick: function() {
						editor.insertContent('[boc_message type="e.g. information, success, attention, warning_msg"]Message Text...[/boc_message]');
					}
				}
			]
		});
	});
})();