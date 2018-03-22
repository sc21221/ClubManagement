 Ext.define('ClubManagement.store.MemberFeeStore', {
    extend: 'Ext.data.Store'

    , alias: 'store.memberfee'
    , model: 'ClubManagement.model.MemberFee'
    , pageSize: 500
    , autoSync: true
    , proxy: {
        type: 'direct'
         , api: {
            prefix: 'MemberFee',
            read: 'getGrid',
            create: 'create',
            update: 'update',
            destroy: 'delete'
        }
        , metadata: {
            _table: 'mitglied_beitrag',
            _sort: 'mitglied_id',
            _key: 'mitglied_id'
        }
        , reader: {
            totalProperty: 'total',
            rootProperty: 'data'
        }
    }
   , autoLoad: false
   , remoteFilter: true
 });