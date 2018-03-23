Ext.define('ClubManagement.view.main.MainViewController', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.ClubManagement-mainviewcontroller',

	init: function() {
		var me = this;
		me.getServerData()
		.then(function(response) {
			var vm = me.getViewModel(); 
			vm.set('navCollapsed', false);
			vm.set('detailCollapsed', true);
			me.lookup('ClubManagement-menuview').setStore(response.menuData);
			me.redirectTo( location.hash.slice(1), true );
		}, function(e) {
			console.log(e);
		})
	},

	getServerData: function () {
		return new Ext.Promise(function (resolve, reject) {
			try {
				Ext.Ajax.request({
					url: 'resources/app/data/menu.json',
					success: function(response, opts) {
						var menuData = Ext.decode(response.responseText);
						resolve({ menuData: menuData });
					},
					failure: function(response, opts) {
						return reject ('server-side failure with status code ' + response.status);
					}
				});
			}
			catch(err) {
				return reject(err);
			}
		});
	},

	routes: { 
		':xtype': {action: 'mainRoute'}
	},

	mainRoute:function(xtype) {
		var exists = Ext.ClassManager.getByAlias('widget.' + xtype);
		if (exists === undefined) {
			console.log(xtype + ' does not exist');
			return;
		}
		var menuview = this.lookup('ClubManagement-menuview');
		var centerview = this.lookup('ClubManagement-centerview');
		var node = menuview.getStore().findNode('xtype', xtype);
		if (node == null) {
			console.log('unmatchedRoute: ' + xtype);
			return;
		}
		if (!centerview.getComponent(xtype)) {
			centerview.add({ xtype: xtype, heading: node.get('text') });
		}
		centerview.setActiveItem(xtype);
		menuview.setSelection(node);
		var vm = this.getViewModel(); 
		vm.set('heading', node.get('text'));
		vm.set('detailCollapsed', true);
	},

	onMenuViewSelectionChange: function (tree, node) {
		var vm = this.getViewModel();
		if (node.get('xtype') != undefined) {
			this.redirectTo( node.get('xtype') );
		}
	},

	onHeaderViewNavToggle: function () {
		var vm = this.getViewModel();
		vm.set('navCollapsed', !vm.get('navCollapsed'));
	},

	onHeaderViewDetailToggle: function (button) {
		var vm = this.getViewModel();
		vm.set('detailCollapsed', !vm.get('detailCollapsed'));
		if(vm.get('detailCollapsed')===true) {
			button.setIconCls('x-fa fa-arrow-left');
		}
		else {
			button.setIconCls('x-fa fa-arrow-right');
		}
	},

//	onActionsViewLogoutTap: function( ) {
//		var vm = this.getViewModel();
//		vm.set('firstname', '');
//		vm.set('lastname', '');
//
//		Session.logout(this.getView());
//		this.redirectTo(AppCamp.getApplication().getDefaultToken().toString(), true);
//	}

});
