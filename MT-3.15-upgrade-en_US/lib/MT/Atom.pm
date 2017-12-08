# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.
#
# $Id: Atom.pm,v 1.6 2004/09/09 00:20:17 ezra Exp $

package MT::Atom;
use strict;

package MT::Atom::Entry;
use base qw( XML::Atom::Entry );

sub new_with_entry {
    my $class = shift;
    my($entry) = @_;
    my $atom = $class->new;
    $atom->title($entry->title);
    $atom->summary($entry->excerpt);
    $atom->content($entry->text);
    my $mt_author = MT::Author->load($entry->author_id);
    my $atom_author = new XML::Atom::Person();
    $atom_author->set('name', $mt_author->name());
    $atom_author->set('url', $mt_author->url());
    $atom_author->set('email', $mt_author->email());
    $atom->author($atom_author);
    my @co_list = unpack 'A4A2A2A2A2A2', $entry->created_on;
    my $co = sprintf "%04d-%02d-%02dT%02d:%02d:%02d", @co_list;
    my $epoch = Time::Local::timegm($co_list[5], $co_list[4], $co_list[3],
                                    $co_list[2], $co_list[1]-1, $co_list[0]);
    my $blog = MT::Blog->load($entry->blog_id);
    my $so = $blog->server_offset;
    $so += 1 if (localtime $epoch)[8];
    $so = sprintf("%s%02d%02d", $so < 0 ? '-' : '+', 
                  abs(int $so), abs($so - int $so)*60);
    $co .= $so;
    $atom->issued($co);
    $atom->add_link({ rel => 'alternate', type => 'text/html',
                      href => $entry->permalink });
    my ($host) = $blog->site_url =~ m!^https?://([^/:]+)(:\d+)?/!;
    $atom->id('tag:' . $host . ':post:' . $entry->id);
    $atom;
}

1;
