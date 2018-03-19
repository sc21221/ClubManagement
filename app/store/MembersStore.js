 Ext.define('ClubManagement.store.Members', {
    extend: 'Ext.data.Store'

    , alias: 'store.members'
    , model: 'ClubManagement.model.Members'
    , pageSize: 500
    , autoSync: false
    , proxy: {
        type: 'direct'
         , api: {
            prefix: 'Members',
            read: 'getGrid',
            create: 'create',
            update: 'update',
            destroy: 'delete'
        }
        , metadata: {
            _table: 'mitglied',
            _sort: 'nachname',
            _key: 'Id'
        }
        , reader: {
            totalProperty: 'total',
            rootProperty: 'data'
        }
    }

    , listeners: {
        // update: function(store, record, operation, modifiedFieldNames, details, eOpts)
        // {
        //     console.log("Store:update : " + record.get("nachname"));
        //     store.sync({
        //         success: function(b, o) {
        //             console.log("store: sync-success");
        //         },
        //         failure: function(b, o) {
        //             console.log("store: sync-failure: ");
        //             console.log(b.exceptions);
        //         }
        //     });
        // }
    }
    , autoLoad: true
 });