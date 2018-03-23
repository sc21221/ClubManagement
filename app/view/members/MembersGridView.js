
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
            { text: 'Nachname', dataIndex: 'nachname', editable: true },
            { text: 'Vorname', dataIndex: 'vorname', editable: true },
            { text: 'Straße', dataIndex: 'strasse', editable: true },
            { text: 'PLZ', dataIndex: 'plz', editable: true },
            { text: 'Ort', dataIndex: 'ort', editable: true },
            { text: 'Email', dataIndex: 'email', editable: true },
            { text: 'Telefon', dataIndex: 'telefon1', editable: true },
            { text: 'Geburtsdatum', dataIndex: 'gebdat', editable: true },
            { text: 'ZahlungsKz', dataIndex: 'zahlungskz', editable: false, hidden: true }
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
