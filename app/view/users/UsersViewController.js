Ext.define('ClubManagement.view.users.UsersViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.users-usersview'
    
    
    , onGridInit: function() {
        console.log("UsersViewController:load Store");
        var store = Ext.getStore('ClubManagement.store.Users');
        store.load();
    }

});
