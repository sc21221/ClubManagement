Ext.define('ClubManagement.store.PaymentModeStore', {
    extend: 'Ext.data.Store',
    alias: 'store.paymentmode',
    fields: ['Id','displayText'],
    data: [ 
        ['1', 'Sepa Einzug'], 
        ['2', 'Rechnung'],
        ['0', 'keine Faktura']
    ]
  });