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
            store.filter('memberId', r.data.memberId);
            console.log("MemberEditViewController:getFeeSelection(): load for Member Id=" + r.data.memberId);
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
                    this.getViewModel().set("assignmentChanged", false);
                }
            });

            //gridFeeAssignment
        }
    }
    , onFeeAssignmentSelectionChange: function(grid, selection, opts)
    {
        this.getViewModel().set("assignmentChanged", true);
    }
    , onSave: function () 
    {        
        console.log("MemberEditViewController:update Store");
        var store = Ext.getStore('Members');
        store.sync({
            success: function(b, o) {
                console.log("store: sync-success");
                o.viewmodel.set('detailCollapsed', true);
                Ext.toast('Mitglied gespeichert!', 2500);
            },
            failure: function(b, o) {
                console.log("store: sync-failure: ");
                console.log(b.exceptions);
                Ext.Msg.alert("User", "Mitglied konnte nicht gespeichert werden:" + b.exceptions);
            },
            viewmodel: this.getViewModel()
        });
        if(this.getViewModel().get("assignmentChanged"))
        {
            // Sync Member-Fee Assignment
            var memberRecord = this.getViewModel().get('selectedMember');
            var grid = this.lookupReference("gridFeeAssignment");
            var feestore = Ext.getStore('ClubManagement.store.MemberFeeStore');
            var selected = grid.getSelected().items;
            var beitrag_id2del = "";

            // Delete no longer assigned Fees
            feestore.each(function(record) {
                // if( record ){
                    console.log(record);
                    console.log(grid.getSelected().find("id",record.get("beitrag_id")));
                    if( !grid.getSelected().find("id",record.get("beitrag_id")))
                    feestore.remove(record);
                    beitrag_id2del += record.get("beitrag_id") + ";";
                // }
            });
            // Add new assigned Fees
            Ext.Array.each(selected, function(record){
                if( !feestore.findRecord("beitrag_id", record.get("id")))
                {
                    feestore.add(new ClubManagement.model.MemberFee(
                            { 
                                mitglied_id: memberRecord.get("Id"),
                                beitrag_id: record.get("id")
                            }));
                }
            });
            
            // feestore.getProxy().metadata.member_id = memberRecord.get("Id");
            // feestore.getProxy().metadata.beitrag_id2del = beitrag_id2del;

            feestore.sync({
                success: function(b, o) {
                    console.log("feestore: sync-success");
                    o.viewmodel.set('detailCollapsed', true);
                    Ext.toast('Mitgliedsbeiträge gespeichert!', 2500);
                   },
                failure: function(b, o) {
                    console.log("feestore: sync-failure: ");
                    console.log(b.exceptions);
                },
                viewmodel: this.getViewModel()
            });
            // var dataToPost = {
            //     action: 'MemberFee',
            //     data: selected,
            //     metadata: {
            //         _table: 'mitglied_beitrag',
            //         _key: 'mitglied_id'
            //     },
            //     method: 'update'
            // };
            // Ext.Ajax.request({
            //     url: 'ajax_demo/sample.json',
           
            //     success: function(response, opts) {
            //         var obj = Ext.decode(response.responseText);
            //         console.dir(obj);
            //     },
           
            //     failure: function(response, opts) {
            //         console.log('server-side failure with status code ' + response.status);
            //     }
            // });
        }
    }

    , onUpdateData: function() 
    {
        
    }
});
