Ext.define('ClubManagement.view.main.NavigationView', {
	extend: 'Ext.Panel',
	xtype: 'ClubManagement-navigationview',
	layout: 'fit',
	tbar: {xtype: 'ClubManagement-logoview', bind: {height: '{ClubManagement_logoview_height}'}},
	items: [
		{
			xtype: 'ClubManagement-menuview',
			reference: 'ClubManagement-menuview',
			bind: {width: '{ClubManagement_menuview_width}'}
		},
	],
	bbar: {xtype: 'ClubManagement-actionview', bind: {height: '{ClubManagement_actionview_height}'}}
});
