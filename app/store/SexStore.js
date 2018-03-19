Ext.define('ClubManagement.store.Sex', {
    extend: 'Ext.data.Store',
    alias: 'store.sex',
    fields: ['myId','displayText'],
    data: [[1, 'männlich'], 
           [2, 'weiblich']]
  });