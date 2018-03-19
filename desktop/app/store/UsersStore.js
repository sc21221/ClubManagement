Ext.define('ClubManagement.store.UsersStore', {
	extend: 'Ext.data.Store',
	alias: 'store.users',
	model: 'ClubManagement.model.UsersModel',
	autoLoad: true,

//	proxy: {
//		type: 'rest',
//		url: 'http://localhost:8090/users'
//		//url: 'http://10.211.55.3:8090/users'
//	},

	data: [
		{ username: 'Jean Luc', _id: 123, _meta: { creator: 456, created: "02/14/1962" }, description: 'desc' },
		{ username: 'Worf', _id: 123, _meta: { creator: 456, created: "02/14/1962" }, description: 'desc' },
		{ username: 'Deanna', _id: 123, _meta: { creator: 456, created: "02/14/1962" }, description: 'desc' },
		{ username: 'Data', _id: 123, _meta: { creator: 456, created: "02/14/1962" }, description: 'desc' },
	],
	proxy: {
		type: 'memory',
		reader: {
			type: 'json',
			rootProperty: 'items'
		}
	}

});
