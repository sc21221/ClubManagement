Ext.define('ClubManagement.view.main.nav.NavView', {
	extend: 'Ext.Panel',
	xtype: 'navview',
	cls: 'navview',
	layout: 'fit',
	tbar: {xtype: 'logoview', bind: {height: '{logoview_height}'}},
	items: [ {xtype: 'menuview', reference: 'menuview', bind: {width: '{menuview_width}'}} ],
	bbar: {xtype: 'actionview', bind: {height: '{actionview_height}'}}
});
