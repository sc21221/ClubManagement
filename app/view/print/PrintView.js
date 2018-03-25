
Ext.define('ClubManagement.view.print.PrintView',{
    extend: 'Ext.Container',
    xtype: 'ClubManagement-printview',
    itemId: 'ClubManagement-printview',
    requires: [
        'ClubManagement.view.print.PrintViewController',
        'ClubManagement.view.print.PrintViewModel'
    ],

    controller: 'print-printview',
    viewModel: {
        type: 'print-printview'
    },

    layout: 'fit',
    items: [{
        xtype: 'dataview',
        cls: 'dataview-print',
        itemTpl: '<a href="{url}" target="_blank"><div class="img"><i class="{icon}"></i></div>' +
            '<div class="content">' +
                '<div class="name">{text}</div>' +
                '<div class="affiliation">{description}</div>' +
            '</div></a>',
        store: 'ClubManagement.store.PrintMenuStore',
        selectable: { mode: 'single'},
        plugins: {
            dataviewtip: {
                align: 'tl-bl',
                maxHeight: 200,
                width: 300,
                scrollable: 'y',
                delegate: '.div',
                allowOver: true,
                anchor: true,
                bind: '{record}',
                cls: 'dataview-print',
                tpl: '<strong>Title</strong><div class="info">{description}</div>' +
                    '<strong>Description</strong><div class="info">{description}</div>' 
            }
        },
        listeners: {
            select: 'onPrintMenuSelect'
        }
    }],
});
