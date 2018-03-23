Ext.define('ClubManagement.store.Role', {
    extend: 'Ext.data.Store',
    alias: 'store.role',
    fields: ['roleId','description'],
    data: [['user', 'Benutzer'], 
           ['admin', 'Administrator']]
  });