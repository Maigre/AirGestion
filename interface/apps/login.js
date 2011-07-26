
Ext.ns('MainApp');

MainApp.Login = {

	user : null,
	
	//check if user logged in, and display loggin box or 
	ask : function() {		
		//ask CI which user is logged in		
		Ext.Ajax.request({
		    url: BASE_URL+'auth/',
		    success: function(response){
		    	var ans = Ext.JSON.decode(response.responseText);
		    	if (ans.success) 
		    	{
		    		MainApp.Login.user = ans.user;		    		
		    		//Ext.Msg.alert('Identification', 'Bienvenue '+this.user+ ' !');
		    		MainApp.ViewPort.start();
				}
				else MainApp.Login.login();  //launch login box
		    },
		    failure: function () {
		    	Ext.Msg.alert('Identification', 'Zut, impossible de contacter le serveur pour identification .. ');
		    }
		});
	},
	
	//logout
	logout : function() {		
		//ask CI to log out
		Ext.Ajax.request({
		    url: BASE_URL+'auth/logout',
		    success: function(response){
		    	var ans = Ext.JSON.decode(response.responseText);
		    	if (ans.success) Ext.Msg.alert('Deconnexion', 'A bientot '+this.user+ ' !',function(){this.user = null;MainApp.ViewPort.reload();});
				else Ext.Msg.alert('Identification', ans.msg);  //erreur, redemarrez le navigateur
		    },
		    failure: function () {
		    	Ext.Msg.alert('Deconnexion', 'Zut, impossible de contacter le serveur d\'identification .. ');
		    }
		});
	},
	
	//display login window
	login : function() {
			
			var loginPanel = new Ext.form.Panel({
			
				bodyPadding: 5,
				width: 350,

				// The form will submit an AJAX request to this URL when submitted
				url: BASE_URL+'auth/login/',
				
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
								   	//MainApp.Login.user = action.result.user;
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
			//MainApp.Login.user = AirTamias;
			//MainApp.ViewPort.start();			
		}
}
