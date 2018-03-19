Ext.define('ClubManagement.store.RolesStore', {
    extend: 'Ext.data.Store',
    alias: 'store.roles',
    fields: ['role'],
    data: [['Administrator'], 
           ['Benutzer']]
  });