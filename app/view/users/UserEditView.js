
Ext.define('ClubManagement.view.users.UserEditView',{
    extend: 'Ext.form.Panel',
    xtype: 'ClubManagement-usereditview',
    id:    'ClubManagement-usereditview',
    requires: [
        'ClubManagement.view.users.UserEditViewController',
        'ClubManagement.view.users.UserEditViewModel'
    ],

    controller: 'users-usereditview',
    viewModel: {
        type: 'users-usereditview'
    },
    modelValidation: true,
    tools: [{
        itemId: 'save',
        type: 'save',
        handler: 'onSave'
    }],
    bind: {
        title: 'Details for ({selectedUser.id}) {selectedUser.surname}, {selectedUser.firstname}'
    },
    items:[{
        label: 'UserId',
        xtype: 'textfield',
        bind: '{selectedUser.userId}',
        validator: function(val) {
            if (!Ext.isEmpty(val)) {
                return true;
            }
            else {
                return "User ID darf nicht leer sein !";
            }
        }
    },{
        label: 'Vorname',
        xtype: 'textfield',
        bind: '{selectedUser.firstname}'
    },{
        label: 'Nachname',
        xtype: 'textfield',
        bind:  '{selectedUser.surname}'
    },{
        label: 'Passwort',
        xtype: 'passwordfield',
        bind: '{selectedUser.password}',
        validator: function(val) {
            if (!Ext.isEmpty(val)) {
                return true;
            }
            else {
                return "Passwort darf nicht leer sein !";
            }
        }
    },{
        xtype: 'combobox',
        label: 'Rolle',
        editable: false,
        forceSelection: true,
        queryMode: 'local',
        displayField: 'description',
        valueField: 'roleId',           
        store: 'ClubManagement.store.Role',
        bind: '{selectedUser.role}'
    }]
});
