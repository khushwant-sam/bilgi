
tinymce.PluginManager.add('cu_test', function(editor, url) {
	// Add a button that opens a window

	editor.addButton('custom_button_key', {
		icon: true,
		image: url+'/icon.png',
		onclick: function() {
			editor.windowManager.open({
			title: 'Shortcode Generator',
			bodyType: 'tabpanel',
			body: [
				{
					title: '2Sides',
					type: "form",	
					onShowTab: function() {
						

					},
					layout: 'flex',
					direction: 'column',
					align: 'stretch',
					padding: 10,
					spacing: 10,
					items: [
						
						{
							type: 'label',
							text: "Please Choose shortcode from dropdown.",
							id:'zipcodff'
						},
						
						{type: 'listbox',
                            label: 'Select :',
                            id:'get_short',
                            onselect: function(e) {
    							
                            },
                            'values': [
                            
                              {text: 'All Topics', value: 'getalltopics'}
                              
                            ]
                          },
						{
							type: 'textbox',
							name: 'global_check',
							id:"global_check",
							style:'visibility:hidden;'
						}
					]
				}
			],
			onSubmit: function(e) {
				
					if(document.getElementById("get_short-open").childNodes[0].innerHTML == "All Topics")
					editor.insertContent("[getalltopics]");
				//alert(document.getElementById("get_short-open").childNodes[0].innerHTML.toLowerCase());
				
			}
		});
		}
	});
});
