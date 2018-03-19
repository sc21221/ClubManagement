Ext.define('ClubManagement.view.home.HomeViewController', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.homeviewcontroller',

	onHomeViewBeforeHide: function() {
		var v = this.lookup('theVideo')
		if (v != undefined) {
			v.stop()
		}
	}

});
