#!/usr/bin/perl -w

# Copyright 2001-2004 Six Apart Ltd. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-check.cgi,v 1.36 2004/05/17 19:51:25 ezra Exp $
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

print "Content-Type: text/html\n\n";
print <<HTML;

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	
	<title>Movable Type System Check [mt-check.cgi]</title>
	
	<style type=\"text/css\">
		<!--
		
			body {
				font-family : Trebuchet MS, Tahoma, Verdana, Arial, Helvetica, Sans Serif;
				font-size : smaller;
				padding-top : 0px;
				padding-left : 0px;
				margin : 0px;
				padding-bottom : 40px;
				width : 80%;
				border-right : 1px dotted #8faebe;
			}
			
			h1 {
				background : #8faebe;
				font-size: large;
				color : white;
				padding : 10px;
				margin-top : 0px;
				margin-bottom : 20px;
				text-align : center;
			}
			
			h2 {
				color: #fff;
				font-size: small;
				background : #8faebe;
				padding : 5px 10px 5px 10px;
				margin-top : 30px;
				margin-left : 40px;
				margin-right : 40px;
			}
			
			h3 {
				color: #333;
				font-size: small;
				margin-left : 40px;
				margin-bottom : 0px;
				padding-left : 20px;
			}
	
			p {
				padding-left : 20px;
				margin-left : 40px;
				margin-right : 60px;
				color : #666;
			}
			
			ul {
				padding-left : 40px;
				margin-left : 40px;
			}
			
			.info {
				margin-left : 60px;
				margin-right : 60px;
				padding : 20px;
				border : 1px solid #666;
				background : #eaf2ff;
				color : black;
			}
		
			.alert {
				padding : 15px;
				border : 1px solid #666;
				background : #ff9;
				color : black;
			}
			

			.ready {
				color: #fff;
				background-color: #9C6;
			}

			.bad {
				padding-top : 0px;
				margin-top : 4px;
				border-left : 1px solid red;
				padding-left : 10px;
				margin-left : 60px;
			}
			
			.good {
				color: #93b06b;
				padding-top : 0px;
				margin-top : 0px;
			}
		
		//-->
	</style>

</head>

<body>

<h1>Movable Type System Check [mt-check.cgi]</h1>

<p class="info">This page provides you with information on your system\'s configuration and determines whether you have all of the components you need to run Movable Type.</p>


HTML


my $is_good = 1;

my @REQ = (
    [ 'HTML::Template', 2, 1, 'HTML::Template is required for all Movable Type application functionality.' ],

    [ 'Image::Size', 0, 1, 'Image::Size is required for file uploads (to determine the size of uploaded images in many different formats).' ],

    [ 'File::Spec', 0.8, 1, 'File::Spec is required for path manipulation across operating systems.' ],

    [ 'CGI::Cookie', 0, 1, 'CGI::Cookie is required for cookie authentication.' ],
);

my @DATA = (
    [ 'DB_File', 0, 0, 'DB_File is required if you want to use the Berkeley DB/DB_File backend.' ],

    [ 'DBD::mysql', 0, 0, 'DBI and DBD::mysql are required if you want to use the MySQL database backend.' ],

    [ 'DBD::Pg', 0, 0, 'DBI and DBD::Pg are required if you want to use the PostgreSQL database backend.' ],

    [ 'DBD::SQLite', 0, 0, 'DBI and DBD::SQLite are required if you want to use the SQLite database backend.' ],
);

my @OPT = (
    [ 'HTML::Entities', 0, 0, 'HTML::Entities is needed to encode some characters, but this feature can be turned off using the NoHTMLEntities optioon in mt.cfg.' ],

    [ 'LWP::UserAgent', 0, 0, 'LWP::UserAgent is optional; It is needed if you wish to use the TrackBack system, the weblogs.com ping, or the MT Recently Updated ping.' ],

    [ 'SOAP::Lite', 0.50, 0, 'SOAP::Lite is optional; It is needed if you wish to use the MT XML-RPC server implementation.' ],

    [ 'File::Temp', 0, 0, 'File::Temp is optional; It is needed if you would like to be able to overwrite existing files when you upload.' ],

    [ 'Image::Magick', 0, 0, 'Image::Magick is optional; It is needed if you would like to be able to create thumbnails of uploaded images.' ],

    [ 'Storable', 0, 0, 'Storable is optional; it is required by certain MT plugins available from third parties.'],

    [ 'Crypt::DSA', 0, 0, 'Crypt::DSA is optional; if it is installed, comment registration sign-ins will be accelerated.'],

    [ 'MIME::Base64', 0, 0, 'MIME::Base64 is required in order to enable comment registration.'],

    [ 'XML::Atom', 0, 0, 'XML::Atom is required in order to use the Atom API.'],
);

use Cwd;
my $cwd = '';
{
    my($bad);
    local $SIG{__WARN__} = sub { $bad++ };
    eval { $cwd = Cwd::getcwd() };
    if ($bad || $@) {
        eval { $cwd = Cwd::cwd() };
        if ($@ && $@ !~ /Insecure \$ENV{PATH}/) {
            die $@;
        }
    }
}

my $ver = $^V ? join('.', unpack 'C*', $^V) : $];
print <<INFO;
<h2>System Information:</h2>
<ul>
	<li><strong>Current working directory:</strong> <code>$cwd</code></li>
	<li><strong>Operating system:</strong> $^O</li>
	<li><strong>Perl version:</strong> <code>$ver</code></li>
INFO

## Try to create a new file in the current working directory. This
## isn't a perfect test for running under cgiwrap/suexec, but it
## is a pretty good test.
my $TMP = "test$$.tmp";
local *FH;
if (open(FH, ">$TMP")) {
    print "	<li>(Probably) Running under cgiwrap or suexec</li>\n";
    unlink($TMP);
}

print "\n\n</ul>\n";

exit if $ENV{QUERY_STRING} && $ENV{QUERY_STRING} eq 'sys-check';

use Text::Wrap;
$Text::Wrap::columns = 72;

for my $list (\@REQ, \@DATA, \@OPT) {
    my $data = ($list == \@DATA);
    my $req = ($list == \@REQ);
    printf "<h2>Checking for  %s Modules:</h2>\n\t<div>\n", $req ? "Required" :
        $data ? "Data Storage" : "Optional";
    if (!$req && !$data) {
        print <<MSG;
		<p class="info">The following modules are <strong>optional</strong>; If your server does not have these modules installed, you only need to install them if you require the functionality that the module provides.</p>

MSG
    }
    if ($data) {
        print <<MSG;
		<p class="info">The following modules are used by the different data storage options in Movable Type. In order run the system, your server needs to have <strong>at least one</strong> of these modules installed.</p>

MSG
    }
    my $got_one_data = 0;
    for my $ref (@$list) {
        my($mod, $ver, $req, $desc) = @$ref;
        print "    <h3>$mod" .
            ($ver ? " (version &gt;= $ver)" : "") . "</h3>";
        eval("use $mod" . ($ver ? " $ver;" : ";"));
        if ($@) {
            $is_good = 0 if $req;
            my $msg = $ver ?
                      "<p class=\"bad\">Either your server does not have $mod installed, " .
                      "the version that is installed is too old, or $mod " . 
		      "requires another module that is not installed. ":
                      "<p class=\"bad\">Your server does not have $mod " . 
		      "installed, or $mod requires another module that " . 
		      "is not installed. ";
            $msg   .= $desc .
                      " Please consult the installation instructions for " .
                      "help in installing $mod. </p>\n\n";
            print wrap("        ", "        ", $msg), "\n\n";
        } else {
            print "<p class=\"good\">Your server has $mod installed (version @{[ $mod->VERSION ]}).</p>\n\n";
            $got_one_data = 1 if $data;
        }
    }
    $is_good &= $got_one_data if $data;
    print "\n\t</div>\n\n";
}

if ($is_good) {
    print <<HTML;
    
	<h2 class="ready">Movable Type System Check Successful</h2>

	<p><strong>You're ready to go!</strong> Your server has all of the required modules installed; you do not need to perform any additional module installations. Continue with the installation instructions. <!-- If this is your first time configuring Movable Type on this system, you can now run <a href="./mt-load.cgi">mt-load.cgi</a>, and you <strong>must</strong> delete mt-load.cgi after it has successfully been run. --> </p>

</div>


HTML
}

print "</body>\n\n</html>\n";
