 Ext.define('ClubManagement.store.Users', {
    extend: 'Ext.data.Store'

    , alias: 'store.users'
    , model: 'ClubManagement.model.Users'
    , pageSize: 500
    , autoSync: false
    , proxy: {
        type: 'direct'
         , api: {
            prefix: 'Users',
            read: 'getGrid',
            create: 'create',
            update: 'update',
            destroy: 'delete'
        }
        , metadata: {
            _table: 'user',
            _sort: 'surname',
            _key: 'id'
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
    , autoLoad: false
 });