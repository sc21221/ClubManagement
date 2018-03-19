Ext.define('ClubManagement.view.main.HeaderView', {
	extend: 'Ext.Toolbar',
	xtype: 'ClubManagement-headerview',
	cls: 'headerview',
	items: [
		{
			xtype: 'button',
			ui: 'headerbutton',
			reference: 'navtoggle',
			handler: 'onHeaderViewNavToggle',
			iconCls: 'x-fa fa-navicon'
		},
		{ 
			xtype: 'container',
			bind: { html: '{heading}' }
		},
		'->',
		{
			xtype: 'button',
			ui: 'headerbutton',
			reference: 'detailtoggle',
			handler: 'onHeaderViewDetailToggle',
			iconCls: 'x-fa fa-arrow-left'
		}
	]
});