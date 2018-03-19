Ext.define('ClubManagement.store.SalutationStore', {
    extend: 'Ext.data.Store',
    alias: 'store.salutation',
    fields: ['myId','displayText'],
    data: [[1, 'Herr'], 
           [2, 'Frau']]
  });