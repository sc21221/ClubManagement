Ext.define('ClubManagement.Application', {
	extend: 'Ext.app.Application',
	name: 'ClubManagement',
	requires: [
		'ClubManagement.*',
		'Ext.layout.Fit',
		'Ext.data.TreeStore',
		'Ext.layout.Card',
		'Ext.form.Panel',
		'Ext.field.Display',
		'Ext.data.proxy.Rest',

	],
	defaultToken: 'homeview',

	launch: function () {
		Ext.getBody().removeCls('launching');
		var elem = document.getElementById("splash");
		elem.parentNode.removeChild(elem);

		var loggedIn = localStorage.getItem("LoggedIn");
		var whichView;
		if(loggedIn == 'true') { whichView = 'mainview' }
		else { whichView = 'loginview' }

		Ext.Viewport.add([{xtype: whichView}]);
		//Ext.Viewport.add([{xtype: loggedIn ? 'mainview' : 'loginview'}]);
	},

	onAppUpdate: function () {
		Ext.Msg.confirm('Application Update', 'This application has an update, reload?',
			function (choice) {
				if (choice === 'yes') {
					window.location.reload();
				}
			}
		);
	}
});

//	viewport: {
//		controller: 'viewportcontroller',
//		viewModel: 'viewportmodel'
//	},
//Ext.Viewport.getController().onLaunch();

//sencha generate view groups.GroupsView
//SenchaNode generate viewpackage thumb
//SenchaNode generate viewpackage grid