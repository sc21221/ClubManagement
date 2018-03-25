Ext.define('ClubManagement.store.PrintMenuStore', {
    extend: 'Ext.data.Store',
    alias: 'store.printmenustore',
    fields: ['icon','text','description','url'],
    data: [ 
        ['fa fa-list', 'Mitgliederliste', 'erzeugt eine Liste aller Mitglieder', 'php/classes/Reports.php?liste=mitglieder'], 
        ['fa fa-birthday-cake', 'Geburtstagsliste', 'erzeugt eine Liste mit runden Geburtstagen der Mitglieder', 'php/classes/Reports.php?liste=geburtstag'], 
        ['fa fa-glass', 'Jubiläumsliste', 'erzeugt eine Liste mit runden Vereinsjubiläen der Mitglieder', 'php/classes/Reports.php?liste=jubi'], 
        ['fa fa-eur', 'Beiträge', 'erzeugt eine Liste mit den Beitragsdaten aller Mitglieder', 'php/classes/Reports.php?liste=beitrag'], 
    ]
  });