Ext.define('ClubManagement.view.appointments.AppointmentsViewController', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.appointmentsviewcontroller',

	onChildTap: function() {
		this.redirectTo( 'homeview', true );
	},

	onAction: function(list, row) {
		console.log(row.action)
		console.log(row.item)
		console.log(row.record)
		alert(row.action.text)
	},

	onSort: function(button) {
		var store = this.getViewModel().getStore('appointments');
		if (button.tag == 'ASC') {
			button.setIconCls('x-fa fa-sort-amount-desc')
			button.tag = 'DESC'
		}
		else {
			button.setIconCls('x-fa fa-sort-amount-asc')
			button.tag = 'ASC'
		}
		store.sort('created', button.tag);
	},

	onDeleteAction: function(list, data) {
		var store = this.getViewModel().getStore('appointments');
		store.remove(data.record);
		store.save();
	}
});