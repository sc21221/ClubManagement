
Ext.define('ClubManagement.view.home.HomeView',{
    extend: 'Ext.panel.Panel',

    requires: [
        'ClubManagement.view.home.HomeViewController',
        'ClubManagement.view.home.HomeViewModel'
    ],
    xtype: 'ClubManagement-homeview',
    itemId: 'ClubManagement-homeview',
    controller: 'home-homeview',
    viewModel: {
        type: 'home-homeview'
    },

    html: '<h2>Members Management</h2>'
});
