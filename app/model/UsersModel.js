Ext.define('ClubManagement.model.Users', {
	extend: 'ClubManagement.model.Base',
	fields: [
		{name: 'id', type: 'string'},
		{name: 'userId', type: 'string'},
		{name: 'surname', type: 'string'},
		{name: 'firstname', type: 'string'},
		{name: 'password', type: 'string'},
		{name: 'role', type: 'string'},
	],
	
});
