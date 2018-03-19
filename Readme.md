ClubManagement

ClubManagement is a PHP-backed WebApp for managing members of a club (ie a sports club)

The Client Side is based on ExtJS Javascript Framework from Sencha (see https://www.sencha.com/products/extjs/#overview), 
thats talking to the backend via ExtDirect which is implemented with PHP.

It is based on Marc Guzmanos Template:
A basic best practice template for Sencha Cmd 6.5.2
how to use: (assuming an install to ~/aaTemplate/basictemplate on your local machine)

sencha -sdk ~/aaExt/ext-6.5.2  generate app -modern -s ~/aaTemplate/basictemplate -r best ./best

other info...

~/bin/Sencha/Cmd/6.5.2.15/plugins/ext/current/templates

sencha generate view home.HomeView;sencha generate view users.UsersView;sencha generate view groups.GroupsView;sencha generate view settings.SettingsView