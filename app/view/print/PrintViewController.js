Ext.define('ClubManagement.view.print.PrintViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.print-printview'

    , onPrintMenuSelect: function(t, selected)
    {
        window.open(selected.data.url, selected.data.text);
        console.log(selected.data.text);
    }
});
