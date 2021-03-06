 Ext.define('ClubManagement.store.Members', {
    extend: 'Ext.data.Store'

    , alias: 'store.members'
    , model: 'ClubManagement.model.Members'
    , pageSize: 100
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
            _key: 'memberId'
        }
        , reader: {
            totalProperty: 'total',
            rootProperty: 'data'
        }
        , writer: {
            dateFormat: 'Y-m-d'
        }
    }
   , autoLoad: true
 });