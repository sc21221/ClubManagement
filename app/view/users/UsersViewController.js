Ext.define('ClubManagement.view.users.UsersViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.users-usersview'
    
    
    , onGridInit: function() {
        console.log("UsersViewController:load Store");
        var store = Ext.getStore('ClubManagement.store.Users');
        store.load();
    }

    , onAdd: function() {
        var store = Ext.getStore('ClubManagement.store.Users');
        var newUser = store.add(new ClubManagement.model.Users());
        this.lookup("usersgrid").setSelection(newUser);
    }

    , onUserSelect: function(grid, person) {
        console.log("onUserSelect: user=" + person.get('surname'));
        ClubManagement.getApplication().changeDetailView('ClubManagement-usereditview', 'Details for User');
        Ext.getCmp('ClubManagement-usereditview').getViewModel().set('selectedUser', person);
        this.getViewModel().set('detailCollapsed', false);
    }
});
