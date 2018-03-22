 Ext.define('ClubManagement.store.FeesStore', {
    extend: 'Ext.data.Store'

    , alias: 'store.fees'
    , model: 'ClubManagement.model.Fees'
    , pageSize: 500
    , autoSync: true
    , proxy: {
        type: 'direct'
         , api: {
            prefix: 'Fees',
            read: 'getGrid',
            create: 'create',
            update: 'update',
            destroy: 'delete'
        }
        , metadata: {
            _table: 'beitrag',
            _sort: 'id',
            _key: 'id'
        }
        , reader: {
            totalProperty: 'total',
            rootProperty: 'data'
        }
    }
   , autoLoad: true
 });