 Ext.define('ClubManagement.store.MemberFeeStore', {
    extend: 'Ext.data.Store'

    , alias: 'store.memberfee'
    , model: 'ClubManagement.model.MemberFee'
    , pageSize: 500
    , autoSync: false
    , autoLoad: false
    , remoteFilter: true
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
            _sort: 'memberId',
            _key: 'feeMemberId',
            _fields: "CONCAT(memberId,'/',beitrag_id) as id,memberId,beitrag_id"
        }
        , reader: {
            totalProperty: 'total',
            rootProperty: 'data'
        }
    }
 });