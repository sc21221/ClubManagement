Ext.define('ClubManagement.view.appointments.AppointmentsView',{
	extend: 'Ext.panel.Panel',
	xtype: 'appointmentsview',
	controller: 'appointmentsviewcontroller',
	viewModel: 'appointmentsviewmodel',
	requires: [
		'Ext.dataview.listswiper.ListSwiper',
		'Ext.dataview.plugin.ListPaging'
	],
	layout: 'fit',
	tbar: [
		'->',
		{ xtype: 'button', xui: 'plain',iconCls: 'x-fa fa-sort-amount-desc', iconAlign: 'right', tag: 'DESC', text: 'Sort', handler: 'onSort'},
	],
	items: [
		{
			xtype: 'list',
			bind: '{appointments}',
			emptyText: 'No activity was found',
			striped: true,
			grouped: true,
			ui: 'listing',
			listeners: {
				childtap: 'onChildTap'
			},
			selectable: {
					disabled: true
			},
			// plugins: [
			// 	{
			// 		type: 'listpaging',
			// 		autoPaging: true
			// 	}, 
			// 	{
			// 		type: 'listswiper',
			// 		right: [{
			// 				iconCls: 'x-fa fa-trash',
			// 				commit: 'onDeleteAction',
			// 				undoable: true,
			// 				text: 'Delete',
			// 				ui: 'remove'
			// 		}]
			// 	}
			// ],

			plugins: [
				{
					type: 'listpaging',
					autoPaging: true
				}, 
				{
					type: 'listswiper',
					left: [
						{
							iconCls: 'x-fa fa-skype',
							commit: 'onAction',
							text: 'Skype',
							ui: 'skype',
							data: {
									subject: 'skype'
							}
						}, 
						{
							iconCls: 'x-fa fa-envelope-o',
							commit: 'onAction',
							text: 'Email',
							ui: 'email',
							data: {
									subject: 'email'
							}
						}
					],
					right: [
						{
						iconCls: 'x-fa fa-pencil',
						commit: 'onAction',
						text: 'Edit',
						ui: 'edit'
						}
					],
					widget: {
						xtype: 'personlistswiperitem'
					}
				}
			],

			itemTpl: [ `
				<div class="testview" style="width: 100%;border: 0px solid green;">
					<table style="width: 100%;border: 0px solid green;" >
						<tr>
							<td rowspan="2" width="70px">
								<span class="action action-{type} {type}"></span>
								<div class="picture" style="background-image: url({recipient.picture})"></div>
							</td>
							<td style="font-size: 16px;">
								<div style="line-height: 20px;" class="xitem-title">{desc}</div>
								<div style="line-height: 20px;" class="xitem-caption">{doctor}</div>
							</td>
							<td width="25%" >
								<div style="font-size: 12px;" class="apptdate">{created:date("Y/m/d")}</div>
								<div style="font-size: 12px;"class="appttime">{created:date("H:i")}</div>
							</td>
						</tr>
					</table>
				</div>
				`
			]
		}
	]
});
