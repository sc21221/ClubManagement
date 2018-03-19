
Ext.define('ClubManagement.view.groups.GroupsView',{
    extend: 'Ext.panel.Panel',

    requires: [
        'ClubManagement.view.groups.GroupsViewController',
        'ClubManagement.view.groups.GroupsViewModel'
    ],

    controller: 'groups-groupsview',
    viewModel: {
        type: 'groups-groupsview'
    },

    html: 'Hello, World!!'
});
