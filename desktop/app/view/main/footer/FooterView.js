Ext.define('ClubManagement.view.main.footer.FooterView', {
	extend: 'Ext.Toolbar',
	xtype: 'footerview',
	cls: 'footerview',

	items: [
		{ 
			xtype: 'container',
			html: 'footer'
			//bind: { html: '' }
		},
		'->',
		{
			xtype: 'button',
			ui: 'footerbutton',
			iconCls: 'x-fa fa-automobile'
		}
	]

});
