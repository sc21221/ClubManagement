Ext.define('ClubManagement.model.Fees', {
	extend: 'ClubManagement.model.Base',
	fields: [
		{name: 'id', type: 'string'},
		{name: 'bemerkung', type: 'string'},
		{name: 'bezeichnung', type: 'string'},
		{name: 'alterVon1', type: 'int'},
		{name: 'alterBis1', type: 'int'},
		{name: 'beitrag1', type: 'number'},
		{name: 'alterVon2', type: 'int'},
		{name: 'alterBis2', type: 'int'},
		{name: 'beitrag2', type: 'number'},
		{name: 'alterVon3', type: 'int'},
		{name: 'alterBis3', type: 'int'},
		{name: 'beitrag3', type: 'number'}
	]	
});
