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
		'ClubManagement.store.RolesStore',
		'ClubManagement.store.PrintMenuStore',
		'ClubManagement.store.FeesStore',
		'ClubManagement.store.MemberFeeStore',
		'ClubManagement.store.Role'
	]

	, launch: function () {
		Ext.direct.Manager.addProvider(Ext.REMOTING_API);
		Ext.Viewport.add([{ xtype: 'ClubManagement-mainview'}]);
	}

	, onAppUpdate: function () {
		Ext.Msg.confirm('Application Update', 'This application has an update, reload?',
			function (choice) {
				if (choice === 'yes') {
					window.location.reload();
				}
			}
		);
	}

	, changeDetailView: function(newXtype, heading) {
		console.log("ClubManagement:Application:ChangeDetailView('" + newXtype + "')");
		var cq = Ext.ComponentQuery.query('ClubManagement-detailview');
		if( cq.length == 1)
		{
			var detailview = cq[0];
			if (!detailview.getComponent(newXtype)) {
				detailview.add({ xtype: newXtype, heading: heading });
			}
			detailview.setActiveItem(newXtype);
			}
	}
});
