Ext.define('ClubManagement.model.UsersModel', {
	extend: 'ClubManagement.model.Base',
	fields: [
		'username', 
		'_id', 
		{
			name: 'creator',
			mapping: '_meta.creator'
		},
		{
			name: 'created',
			mapping: '_meta.created'
		},
		'description'
	]
});
