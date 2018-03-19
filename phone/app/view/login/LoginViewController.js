
Ext.define('ClubManagement.view.login.LoginViewController', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.loginviewcontroller',

	init: function() {
		this.callParent(arguments);
		this.lookup('form').setValues({
				username: 'norma.flores',
				password: 'wvyrEDvxI',
				activation: 'c3p0'
		});
	},

	onLoginTap: function() {
		Ext.Viewport.removeAll()
		var xtype = 'mainview';
		if (!Ext.Viewport.getComponent(xtype)) {
			Ext.Viewport.add({ xtype: xtype });
		}
		Ext.Viewport.setActiveItem(xtype);
	}

});
