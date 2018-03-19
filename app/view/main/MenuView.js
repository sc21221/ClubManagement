Ext.define('ClubManagement.view.main.MenuView', {
	extend: 'Ext.list.Tree',
	xtype: 'ClubManagement-menuview',
	requires: [
		'Ext.data.TreeStore',
		'ClubManagement.view.users.UsersView'
	],
	ui: 'nav',
	scrollable: true,
	bind: { micro: '{navCollapsed}' },
	expanderFirst: false,
	expanderOnly: false,
	listeners: {
		selectionchange: 'onMenuViewSelectionChange'
	},
});
