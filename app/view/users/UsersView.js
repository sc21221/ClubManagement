Ext.define('ClubManagement.view.users.UsersView',{
    extend: 'Ext.panel.Panel',
	xtype: 'ClubManagement-usersview',
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
            handler: function() {
                var store = Ext.getStore('ClubManagement.store.Users');
                // var maxId = 0;
                // if (store.getCount() > 0)
                // {
                //     var maxId = store.getAt(0).get('Id'); // initialise to the first record's id value.
                //     store.each(function(rec) // go through all the records
                //     {
                //         maxId = Math.max(maxId, rec.get('Id'));
                //     });
                // }
                store.add(new ClubManagement.model.Users(
                //     { 
                //         Id: (maxId+1),
                //         userId: 'User-'+(maxId+1), 
                //         role: 'USER' 
                //     }
                ));
                store.sync();
            }
        }
    ],
    items: [{
        xtype: 'grid',
        flex: 1,
        selectable: {mode: 'single'},
        bind: {
            store: 'ClubManagement.store.Users',
        },
        plugins: 
        {
            type: 'grideditable'
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
        }
    }]
 
});
