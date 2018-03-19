 Ext.define('ClubManagement.store.Club', {
    extend: 'Ext.data.Store'

    , alias: 'store.club'
    , model: 'ClubManagement.model.Club'
    , pageSize: 1
    , autoSync: true
    , proxy: {
        type: 'direct'
         , api: {
            prefix: 'Club',
            read: 'getGrid',
            create: 'create',
            update: 'update'
        }
        , metadata: {
            _table: 'verein',
            _sort: 'name',
            _key: 'Id'
        }
        , reader: {
            totalProperty: 'total',
            rootProperty: 'data'
        }
    }
    , autoLoad: true
 });