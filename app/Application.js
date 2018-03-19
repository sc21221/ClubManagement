Ext.define('ClubManagement.Application', {
	extend: 'Ext.app.Application',
	name: 'ClubManagement',
	requires: ['ClubManagement.*']

	, stores: [
		'ClubManagement.store.Club',
		'Members',
		'ClubManagement.store.Sex',
		'ClubManagement.store.PaymentModeStore',
		'ClubManagement.store.SalutationStore',
		'ClubManagement.store.Users',
		'ClubManagement.store.RolesStore'
	]

	, launch: function () {
		Ext.direct.Manager.addProvider(Ext.REMOTING_API);
		Ext.Viewport.add([{ xtype: 'ClubManagement-mainview'}]);
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
