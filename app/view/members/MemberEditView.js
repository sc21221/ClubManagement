
Ext.define('ClubManagement.view.Members.MemberEditView',{
    extend: 'Ext.Panel',
    xtype: 'ClubManagement-membereditview',
    id: 'ClubManagement-membereditview',
    requires: [
        'ClubManagement.view.Members.MemberEditViewController',
    	'ClubManagement.store.Members',
        'ClubManagement.model.Members',
        'ClubManagement.store.Sex',
        'ClubManagement.view.main.MainViewModel'
    ],

    controller: 'members-membereditview',
    viewModel: { type: 'ClubManagement-mainviewmodel'},

    bind: {
        title: 'Details for ({selectedMember.Id}) {selectedMember.nachname}, {selectedMember.vorname}'
    },
    title: 'xx',
    session: true,    
    tools: [{
        itemId: 'save',
        type: 'save',
        handler: 'onSave'
    }],
    listeners: {
        initialize: 'onInit'
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


    // ,{
    //         title:'Bankdaten',
    //         layout:'form',
    //         // defaults: {width: 120},
    //         // defaultType: 'textfield',

    //         items: [{
    //           layout:'column',
    //           items:[{
    //             columnWidth:.5,
    //             layout: 'form',
	//             items: [{
	//             	xtype:'textfield',
	//             	width: 240,
	//                 fieldLabel: 'BLZ',
	//                 name: 'blz',
	// 				maskRe: /[0-9]/,
	//                 maxLength: 8,
	//                 maxLengthText: 'Feld BLZ darf max. 8 Zeichen lang sein!'
	//             },{
	//             	xtype:'textfield',
	//             	width: 240,
	//                 fieldLabel: 'Kontonummer',
	//                 name: 'kontonummer',
	// 				maskRe: /[0-9]/,
	//                 maxLength: 30,
	//                 maxLengthText: 'Feld Kontonummer darf max. 30 Zeichen lang sein!'
	//             },{
	//             	xtype:'textfield',
	//             	width: 240,
	//                 fieldLabel: 'Bank',
	//                 name: 'bank',
	//                 maxLength: 20,
	//                 maxLengthText: 'Feld Bank darf max. 20 Zeichen lang sein!'
	//             },{
	//             	xtype:'textfield',
	//             	width: 240,
	//                 fieldLabel: 'Kontoinhaber',
	//                 name: 'kontoinhaber',
	//                 maxLength: 60,
	//                 maxLengthText: 'Feld Kontoinhaber darf max. 20 Zeichen lang sein!'
	//             }]
    //           },{
    //             layout:'form',
    //             columnWidth:.5,
	//             items: [{
	//             	xtype:'textfield',
	//             	width: 240,
	//                 fieldLabel: 'BIC',
	//                 name: 'BIC',
	// 				maxLength: 11,
	//                 maxLengthText: 'Feld BIC darf max. 11 Zeichen lang sein!'
	//             },{
	//             	xtype:'textfield',
	//             	width: 240,
	//                 fieldLabel: 'IBAN',
	//                 name: 'IBAN',
	//                 maxLength: 34,
	//                 maxLengthText: 'Feld IBAN darf max. 34 Zeichen lang sein!'
	//             }]
    //           }]
    //         }]
    //     },{
    //         cls:'x-plain',
    //         title:'Beitragsdaten',
    //         layout:'form',
    //         defaults: {width: 230},
    //         defaultType: 'textfield',
    //         items: [{
    //           fieldLabel: 'Geschlecht',
    //           name: 'geschlecht'
    //           ,xtype:'combo',typeAhead: true,triggerAction: 'all',store: 'sex',hiddenName:'geschlecht', valueField: 'myId',displayField: 'displayText',mode: 'local',lazyRender: true,listClass: 'x-combo-list-small'
    //         },{
    //           fieldLabel: 'Rechnungs-KZ',
    //           name: 'rekz'
    //           ,xtype:'combo',typeAhead: true,triggerAction: 'all',
    //           //store: ReKzStore,
    //           hiddenName:'rekz', valueField: 'myId',displayField: 'displayText',mode: 'local',lazyRender: true,listClass: 'x-combo-list-small'
    //         },{
    //           fieldLabel: 'Zahlungs-KZ',
    //           name: 'zahlungskz'
    //           ,xtype:'combo',typeAhead: true,triggerAction: 'all',
    //           //store: ZahlKzStore,
    //           hiddenName:'zahlungskz',valueField: 'myId',displayField: 'displayText',mode: 'local',lazyRender: true,listClass: 'x-combo-list-small'
    //         },{
    //           fieldLabel: 'Beitrag 1',
    //           name: 'beitrag_id'
    //           ,xtype:'combo',typeAhead: true,triggerAction: 'all',
    //           //store: BeitragsklassenStore,
    //           hiddenName:'beitrag_id',valueField: 'id',displayField: 'bezeichnung',mode: 'local',lazyRender: true,listClass: 'x-combo-list-small'
    //         },{
    //           fieldLabel: 'Beitrag 2',
    //           name: 'beitrag_id2'
    //           ,xtype:'combo',typeAhead: true,triggerAction: 'all',
    //           //store: BeitragsklassenStore,
    //           hiddenName:'beitrag_id2',valueField: 'id',displayField: 'bezeichnung',mode: 'local',lazyRender: true,listClass: 'x-combo-list-small'
    //         },{
    //           fieldLabel: 'Beitrag 3',
    //           name: 'beitrag_id3'
    //           ,xtype:'combo',typeAhead: true,triggerAction: 'all',
    //           //store: BeitragsklassenStore,
    //           hiddenName:'beitrag_id3',valueField: 'id',displayField: 'bezeichnung',mode: 'local',lazyRender: true,listClass: 'x-combo-list-small'
    //         }]
    //     },{
    //       cls:'x-plain',
    //       title:'Daten',
    //       layout:'form',
    //       defaults: {width: 230},
    //       defaultType: 'textfield',
    //       items: [{
    //         xtype:'textfield',
    //         fieldLabel: 'Beruf',
    //         name: 'beruf'
    //       },{
    //         fieldLabel: 'Geburtsdatum',
    //         name: 'gebdat',
    //         xtype: 'xdatefield',
    //         allowBlank:false
    //       },{
    //         fieldLabel: 'Eintrittsdatum',
    //         name: 'eindat',
    //         xtype: 'xdatefield',
    //         allowBlank:false
    //       },{
    //         fieldLabel: 'Sonderdatum',
    //         name: 'sonderdat',
    //         xtype: 'xdatefield',
    //         allowBlank:true
    //       },{
    //         fieldLabel: 'Austrittsdatum',
    //         name: 'ausdat',
    //         xtype: 'xdatefield',
    //         allowBlank:true
    //       }]
    //   }]
    //}
