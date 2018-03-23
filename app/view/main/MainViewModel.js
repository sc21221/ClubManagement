Ext.define('ClubManagement.view.main.MainViewModel', {
	extend: 'Ext.app.ViewModel',
	alias: 'viewmodel.ClubManagement-mainviewmodel',
	data: {
		name: 'ClubManagement',
		logo: 'sencha.png',
		navCollapsed: false,
		ClubManagement_logoview_height:     75,
		ClubManagement_menuview_max_width: 150,
		ClubManagement_menuview_min_width:  44,
		ClubManagement_actionview_height:   0,
		ClubManagement_headerview_height:   50,
		ClubManagement_footerview_height:   0,
		ClubManagement_detailview_width:      10,
		ClubManagement_detailview_max_width: 400,
		ClubManagement_detailview_min_width:   0,
		selectedMember: null,
		selectedUser: null
	},
	formulas: {
		ClubManagement_menuview_width: function(get) {
			var width = get('navCollapsed') ? get('ClubManagement_menuview_min_width') : get('ClubManagement_menuview_max_width');
			return width;
		},
		ClubManagement_detailview_width: function(get) {
			var width = get('detailCollapsed') ? get('ClubManagement_detailview_min_width') : get('ClubManagement_detailview_max_width');
			return width;
		}
	}
});
