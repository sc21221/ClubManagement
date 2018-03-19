Ext.define('ClubManagement.view.members.MembersGridViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.members-membersgridview'

    , onGridInit: function() {
        console.log("MembersGrid: onGridInit()");
    }
    
    , onActionSearch: function (cmp) {
        var me          = this,
            searchValue = cmp.getValue(),
            store       = Ext.ComponentQuery.query('grid')[0].getStore();

        if (!Ext.isEmpty(store)) {
            store.clearFilter();

            if (!Ext.isEmpty(searchValue)) {
                var regEx  = new RegExp(searchValue, 'i'),
                    fields = ['vorname', 'nachname', 'strasse', 'ort'],
                    i;
                store.filterBy(function (rec) {
                    for (i = 0; i < fields.length; i++) {
                        if (regEx.test(rec.get([fields[i]]))) {
                            return true;
                        }
                    }
                });
            }
        }
    }

    , onClearIconTapSearch : function(){
        var store = Ext.ComponentQuery.query('grid')[0].getStore();

        if (!Ext.isEmpty(store)){
            store.clearFilter()
        }
    }

    , onMemberSelect: function(grid, person) {
        console.log("onMemberSelect: person=" + person.get('nachname'));
        this.getViewModel().set('selectedMember', person);
        Ext.getCmp('ClubManagement-membereditview').getViewModel().set('selectedMember', person);
        this.getViewModel().set('detailCollapsed', false);
    }
 });
