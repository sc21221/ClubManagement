Ext.define('ClubManagement.view.main.MenuView', {
	extend: 'Ext.Sheet',
	xtype: 'menuview',	
	controller: 'menuviewcontroller',
	layout: 'fit',
	width:180,
	cls: 'menuview',

	items: [
		{
			xtype: 'container',
			cls: 'menuview',
			layout: 'vbox',
			defaults: {
				xtype: 'button',
				height: 60,
				style: { fontSize: '18px', color: 'white' },
				cls: 'menuview',
				handler: 'onMenuClick'
			},
			items: [
				{ xtype: 'image', src: 'resources/phone/images/Heart.png', height: 170, padding: '0 0 0 30' },
				{ xtype: 'container', html: '&nbsp;', height: 20,},
				{ text: 'Home', tag: 'homeview'},
				{ text: 'Appointments2', tag: 'appointments2view'},
				{ text: 'Appointments', tag: 'appointmentsview'},
				{ text: 'Allergy', tag: 'allergyview'},
				{ text: 'Profile', tag: 'profileview'},
				{ xtype: 'container', html: '&nbsp;', height: 100,},

				{
					xtype: 'button',
					text: 'Logout',
					handler: function(){
						Ext.Viewport.toggleMenu('left');
						Ext.Viewport.removeAll()
						var xtype = 'loginview';
						if (!Ext.Viewport.getComponent(xtype)) {
							Ext.Viewport.add({ xtype: xtype });
						}
						Ext.Viewport.setActiveItem(xtype);
					}
				}
			]
		},

	]

	// extend: 'Ext.menu.Menu',
	// xtype: 'menuview',
	// config: {
	// side: 'left',
	// },

	// items: [
	// 	{
	// 			xtype: 'button',
	// 			text: 'Option 1',
	// 			handler: function(){
	// 				Ext.Viewport.toggleMenu('left');
	// 			}
	// 	},
	// 	{
	// 			xtype: 'button',
	// 			text: 'Option 2',
	// 	}
	// ]

	// // extend: 'Ext.list.Tree',
	// // xtype: 'menuview',
	// // requires: ['Ext.data.TreeStore'],
	// // ui: 'nav',
	// // scrollable: true,
	// // bind: { micro: '' },
	// // expanderFirst: false,
	// // expanderOnly: false,
	// // listeners: {
	// // 	selectionchange: 'onMenuViewSelectionChange'
	// // },
});
