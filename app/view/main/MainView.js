Ext.define('ClubManagement.view.main.MainView', {
	extend: 'Ext.Container',
	xtype: 'ClubManagement-mainview',
	requires: ['Ext.layout.Fit'],
	controller: 'ClubManagement-mainviewcontroller',
	viewModel: 'ClubManagement-mainviewmodel',
	layout: 'fit',
	items: [
		{ xtype: 'ClubManagement-navigationview', docked: 'left',   reference: 'ClubManagement-navigationview', bind: {width:  '{ClubManagement_menuview_width}'}    },
		{ xtype: 'ClubManagement-headerview',     docked: 'top',    reference: 'ClubManagement-headerview',     bind: {height: '{ClubManagement_headerview_height}'} },
		{ xtype: 'ClubManagement-footerview',     docked: 'bottom', reference: 'ClubManagement-footerview',     bind: {height: '{ClubManagement_footerview_height}'} },
		{ xtype: 'ClubManagement-centerview',                       reference: 'ClubManagement-centerview' },
		{ xtype: 'ClubManagement-membereditview',     docked: 'right',  reference: 'ClubManagement-membereditview',     bind: {width:  '{ClubManagement_detailview_width}'}  },
	]
});
