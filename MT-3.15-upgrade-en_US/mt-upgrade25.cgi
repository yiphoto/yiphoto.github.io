#!/usr/bin/perl -w
use strict;

# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-upgrade25.cgi,v 1.5 2004/05/17 19:51:25 ezra Exp $
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
    if (MT->version_number < 2.5) {
        print "You have not yet upgraded to the 2.5 version of MT. Please do that before you run this script. Exiting...";
        exit;
    }

    my $mt = MT->new( Config => $MT_DIR . 'mt.cfg')
        or die MT->errstr;

    if ($mt->{cfg}->ObjectDriver ne 'DBI::mysql') {
        print "You do not seem to be running the MySQL version. Exiting...";
        exit;
    }

    my $dbh = MT::Object->driver->{dbh};
    my @stmts = (
    'alter table mt_author add column author_preferred_language varchar(50)',
    'alter table mt_blog change column blog_server_offset blog_server_offset float',
    'alter table mt_blog add column blog_ping_blogs tinyint',
    'alter table mt_blog add column blog_ping_others text',
    'alter table mt_blog add column blog_autodiscover_links tinyint',
    'alter table mt_entry add column entry_keywords text',
    'alter table mt_entry add column entry_tangent_cache text',
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
