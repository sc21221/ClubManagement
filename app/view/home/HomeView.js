
Ext.define('ClubManagement.view.home.HomeView',{
    extend: 'Ext.panel.Panel',

    requires: [
        'ClubManagement.view.home.HomeViewController',
        'ClubManagement.view.home.HomeViewModel'
    ],

    controller: 'home-homeview',
    viewModel: {
        type: 'home-homeview'
    },

    html: 'Hello, World!!'
});
