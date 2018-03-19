Ext.define('ClubManagement.view.appointments.AppointmentsViewModel', {
	extend: 'Ext.app.ViewModel',
	alias: 'viewmodel.appointmentsviewmodel',
	stores: {
		appointments: {
			autoLoad: true,
			data: [
				{created: "2015-09-07T09:08:46.000Z", desc: "Office Visit", first: "Marc", last: "Gusmano", "type":"phone", recipient: { "picture":"resources/phone/portraits/men/10.jpg"}, doctor: "Dr. Bill Smith"},
				{created: "2016-09-07T09:08:46.000Z", desc: "Follow-up from Surgery", first: "Marc", last: "Gusmano", "type":"skype", recipient: { "picture":"resources/phone/portraits/men/11.jpg"}, doctor: "Dr. Joe Travers"},
				{created: "2016-09-07T09:08:46.000Z", desc: "Another Follow-up", first: "Marc", last: "Gusmano", "type":"linkedin", recipient: { "picture":"resources/phone/portraits/men/12.jpg"}, doctor: "Dr. Dave Andrews"},
				{created: "2017-09-07T09:08:46.000Z", desc: "Review for foot surgery", first: "Marc", last: "Gusmano", "type":"email", recipient: { "picture":"resources/phone/portraits/men/13.jpg"}, doctor: "Dr. Bob Ricci"},
				{created: "2017-09-07T09:08:46.000Z", desc: "Scheduled visit", first: "Marc", last: "Gusmano", "type":"phone", recipient: { "picture":"resources/phone/portraits/men/14.jpg"}, doctor: "Dr. Bill Betta"},
				{created: "2016-09-07T09:08:46.000Z", desc: "First time consultation", first: "Marc", last: "Gusmano", "type":"linkedin", recipient: { "picture":"resources/phone/portraits/men/12.jpg"}, doctor: "Dr. Ralph Simon"},
				{created: "2017-09-07T09:08:46.000Z", desc: "Check sprained ancle", first: "Marc", last: "Gusmano", "type":"email", recipient: { "picture":"resources/phone/portraits/men/13.jpg"}, doctor: "Dr. Pete Davies"},
				{created: "2017-09-07T09:08:46.000Z", desc: "Dermatology review", first: "Marc", last: "Gusmano", "type":"phone", recipient: { "picture":"resources/phone/portraits/men/14.jpg"}, doctor: "Dr. Bobby Fox"},
				{created: "2016-09-07T09:08:46.000Z", desc: "Visit for flu", first: "Marc", last: "Gusmano", "type":"linkedin", recipient: { "picture":"resources/phone/portraits/men/12.jpg"}, doctor: "Dr. Dan Flan"},
				{created: "2017-09-07T09:08:46.000Z", desc: "Check up", first: "Marc", last: "Gusmano", "type":"email", recipient: { "picture":"resources/phone/portraits/men/13.jpg"}, doctor: "Dr. Mike Davidson"},
				{created: "2017-09-07T09:08:46.000Z", desc: "Pre-surgery visit", first: "Marc", last: "Gusmano", "type":"phone", recipient: { "picture":"resources/phone/portraits/men/14.jpg"}, doctor: "Dr. Phil Merola"},
				{created: "2017-09-07T09:08:46.000Z", desc: "Yearly physical", first: "Marc", last: "Gusmano", "type":"phone", recipient: { "picture":"resources/phone/portraits/men/15.jpg"}, doctor: "Dr. Roger Jipp"},
				{created: "2017-09-07T09:08:46.000Z", desc: "Outpatient surgery", first: "Marc", last: "Gusmano", "type":"phone", recipient: { "picture":"resources/phone/portraits/men/16.jpg"}, doctor: "Dr. Andy Jones"},
			]
		}
	}
});