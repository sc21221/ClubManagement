Ext.define('ClubManagement.store.PrintMenuStore', {
    extend: 'Ext.data.Store',
    alias: 'store.printmenustore',
    fields: ['icon','text','description'],
    data: [ 
        ['fa fa-list', 'Mitgliederliste', 'erzeugt eine Liste aller Mitglieder'], 
        ['fa fa-birthday-cake', 'Geburtstagsliste', 'erzeugt eine Liste mit runden Geburtstagen der Mitglieder'], 
        ['fa fa-glass', 'Jubiläumsliste', 'erzeugt eine Liste mit runden Vereinsjubiläen der Mitglieder'], 
        ['fa fa-eur', 'Beiträge', 'erzeugt eine Liste mit den Beitragsdaten aller Mitglieder'], 
    ]
  });