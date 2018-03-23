Ext.define('ClubManagement.view.users.UsersView',{
    extend: 'Ext.panel.Panel',
    
    xtype: 'ClubManagement-usersview',
    itemId: 'ClubManagement-usersview',

    requires: [
        'ClubManagement.view.users.UsersViewController',
        'ClubManagement.view.users.UsersViewModel',
        'ClubManagement.store.Users',
        'ClubManagement.model.Users'
    ],

    controller: 'users-usersview',
    viewModel: {
        type: 'users-usersview'
    },
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
        xtype: 'grid',
        reference: 'usersgrid',
        flex: 1,
        selectable: {mode: 'single'},
        bind: {
            store: 'ClubManagement.store.Users',
        },
        columns: [
            { text: 'Id', dataIndex: 'id', editable: false, hidden: false },
            { text: 'UserId', dataIndex: 'userId', editable: true },
            { text: 'Nachname', dataIndex: 'surname', editable: true },
            { text: 'Vorname', dataIndex: 'firstname', editable: true },
            { text: 'Passwort', dataIndex: 'password', editable: true, inputType: 'password',
                renderer: function(val) {
                    return "\u25CF\u25CF\u25CF\u25CF\u25CF\u25CF\u25CF\u25CF";                
                },
                editor: {
                    inputType: 'text',
                    allowBlank: false
                }
            },
            { text: 'Rolle', dataIndex: 'role', editable: true }
        ]
        , listeners: {
            initialize: 'onGridInit'
            , select: 'onUserSelect'
        }
    }]
 
});
