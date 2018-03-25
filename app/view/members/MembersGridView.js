
Ext.define('ClubManagement.view.members.MembersGridView',{
    extend: 'Ext.Panel',
    
    xtype: 'ClubManagement-membersgridview',
    itemId: 'ClubManagement-membersgridview',

    requires: [
        'ClubManagement.view.members.MembersGridViewController',
    	'ClubManagement.store.Members',
        'ClubManagement.model.Members',
        'ClubManagement.view.main.MainViewModel'
    ],

    controller: 'members-membersgridview',
    viewModel: { type: 'ClubManagement-mainviewmodel'},
    session: true, 

    reference: 'membersgridview',
    layout: 'vbox',
    tools: [
        {
            type: 'help',
            handler: function() {
                
            }
        },{
            type: 'plus',
            handler: 'onAdd'
        }
    ],

    items: [{
        xtype: 'toolbar',
        dock: 'top',
        items: [{
            xtype: 'textfield',
            label: 'Search',
            listeners: {
                action: 'onActionSearch',
                clearicontap: 'onClearIconTapSearch'
            }
        }]
    }, {
        xtype: 'grid',
        reference: 'membersgrid',
        flex: 1,
        selectable: {mode: 'single'},
        bind: {
            store: 'Members',
        },
        columns: [
            { text: 'Nachname', dataIndex: 'nachname', editable: true, flex:3 },
            { text: 'Vorname', dataIndex: 'vorname', editable: true, flex:3 },
            { text: 'Straße', dataIndex: 'strasse', editable: true, flex:4 },
            { text: 'PLZ', dataIndex: 'plz', editable: true, flex:2 },
            { text: 'Ort', dataIndex: 'ort', editable: true, flex:3},
            { text: 'Email', dataIndex: 'email', editable: true, flex:4 },
            { text: 'Telefon', dataIndex: 'telefon1', editable: true, flex:3 },
            { text: 'Geburtsdatum', dataIndex: 'gebdat', xtype: 'datecolumn', format: 'd.m.Y', editable: true, flex:2 },
            { text: 'Eintrittsdatum', dataIndex: 'eindat', xtype: 'datecolumn', format: 'd.m.Y', editable: true, flex:2 },
            { text: 'ZahlungsKz', dataIndex: 'zahlungskz', editable: false, hidden: true, flex:1 },
            { text: 'Kontoinhaber', dataIndex: 'kontoinhaber', editable: false, hidden: true, flex:3 },
            { text: 'IBAN', dataIndex: 'IBAN', editable: false, hidden: true, flex:3 },
            { text: 'BIC', dataIndex: 'BIC', editable: false, hidden: true, flex:3 }
        ]
        , plugins: {
            pagingtoolbar: {
                pageSize: 100
            }
        } 
        , listeners: {
            initialize: 'onGridInit'
            , select: 'onMemberSelect'
        }
    }]
 });
