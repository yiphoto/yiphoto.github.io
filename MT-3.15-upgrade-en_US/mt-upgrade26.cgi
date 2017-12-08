#!/usr/bin/perl -w
use strict;

# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-upgrade26.cgi,v 1.6 2004/08/23 23:44:52 ezra Exp $
use strict;

my($MT_DIR);
BEGIN {
    if ($0 =~ m!(.*[/\\])!) {
        $MT_DIR = $1;
    } else {
        $MT_DIR = './';
    }
    unshift @INC, $MT_DIR . 'lib';
    unshift @INC, $MT_DIR . 'extlib';
}

local $| = 1;
print "Content-Type: text/html\n\n";
print "<pre>\n\n";

my @CLASSES = qw( MT::Author MT::Blog MT::Category MT::Comment MT::Entry
                  MT::IPBanList MT::Log MT::Notification MT::Permission
                  MT::Placement MT::Template MT::TemplateMap MT::Trackback
                  MT::TBPing );

use File::Spec;

eval {
    local $SIG{__WARN__} = sub { print "**** WARNING: $_[0]\n" };

    require MT;
    if (MT->version_number < 2.6) {
        print "You have not yet upgraded to the 2.6 version of MT. Please do that before you run this script. Exiting...";
        exit;
    }

    my $mt = MT->new( Config => $MT_DIR . 'mt.cfg')
        or die MT->errstr;

    if ($mt->{cfg}->ObjectDriver !~ /^DBI/) {
        print "You do not seem to be running the SQL database version. Exiting...";
        exit;
    }

    my $dbh = MT::Object->driver->{dbh};
    my @stmts = (
    'alter table mt_entry change column entry_convert_breaks entry_convert_breaks varchar(30)',
    'alter table mt_blog change column blog_convert_paras blog_convert_paras varchar(30)',
    'alter table mt_blog change column blog_convert_paras_comments blog_convert_paras_comments varchar(30)',
    'alter table mt_blog add column blog_sanitize_spec varchar(255)',
    'alter table mt_blog add column blog_cc_license varchar(255)',
    'alter table mt_blog add column blog_is_dynamic tinyint',
    <<CREATE
create table mt_plugindata (
    plugindata_id integer not null auto_increment primary key,
    plugindata_plugin varchar(50) not null,
    plugindata_key varchar(255) not null,
    plugindata_data mediumtext,
    index (plugindata_plugin),
    index (plugindata_key)
)
CREATE
    );
    for my $sql (@stmts) {
        print "Running '$sql'\n";
        $dbh->do($sql) or die $dbh->errstr;
    }
};
if ($@) {
    print <<HTML;

An error occurred while upgrading the schema:

$@

HTML
} else {
    print <<HTML;

Done upgrading your schema! All went well.

HTML
}

print "</pre>\n";
