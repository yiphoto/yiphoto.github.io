#!/usr/bin/perl -w

# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-upgrade21.cgi,v 1.7 2004/05/17 19:51:25 ezra Exp $
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

eval {
    require MT;
    my $mt = MT->new( Config => $MT_DIR . 'mt.cfg', Directory => $MT_DIR )
        or die MT->errstr;

    ## For each placement in the DB, add in the blog_id column, based
    ## on the blog ID of the category associated with the placement.
    require MT::Category;

    print "Setting blog_id column for all placements in placement table...\n";

    require MT::Placement;
    my @place = MT::Placement->load;
    my %cats;
    for my $p (@place) {
        next if $p->blog_id;
        print "    ", $p->id, "\n";
        my $cat = $cats{$p->category_id};
        unless ($cat) {
print "(Loading category ", $p->category_id, ")\n";
            $cat = $cats{$p->category_id} = MT::Category->load($p->category_id);
        }
        $p->blog_id($cat->blog_id);
        $p->save
            or die $p->errstr;
    }

    print "\n";
};
if ($@) {
    print <<HTML;

An error occurred while loading data:

$@

HTML
} else {
    print <<HTML, security_notice();

Done upgrading your MT databases to 2.1! All went well.

HTML
}

print "</pre>\n";

sub security_notice {
    return <<TEXT;
VERY IMPORTANT NOTE:

Now that you have run mt-upgrade21.cgi, you will never need to run it
again. You should now delete mt-upgrade21.cgi from your webserver.

FAILURE TO DELETE mt-upgrade21.cgi INTRODUCES A MAJOR SECURITY RISK.
TEXT
}
