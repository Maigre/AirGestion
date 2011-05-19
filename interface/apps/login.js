
Ext.ns('MainApp');

MainApp.Login = {

	user : null,
	
	//check if user logged in, and display loggin box or 
	ask : function() {		
		//ask CI which user is logged in		
		Ext.Ajax.request({
		    url: 'login.php',
		    params: {action:'log'},
		    success: function(response){
		    	var ans = Ext.JSON.decode(response.responseText);
		    	if (ans.success) 
		    	{
		    		this.user = ans.user;		    		
		    		//Ext.Msg.alert('Identification', 'Bienvenue '+this.user+ ' !');
				}
				else MainApp.Login.login();
		    }
		});
	}, 
	
	//display login window
	login : function() {
			
			var loginPanel = new Ext.form.Panel({
			
				bodyPadding: 5,
				width: 350,

				// The form will submit an AJAX request to this URL when submitted
				url: 'login.php',
				
				// Fields will be arranged vertically, stretched to full width
				layout: 'anchor',
				defaults: {
					anchor: '100%'
				},

				// The fields
				defaultType: 'textfield',
				items: [{
					fieldLabel: 'Identifiant',
					name: 'login',
					allowBlank: false
				},{
					fieldLabel: 'Mot de Passe',
					name: 'password',
					inputType: 'password',
					allowBlank: false
				}, {
					xtype: 'hiddenfield',
					name: 'action',
					value: 'login'
				}],

				//Submit button
				buttons: [{
					text: 'Envoyer',
					formBind: true, //only enabled once the form is valid
					disabled: true,
					handler: function() {
						var form = this.up('form').getForm();
						if (form.isValid()) {
							form.submit({
								success: function(form, action) {
									loginWindow.close();
								   	MainApp.Login.user = action.result.user;
								   	MainApp.Login.ask();
								},
								failure: function(form, action) {
								    Ext.Msg.alert('Failed', action.result.msg);
								}
							});
						}
					}
				}]
			});
			
			var	loginWindow = new Ext.Window({
			
				title: 'Bienvenue sur AirGestion',
				width: 240,
				layout: 'fit',
				modal: true,
				closable: false,
				resizable: false,
				items: [loginPanel]
			});
			
			loginWindow.show();
						
		}
}
