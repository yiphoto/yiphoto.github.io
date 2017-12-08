# Copyright 2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: Mirror.pm,v 1.2 2004/07/20 18:16:53 ezra Exp $

package Mirror;

use strict;

use lib '../../lib';

use MT::App;
@Mirror::ISA = qw(MT::App);

sub uri {
    $_[0]->path . "plugins/mirror/" . $_[0]->script;
}

sub init {
    my $app = shift;
    $app->SUPER::init(@_) or return;

    $app->add_methods( show_config => \&show_config );
    $app->{default_mode} = 'show_config';
    $app->{template_dir} = 'cms';
    $app->{charset} = $app->{cfg}->PublishCharset;
    $app->{requires_login} = 1;
    $app->{user_class} = 'MT::Author';
    $app->{plugin_template_path} = './plugins/mirror/tmpl/';  # FIXME

    $app;
}

sub show_config {
    my $app = shift;
    $app->build_page('mirror.tmpl', {var => 'Zaphod'});
}

1;

