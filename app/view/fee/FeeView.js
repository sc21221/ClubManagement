
Ext.define('ClubManagement.view.fee.FeeView',{
    extend: 'Ext.panel.Panel',
    xtype: 'ClubManagement-feesview',
    requires: [
        'ClubManagement.view.fee.FeeViewController',
        'ClubManagement.view.fee.FeeViewModel',
        'ClubManagement.store.FeesStore',
        'ClubManagement.model.Fees'
    ],

    controller: 'fee-feeview',
    viewModel: {
        type: 'fee-feeview'
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
                var store = Ext.getStore('ClubManagement.store.FeesStore');
                store.add(new ClubManagement.model.Fees());
                store.sync();
            }
        },{
            type: 'minus',
            handler: function() {
                var store = Ext.getStore('ClubManagement.store.FeesStore');
                store.add(new ClubManagement.model.Fees());
                store.sync();
            }
        }
    ],
    items: [{
        xtype: 'grid',
        flex: 1,
        selectable: {mode: 'single'},
        bind: {
            store: 'ClubManagement.store.FeesStore',
            selection: '{currentFee}'
        },
        plugins: 
        {
            type: 'grideditable'
        },
        columns: [
            { text: 'Id', dataIndex: 'id', editable: false, hidden: false },
            { text: 'Bezeichnung', dataIndex: 'bezeichnung', editable: true },
            { text: 'Alter Von 1', dataIndex: 'alterVon1', editable: true },
            { text: 'Alter Bis 1', dataIndex: 'alterBis1', editable: true },
            { text: 'Beitrag 1', dataIndex: 'beitrag1', editable: true, xtype: 'numbercolumn', format:'0.00 €'},
            { text: 'Alter Von 2', dataIndex: 'alterVon2', editable: true },
            { text: 'Alter Bis 2', dataIndex: 'alterBis2', editable: true },
            { text: 'Beitrag 2', dataIndex: 'beitrag2', editable: true, xtype: 'numbercolumn', format:'0.00 €'},
            { text: 'Alter Von 3', dataIndex: 'alterVon3', editable: true },
            { text: 'Alter Bis 3', dataIndex: 'alterBis3', editable: true },
            { text: 'Beitrag 3', dataIndex: 'beitrag3', editable: true, xtype: 'numbercolumn', format:'0.00 €'},
            { text: 'Bemerkung', dataIndex: 'bemerkung', editable: true }
        ]
    }]
});
