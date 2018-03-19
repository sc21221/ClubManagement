Ext.define('ClubManagement.view.nav.menu.MenuView', {
	extend: 'Ext.list.Tree',
	xtype: 'menuview',
	ui: 'nav',
	scrollable: true,
	bind: { micro: '{navCollapsed}' },
	expanderFirst: false,
	expanderOnly: false,
	listeners: {
		selectionchange: 'onMenuViewSelectionChange'
	},
});
