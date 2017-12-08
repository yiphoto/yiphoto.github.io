#!/usr/bin/perl -w

# Copyright 2001-2004 Six Apart Ltd. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-upgradecheck.cgi,v 1.2 2004/04/23 18:22:36 ezra Exp $
use strict;

local $|=1;

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

print "Content-type: text/plain\n\n";

use MT;
my $mt = new MT;

my $ok = 1;

my $any_blog = MT::Blog->load();
if (!$any_blog) {
    print "Upgrade was not successful, or you have no blogs.\n";
    $ok = 0;
}
my $any_author = MT::Author->load();
if (!$any_author) {
    print "Upgrade was not successful, or you have no authors.\n";
    $ok = 0;
}
my $any_entry = MT::Entry->load();
if (!$any_entry) {
    print "Upgrade was not successful, or you have no entries.\n";
    $ok = 0;
}
eval {
    my $new_comment = MT::Comment->new();
    $new_comment->set_values({blog_id => $any_blog->id,
			      entry_id => $any_entry->id,
			      author => "Author",
			      visible => 0,
			      text => "Comment text"}
			     );
    $new_comment->save();
};
my $any_comment = MT::Comment->load();
if (!$any_comment) {
    print "Upgrade was not successful, or you have no comments.\n";
    $ok = 0;
}
print "Upgrade seems to have been successful.\n" if $ok;
