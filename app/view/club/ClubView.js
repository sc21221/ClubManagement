
Ext.define('ClubManagement.view.club.ClubView',{
    extend: 'Ext.grid.Grid',

    requires: [
        'ClubManagement.view.club.ClubViewController',
        'ClubManagement.view.club.ClubViewModel'
    ],

    xtype: 'ClubManagement-clubview',
    controller: 'club-clubview',
    viewModel: {
        type: 'club-clubview'
    },

    flex: 1,
    selectable: {mode: 'single'},
    bind: {
        store: 'ClubManagement.store.Club',
    },
    plugins: 
    {
        type: 'grideditable'
    },
    columns: [
        { text: 'Id', dataIndex: 'Id', editable: false, hidden: true },
        { text: 'Name', dataIndex: 'name', editable: true },
        { text: 'Zusatz', dataIndex: 'zusatz', editable: true },
        { text: 'Vorstand', dataIndex: 'vorstand', editable: true },
        { text: 'Strasse', dataIndex: 'strasse', editable: true },
        { text: 'PLZ', dataIndex: 'plz', editable: true },
        { text: 'Ort', dataIndex: 'ort', editable: true},
        { text: 'Land', dataIndex: 'land', editable: true },
        { text: 'Email', dataIndex: 'email', editable: true },
        { text: 'Telefon 1', dataIndex: 'telefon1', editable: true },
        { text: 'Telefon 2', dataIndex: 'telefon2', editable: true },
        { text: 'Telefax', dataIndex: 'telefax', editable: true },
        { text: 'Bank', dataIndex: 'bank', editable: true},
        { text: 'IBAN', dataIndex: 'IBAN', editable: true},
        { text: 'BIC', dataIndex: 'BIC', editable: true},
        { text: 'Creditor ID', dataIndex: 'CreditorID', editable: true}
    ]
});
