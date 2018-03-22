
Ext.define('ClubManagement.view.Members.MemberEditView',{
    extend: 'Ext.Panel',
    xtype: 'ClubManagement-membereditview',
    id: 'ClubManagement-membereditview',
    requires: [
        'ClubManagement.view.Members.MemberEditViewController',
    	'ClubManagement.store.Members',
        'ClubManagement.model.Members',
        'ClubManagement.store.Sex',
        'ClubManagement.view.main.MainViewModel',
        'ClubManagement.store.FeesStore'
    ],

    controller: 'members-membereditview',
    viewModel: { type: 'ClubManagement-mainviewmodel'},

    bind: {
        title: 'Details for ({selectedMember.Id}) {selectedMember.nachname}, {selectedMember.vorname}'
    },
    session: true,    
    tools: [{
        itemId: 'save',
        type: 'save',
        handler: 'onSave'
    }],
    listeners: {
        initialize: 'onInit',
        updatedata: 'onUpdateData'
    },  
    layout: {
        type: 'card',
        animation: {
            type: 'slide'
        }
    },
    items: [{
        xtype: 'tabpanel',
        tabBarPosition: 'bottom',
        defaultType: 'container',
        items:[
            {
            // title: 'Member',
            iconCls: 'x-fa fa-user',
            xtype: 'formpanel',
            items: [{
                defaults: {
                    xtype: 'textfield'
                },
                items:[{
                    label: 'MitgliedsNr',
                    readOnly: true,
                    blankText: 'neues Mitglied',
                    bind: '{selectedMember.Id}'
                },{
                    label: 'Anrede',
                    bind: '{selectedMember.anrede}',
                    xtype: 'combobox',
                    queryMode: 'local',
                    displayField: 'displayText',
                    valueField: 'displayText',           
                    store: 'ClubManagement.store.SalutationStore'
                },{
                    label: 'Vorname',
                    bind: '{selectedMember.vorname}'
                },{
                    label: 'Nachname',
                    xtype: 'textfield',
                    bind: { value: '{selectedMember.nachname}'}
                },{
                    label: 'Titel',
                    bind: '{selectedMember.titel}'
                },{
                    label: 'Zusatz',
                    bind: '{selectedMember.zusatz}'
                },{
                    xtype: 'combobox',
                    label: 'Geschlecht',
                    queryMode: 'local',
                    displayField: 'displayText',
                    valueField: 'Id',           
                    store: 'ClubManagement.store.Sex'
                }]
            }]
        },{
            xtype: 'formpanel',
            iconCls: 'x-fa fa-home',
            defaults: {
                xtype: 'textfield'
            },
            items: [{
                label: 'Strasse',
                name: 'strasse',
                bind: '{selectedMember.strasse}'
            },{
                label: 'PLZ',
                name: 'plz',
                bind: '{selectedMember.plz}'
            },{
                label: 'Ort',
                name: 'ort',
                bind: '{selectedMember.ort}'
            },{
                label: 'Land',
                name: 'land',
                bind: '{selectedMember.land}'
            },{
                label: 'Telefon 1',
                name: 'telefon1',
                bind: '{selectedMember.telefon1}'
            },{
                label: 'Telefon 2',
                name: 'telefon2',
                bind: '{selectedMember.telefon2}'
            },{
                label: 'Telefax',
                name: 'telefax',
                bind: '{selectedMember.telefax}'
            },{
                label: 'Email',
                name: 'email',
                vtype:'email',
                bind: '{selectedMember.email}'
            }]
        },{
            xtype: 'formpanel',
            iconCls: 'x-fa fa-credit-card',
            defaults: {
                xtype: 'textfield'
            },
            items: [{
                xtype: 'combobox',
                label: 'Zahlungsart',
                queryMode: 'local',
                displayField: 'displayText',
                valueField: 'Id',           
                store: 'ClubManagement.store.PaymentModeStore',
                bind: '{selectedMember.zahlungskz}'
            },{
                label: 'Beitrag',
                // bind: '{}',
                xtype: 'combobox',
                queryMode: 'local',
                displayField: 'displayText',
                valueField: 'displayText',           
                store: 'ClubManagement.store.FeesStore'
            },{
                label: 'Kontoinhaber',
                name: 'kontoinhaber',
                bind: '{selectedMember.kontoinhaber}'
            },{
                label: 'IBAN',
                name: 'IBAN',
                bind: '{selectedMember.IBAN}'
            },{
                label: 'BIC',
                name: 'BIC',
                bind: '{selectedMember.BIC}'
            },{
                label: 'Bank',
                name: 'bank',
                bind: '{selectedMember.bank}'
            },{
                label: 'BLZ',
                name: 'blz',
                bind: '{selectedMember.blz}'
            },{
                label: 'Kontonummer',
                name: 'kontonummer',
                bind: '{selectedMember.kontonummer}'
            }]
        },{
            xtype: 'grid',
            iconCls: 'x-fa fa-usd',
            reference: 'gridFeeAssignment',
            selectable: {
                mode: 'multi',
                drag: true,
                checkbox: true
            },
            listeners: {
                selectionchange: 'onFeeAssignmentSelectionChange'
            },
            store: 'ClubManagement.store.FeesStore',
            columns: [
                { text: 'Bezeichnung', dataIndex: 'bezeichnung', editable: false, flex: 1 },
                { text: 'Bemerkung', dataIndex: 'bemerkung', editable: false, flex: 1 }
            ]
        },{
            xtype: 'formpanel',
            iconCls: 'x-fa fa-calendar',
            defaults: {
                xtype: 'datefield'
            },
            items: [{
                label: 'Geburtsdatum',
                name: 'gebdat',
                dateFormat: 'd.m.Y',
                bind: '{selectedMember.gebdat}'
            },{
                label: 'Eintrittsdatum',
                name: 'eindat',
                dateFormat: 'd.m.Y',
                bind: '{selectedMember.eindat}'
            },{
                label: 'Sonderdatum',
                name: 'sonderdat',
                dateFormat: 'd.m.Y',
                bind: '{selectedMember.sonderdat}'
            },{
                label: 'Austrittsdatum',
                name: 'ausdat',
                dateFormat: 'd.m.Y',
                bind: '{selectedMember.ausdat}'
            }]
        }]
    }]
});