Ext.define('ClubManagement.view.main.MainViewModel', {
	extend: 'Ext.app.ViewModel',
	alias: 'viewmodel.mainviewmodel',
	data: {
		navCollapsed:       false,
		navview_max_width:    300,
		navview_min_width:     44,
		logoview_height:       75,
		actionview_height:     50,
		headerview_height:     50,
		footerview_height:     50,
		detailCollapsed:     true,
		detailview_width:      10,
		detailview_max_width: 300,
		detailview_min_width:   0,

	},
	formulas: {
		navview_width: function(get) {
			return get('navCollapsed') ? get('navview_min_width') : get('navview_max_width');
		},
		logoview_image: function(get) {
			var image = '';
			if (get('navCollapsed') == true) { image = 'LogoSmall.png'; } 
			else { image = 'LogoLarge.png'; }
			return image;
		},
		detailview_width: function(get) {
			return get('detailCollapsed') ? get('detailview_min_width') : get('detailview_max_width');
		}
	}
});
