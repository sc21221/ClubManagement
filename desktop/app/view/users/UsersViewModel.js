Ext.define('ClubManagement.view.users.UsersViewModel', {
	extend: 'Ext.app.ViewModel',
	alias: 'viewmodel.usersviewmodel',
	data: {
		name: 'ClubManagement'
	},
	stores: {
		users: {
			type: 'users'
		}
	}
});
