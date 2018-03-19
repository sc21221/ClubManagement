Ext.define('ClubManagement.view.main.nav.action.ActionView', {
	extend: 'Ext.Toolbar',
	xtype: 'actionview',
	cls: 'actionview',

	items: [
		{
			xtype: 'button',
			ui: 'actionbutton',
			iconCls: 'x-fa fa-angle-double-left',
			text: 'Log Out',
			handler: 'onLogOut'
		}
	]
});
