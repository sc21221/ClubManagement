Ext.define('ClubManagement.model.MemberFee', {
	extend: 'ClubManagement.model.Base',
	fields: [
		{name: 'memberId', type: 'string'},
		{name: 'beitrag_id', type: 'string'},
		{name: 'feeMemberId', calculate: function (data) {
			return data.memberId + "-" + data.beitrag_id;
		}}
	]	
});
