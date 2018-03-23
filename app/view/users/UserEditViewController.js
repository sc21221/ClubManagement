Ext.define('ClubManagement.view.users.UserEditViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.users-usereditview'
    , onSave: function () 
    {        
        console.log("UserEditViewController:update Store");
        if( this.getView().isValid() )
        {
            var store = Ext.getStore('ClubManagement.store.Users');
            store.sync({
                success: function(b, o) {
                    console.log("Users: sync-success");
                    o.viewmodel.set('detailCollapsed', true);
                    Ext.toast('User update gespeichert!', 2500);
                },
                failure: function(b, o) {
                    console.log("Users: sync-failure: ");
                    console.log(b.exceptions);
                    Ext.Msg.alert("User", "User konnte nicht gespeichert werden:" + b.exceptions);
                },
                viewmodel: this.getViewModel()
            });
        } else {
            Ext.Msg.alert("Edit User", "Nicht alle Felder sind gültig, bitte prüfen.");
        }
    }
});
