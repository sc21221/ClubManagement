
Ext.define('ClubManagement.view.login.LoginView',{
	extend: 'Ext.panel.Panel',
	xtype: 'loginview',
	controller: 'loginviewcontroller',
	viewModel: 'loginviewmodel',
	cls: 'auth-login',
	bodyStyle: {backgroundColor: '#ffc'},

	layout: {
		type: 'vbox',
		align: 'center',
		pack: 'center'
	},

	items: [
		{
			xtype: 'formpanel',
			reference: 'form',
			layout: 'vbox',
			ui: 'auth',
			items: [
				{ xtype: 'image', src: 'resources/phone/images/Vertical.png', height: 170, padding: '0 0 0 30' },
				{
						xtype: 'textfield',
						name: 'username',
						placeholder: 'Username',
						required: true
				}, 
				{
						xtype: 'passwordfield',
						name: 'password',
						placeholder: 'Password',
						required: true
				}, 
				{
					xtype: 'passwordfield',
					name: 'activation',
					placeholder: 'Activation Key',
					required: true
				}, 
				{
						xtype: 'button',
						text: 'LOG IN',
						iconAlign: 'right',
						iconCls: 'x-fa fa-angle-right',
						handler: 'onLoginTap',
						ui: 'action'
				}
			]
	}, {
			cls: 'auth-footer',
			html:
				'<div>Ext JS Proof Of Concept</div>'+
				'<a href="http://www.sencha.com" target="_blank">'+
						'<span class="logo ext ext-sencha"></span>'+
						'<span class="label">Sencha</span>'+
				'</a>'
	}]
});
