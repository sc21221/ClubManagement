Ext.define('ClubManagement.view.home.HomeView',{
	extend: 'Ext.grid.Grid',
	xtype: 'homeview',
	cls: 'homeview',
	controller: 'homeviewcontroller',
	viewModel: 'homeviewmodel',
	title: 'Personnel',
	store: {
			type: 'personnel'
	},
	columns: [
		{ 
			text: 'Name',
			dataIndex: 'name',
			width: 100,
			cell: {
				userCls: 'bold'
			}
		}, 
		{
			text: 'Email',
			dataIndex: 'email',
			width: 230 
		}, 
		{ 
			text: 'Phone',
			dataIndex: 'phone',
			width: 150 
		}
	],
	listeners: {
		select: 'onItemSelected'
	}
});
