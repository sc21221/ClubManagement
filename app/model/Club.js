Ext.define('ClubManagement.model.Club', {
    extend: 'ClubManagement.model.Base',
	idProperty: 'Id',
    fields: [
          { name: 'Id', type: 'int' }
        , { name: 'name', type: 'string' }
        , { name: 'zusatz', type: 'string' }
        , { name: 'vorstand', type: 'string' }
        , { name: 'strasse', type: 'string' }
        , { name: 'plz', type: 'string' }
        , { name: 'ort', type: 'string' }
        , { name: 'land', type: 'string' }
        , { name: 'email', type: 'string' }
        , { name: 'telefon1', type: 'string' }
        , { name: 'telefon2', type: 'string' }
        , { name: 'telefax', type: 'string' }
        , { name: 'blz', type: 'string' }
        , { name: 'kontonummer', type: 'string' }
        , { name: 'bank', type: 'string' }
        , { name: 'CreditorID', type: 'string' }
        , { name: 'BIC', type: 'string' }
        , { name: 'IBAN', type: 'string' }
    ]
});
