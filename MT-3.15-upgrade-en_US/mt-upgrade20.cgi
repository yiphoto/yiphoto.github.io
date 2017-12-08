#!/usr/bin/perl -w

# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-upgrade20.cgi,v 1.2 2004/05/17 19:51:25 ezra Exp $
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

    ## First check if there are any Placements currently--if there are,
    ## don't run the upgrade script, because we don't want to screw up
    ## an already-upgraded installation.
    require MT::Placement;
    if (MT::Placement->count) {
        print <<MSG, security_notice();
SYSTEM ALREADY UPGRADED

It looks like your database is already upgraded to Movable Type 2.0.
Re-running the upgrade script will create duplicate information in
your database, so I am stopping now.

MSG
        exit;
    }

    ## Create placement entry => category mapping table.
    require MT::Entry;

    print "Filling placement table with entry-category mappings...\n";

    my $iter = MT::Entry->load_iter;
    while (my $entry = $iter->()) {
        next unless $entry->category_id;
        print "    ", $entry->id, "    ", $entry->category_id, "\n";
        my $place = MT::Placement->new;
        $place->entry_id($entry->id);
        $place->blog_id($entry->blog_id);
        $place->category_id($entry->category_id);
        $place->is_primary(1);
        $place->save
            or die $place->errstr;
    }

    print "\n";

    ## Create table mapping templates to archive types.
    print "Filling archive-template table with template mappings...\n";
    require MT::Template;
    require MT::TemplateMap;
    require MT::Blog;
    $iter = MT::Template->load_iter;
    while (my $tmpl = $iter->()) {
        my $blog = MT::Blog->load($tmpl->blog_id);
        my(@at);
        if ($tmpl->type eq 'archive') {
            @at = qw( Daily Weekly Monthly );
        } elsif ($tmpl->type eq 'category') {
            @at = ('Category');
        } elsif ($tmpl->type eq 'individual') {
            @at = ('Individual');
        } else {
            next;
        }
        for my $at (@at) {
            print "    Mapping template ID '", $tmpl->id, "' to '$at'";
            my $meth = 'archive_tmpl_' . lc($at);
            my $file_tmpl = $blog->$meth();
            my $map = MT::TemplateMap->new;
            if ($file_tmpl) {
                print " ('$file_tmpl')\n";
                $map->file_template($file_tmpl);
            } else { print "\n" }
            $map->archive_type($at);
            $map->is_preferred(1);
            $map->template_id($tmpl->id);
            $map->blog_id($tmpl->blog_id);
            $map->save
                or die "Save failed: ", $map->errstr;
        }
    }
};
if ($@) {
    print <<HTML;

An error occurred while loading data:

$@

HTML
} else {
    print <<HTML, security_notice();

Done upgrading your MT databases to 2.0! All went well.

HTML
}

print "</pre>\n";

sub security_notice {
    return <<TEXT;
VERY IMPORTANT NOTE:

Now that you have run mt-upgrade.cgi, you will never need to run it
again. You should now delete mt-upgrade.cgi from your webserver.

FAILURE TO DELETE mt-upgrade.cgi INTRODUCES A MAJOR SECURITY RISK.
TEXT
}
