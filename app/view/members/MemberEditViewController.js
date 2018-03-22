Ext.define('ClubManagement.view.Members.MemberEditViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.members-membereditview'

    , onInit: function() {
        // This is another way of working around the problem - we use binding
        // to monitor a random 'trigger' value in the viewmodel, and whenever
        // we change the anything in the viewmodel we also change the trigger value.
        
        this.getViewModel().bind('{selectedMember}', this.getFeeSelection, this);
        console.log("MemberEditViewController:onInit");
    }

    , getFeeSelection: function() {
        var r = this.getViewModel().get('selectedMember');
        console.log("MemberEditViewController:getFeeSelection(" + r + ")");
        console.log(r);

        var store = Ext.getStore('ClubManagement.store.MemberFeeStore');
        
        if( r && r.data && r.Id !=="" )
        {
            store.clearFilter();
            store.filter('mitglied_id', r.data.Id);
            console.log("MemberEditViewController:getFeeSelection(): load for Member Id=" + r.data.Id);
            //Server side filtering requires a load call
            store.load({
                scope: this,
                callback: function(records, operation, success) {
                    // the operation object
                    // contains all of the details of the load operation
                    console.log(records);
                    var grid = this.lookupReference("gridFeeAssignment");
                    grid.deselectAll();
                    var selection = [];
                    Ext.Array.each(records, function(record) {
                        var memberRecord = grid.getStore().findRecord("id", record.get('beitrag_id'));
                        if(memberRecord)
                        {
                            selection.push(memberRecord);
                        }
                    });
                    grid.setSelection(selection);

                }
            });

            //gridFeeAssignment
        }
    }
    , onFeeAssignmentSelectionChange: function(grid, selection, opts)
    {
        console.log(selection);
    }
    , onSave: function () 
    {        
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

    , onUpdateData: function() 
    {
        
    }
});
