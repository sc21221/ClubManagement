Ext.define('ClubManagement.view.Members.MemberEditViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.members-membereditview'

    , onInit: function() {
    }

    , onSave: function () {
        
        console.log("MemberEditViewController:update Store");
        var store = Ext.getStore('Members');
        store.sync({
            success: function(b, o) {
                console.log("store: sync-success");
            },
            failure: function(b, o) {
                console.log("store: sync-failure: ");
                console.log(b.exceptions);
            }
        });
    }
});
