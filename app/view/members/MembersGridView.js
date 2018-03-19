
Ext.define('ClubManagement.view.members.MembersGridView',{
    extend: 'Ext.Panel',
	xtype: 'ClubManagement-membersgridview',
    requires: [
        'ClubManagement.view.members.MembersGridViewController',
    	'ClubManagement.store.Members',
        'ClubManagement.model.Members',
        'ClubManagement.view.main.MainViewModel'
    ],

    controller: 'members-membersgridview',
    viewModel: { type: 'ClubManagement-mainviewmodel'},
    session: true, 

    reference: 'membersgridview',
    layout: 'vbox',

    items: [{
        xtype: 'toolbar',
        dock: 'top',
        items: [{
            xtype: 'textfield',
            label: 'Search',
            listeners: {
                action: 'onActionSearch',
                clearicontap: 'onClearIconTapSearch'
            }
        }]
    }, {
        xtype: 'grid',
        flex: 1,
        selectable: {mode: 'single'},
        bind: {
            store: 'Members',
        },
        columns: [
            { text: 'Nachname', dataIndex: 'nachname', editable: true },
            { text: 'Vorname', dataIndex: 'vorname', editable: true },
            { text: 'Straße', dataIndex: 'strasse', editable: true },
            { text: 'PLZ', dataIndex: 'plz', editable: true },
            { text: 'Ort', dataIndex: 'ort', editable: true },
            { text: 'Email', dataIndex: 'email', editable: true },
            { text: 'Telefon', dataIndex: 'telefon1', editable: true },
            { text: 'Geburtsdatum', dataIndex: 'gebdat', editable: true },
            { text: 'ZahlungsKz', dataIndex: 'zahlungskz', editable: false, hidden: true }
        ]
        , plugins: {
            pagingtoolbar: true,
            // grideditable: {
            //     triggerEvent: 'childdoubletap',
            //     enableDeleteButton: true,
            //     formConfig: null,
            //     defaultFormConfig: {
            //         xtype: 'formpanel',
            //         scrollable: true,
            //         items: [{
            //             xtype: 'fieldset'
            //         }]
            //     },
            //     toolbarConfig: {
            //         xtype: 'titlebar',
            //         docked: 'top',
            //         items: [{
            //             xtype: 'button',
            //             ui: 'decline',
            //             text: 'Cancel',
            //             align: 'left',
            //             action: 'cancel'
            //         }, {
            //             xtype: 'button',
            //             ui: 'confirm',
            //             text: 'Submit',
            //             align: 'right',
            //             action: 'submit'
            //         }]
            //     },
            // }
            // ,gridviewoptions: true  
        } 
        , listeners: {
            initialize: 'onGridInit'
            , select: 'onMemberSelect'
        }
    }]
 });
