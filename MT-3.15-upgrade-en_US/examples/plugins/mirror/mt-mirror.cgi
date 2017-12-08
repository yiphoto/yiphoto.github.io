#!/usr/bin/perl

my $mt_base;
my $path = $ENV{SCRIPT_FILENAME};
while ($path !~ m|^/?$|) {
    if (-r "$path/lib/MT.pm") {
	$buff .= " sticking $path on \@INC <br />";
	$mt_base = $path;
	last;
    }
    $path =~ s|/[^/]*/?$||;
}

unshift @INC, "$mt_base/lib";
require MT;

use lib 'lib';
use Mirror;

# Need to be able to override app config vars in constructor

eval {
    $app = Mirror->new( AltTemplatePath => "./tmpl",
			# TBD: MT should get these two automatically:
			Config => "$mt_base/mt.cfg",
			TemplatePath => "$mt_base/tmpl" )
	|| die "the app couldn't be initialized because " . Mirror->errstr();
    $app->run();
}; if ($@) {
    print "An internal error occurred: $@";
}
