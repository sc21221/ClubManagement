Ext.define('ClubManagement.view.home.HomeViewController', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.homeviewcontroller',

	onItemSelected: function (sender, record) {
		Ext.Msg.confirm('Confirm', 'Are you sure?', 'onConfirm', this);
	},

	onConfirm: function (choice) {
		if (choice === 'yes') {
			//
		}
	}
});
