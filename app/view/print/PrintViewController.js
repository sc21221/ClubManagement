Ext.define('ClubManagement.view.print.PrintViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.print-printview'

    , onPrintMenuSelect: function(t, selected)
    {
        Ext.Msg.alert("select",selected.data.text);
        console.log(selected.data.text);
    }
});
