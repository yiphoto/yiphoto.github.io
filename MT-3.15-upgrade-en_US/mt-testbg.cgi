#!/usr/bin/perl -w
use strict;

# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-testbg.cgi,v 1.6 2004/08/17 00:39:56 ezra Exp $
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

sub pfork {
    fork();
}

eval {
    local $SIG{__WARN__} = sub { print "**** WARNING: $_[0]\n" };

    require MT;

    my $mt = MT->new( Config => $MT_DIR . 'mt.cfg')
        or die MT->errstr;

    print "If you see only one number below, or if you see two and they match, you should add the line\n
  BackgroundTasks 0\n\nto the file mt.cfg.\n\n-------------------\n\n";

    my $pid = pfork();
    if (defined($pid) && !$pid) {
	print "[$$]\n\n";
	exit(0);
    } else {
	print "[$$]\n\n";
    }
}
