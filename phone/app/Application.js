Ext.define('ClubManagement.Application', {
	extend: 'Ext.app.Application',
	name: 'ClubManagement',
	requires: [
		'ClubManagement.*',
		'Ext.dataview.List',
		'Ext.field.Date',
		'Ext.Video',
		'Ext.carousel.Carousel',
		'Ext.layout.Center'
	],
	defaultToken: 'homeview',

	launch: function () {
		Ext.getBody().removeCls('launching');
		var elem = document.getElementById("splash");
		elem.parentNode.removeChild(elem);

		Ext.Viewport.add([{ xtype: 'loginview'}]);
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
