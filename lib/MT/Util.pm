# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: Util.pm,v 1.133.2.1.4.1 2005/01/25 02:28:19 ezra Exp $

package MT::Util;
use strict;

use MT::ConfigMgr;
use MT::Request;
use Exporter;
@MT::Util::ISA = qw( Exporter );
use vars qw( @EXPORT_OK );
@EXPORT_OK = qw( start_end_day start_end_week start_end_month
                 start_end_period week2ymd
                 html_text_transform encode_html decode_html munge_comment
                 iso2ts offset_time offset_time_list first_n_words
                 archive_file_for format_ts dirify remove_html
                 days_in wday_from_ts encode_js get_entry spam_protect
                 is_valid_email encode_php encode_url decode_url encode_xml
                 decode_xml is_valid_url discover_tb convert_high_ascii 
		 mark_odd_rows dsa_verify perl_sha1_digest
		 perl_sha1_digest_hex dec2bin bin2dec 
                 start_background_task launch_background_tasks);

{
    my @In_Year = (
        [ 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365 ],
        [ 0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366 ],
    );

    sub wday_from_ts {
        my($y, $m, $d) = @_;
        my $leap = $y % 4 == 0 && ($y % 100 != 0 || $y % 400 == 0) ? 1 : 0;
        $y--;

        ## Copied from Date::Calc.
        my $days = $y * 365;
        $days += $y >>= 2;
        $days -= int($y /= 25);
        $days += $y >> 2;
        $days += $In_Year[$leap][$m-1] + $d;
        $days % 7;
    }

    sub yday_from_ts {
        my($y, $m, $d) = @_;
        my $leap = $y % 4 == 0 && ($y % 100 != 0 || $y % 400 == 0) ? 1 : 0;
        $In_Year[$leap][$m-1] + $d;
    }
}

sub iso2ts {
    my($blog, $iso) = @_;
    return undef
        unless $iso =~ /^(\d{4})(?:-?(\d{2})(?:-?(\d\d?)(?:T(\d{2}):(\d{2}):(\d{2})(?:\.\d+)?(Z|[+-]\d{2}:\d{2})?)?)?)?/;
    my($y, $mo, $d, $h, $m, $s, $offset) =
        ($1, $2 || 1, $3 || 1, $4 || 0, $5 || 0, $6 || 0, $7);
    if ($offset && !MT::ConfigMgr->instance->IgnoreISOTimezones) {
        $mo--;
        $y -= 1900;
        my $time = timegm($s, $m, $h, $d, $mo, $y);
        ## If it's not already in UTC, first convert to UTC.
        if ($offset ne 'Z') {
            my($sign, $h, $m) = $offset =~ /([+-])(\d{2}):(\d{2})/;
            $offset = $h * 3600 + $m * 60;
            $offset *= -1 if $sign eq '-';
            $time -= $offset;
        }
        ## Now apply the offset for this weblog.
        ($s, $m, $h, $d, $mo, $y) = offset_time_list($time, $blog);
        $mo++;
        $y += 1900;
    }
    sprintf "%04d%02d%02d%02d%02d%02d", $y, $mo, $d, $h, $m, $s;
}

use Time::Local qw( timegm );
sub ts2iso {
    my ($blog, $ts) = @_;
    my ($yr, $mo, $dy, $hr, $mn, $sc) = unpack('A4A2A2A2A2A2A2', $ts);
    $ts = timegm($sc, $mn, $hr, $dy, $mo-1, $yr);
    ($sc, $mn, $hr, $dy, $mo, $yr) = offset_time_list($ts, $blog, '-');
    $yr += 1900;
    $mo += 1;
    sprintf("%04d-%02d-%02dT%02d:%02d:%02dZ", $yr, $mo, $dy, $hr, $mn, $sc);
}

use vars qw( %Languages );
sub format_ts {
    my($format, $ts, $blog, $lang) = @_;
    my %f;
    unless ($lang) {
        $lang = $blog && $blog->language ? $blog->language : 'en';
    }
    unless (defined $format) {
        $format = $Languages{$lang}[3] || "%B %e, %Y %I:%M %p";
    }
    my $cache = MT::Request->instance->cache('formats');
    unless ($cache) {
        MT::Request->instance->cache('formats', $cache = {});
    }
    if (my $f_ref = $cache->{$ts . $lang}) {
        %f = %$f_ref;
    } else {
        my $L = $Languages{$lang};
        my @ts = @f{qw( Y m d H M S )} = unpack 'A4A2A2A2A2A2', $ts;
        $f{w} = wday_from_ts(@ts[0..2]);
        $f{j} = yday_from_ts(@ts[0..2]);
        $f{'y'} = substr $f{Y}, 2;
        $f{b} = substr $L->[1][$f{'m'}-1] || '', 0, 3;
        $f{B} = $L->[1][$f{'m'}-1];
        $f{a} = substr $L->[0][$f{w}] || '', 0, 3;
        $f{A} = $L->[0][$f{w}];
        ($f{e} = $f{d}) =~ s!^0! !;
        $f{I} = $f{H};
        $f{I} = $f{H};
        if ($f{I} > 12) {
            $f{I} -= 12;
            $f{p} = $L->[2][1];
        } elsif ($f{I} == 0) {
            $f{I} = 12;
            $f{p} = $L->[2][0];
        } elsif ($f{I} == 12) {
            $f{p} = $L->[2][1];
        } else {
            $f{p} = $L->[2][0];
        }
        $f{I} = sprintf "%02d", $f{I};
        ($f{k} = $f{H}) =~ s!^0! !;
        ($f{l} = $f{I}) =~ s!^0! !;
        $f{j} = sprintf "%03d", $f{j};
        $f{Z} = '';
        $cache->{$ts . $lang} = \%f;
    }
    my $date_format = $Languages{$lang}->[4] || "%B %d, %Y";
    my $time_format = $Languages{$lang}->[5] || "%I:%M %p";
    $format =~ s!%x!$date_format!g;
    $format =~ s!%X!$time_format!g;
    ## This is a dreadful hack. I can't think of a good format specifier
    ## for "%B %Y" (which is used for monthly archives, for example) so
    ## I'll just hardcode this, for Japanese dates.
    if ($lang eq 'jp') {
        $format =~ s!%B %Y!$Languages{$lang}->[6]!g;
    }
    $format =~ s!%(\w)!$f{$1}!g if defined $format;
    $format;
}

{
    my @Days_In = ( -1, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
    sub days_in {
        my($m, $y) = @_;
        return $Days_In[$m] unless $m == 2;
        return $y % 4 == 0 && ($y % 100 != 0 || $y % 400 == 0) ?
            29 : 28;
    }
}

sub start_end_period {
    my $at = shift;
    if ($at eq 'Individual') {
        return $_[0];
    } elsif ($at eq 'Daily') {
        return start_end_day(@_);
    } elsif ($at eq 'Weekly') {
        return start_end_week(@_);
    } elsif ($at eq 'Monthly') {
        return start_end_month(@_);
    } 
}

sub start_end_day {
    my $day = substr $_[0], 0, 8;
    return $day . '000000' unless wantarray;
    ($day . "000000", $day . "235959");
}

sub start_end_week {
    my($ts) = @_;
    my($y, $mo, $d, $h, $m, $s) = unpack 'A4A2A2A2A2A2', $ts;
    my $wday = wday_from_ts($y, $mo, $d);
    my($sd, $sm, $sy) = ($d - $wday, $mo, $y);
    if ($sd < 1) {
        $sm--;
        $sm = 12, $sy-- if $sm < 1;
        $sd += days_in($sm, $sy);
    }
    my $start = sprintf "%04d%02d%02d%s", $sy, $sm, $sd, "000000";
    return $start unless wantarray;
    my($ed, $em, $ey) = ($d + 6 - $wday, $mo, $y);
    if ($ed > days_in($em, $ey)) {
        $ed -= days_in($em, $ey);
        $em++;
        $em = 1, $ey++ if $em > 12;
    }
    my $end = sprintf "%04d%02d%02d%s", $ey, $em, $ed, "235959";
    ($start, $end);
}

sub is_leap_year {
     ($_[0] % 4 && !$_[0] % 100) || $_[0] % 400;
}

my @prev_month_doy = (0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
my @prev_month_doly = (0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335);
sub week2ymd {
    my($y, $week) = @_;
    require DateTime;
    my $jan_one_dow_m1 = (DateTime->_ymd2rd($y, 1, 1) + 6) % 7;
    $week-- if $jan_one_dow_m1 < 4;
    my $day_of_year = $week * 7 - $jan_one_dow_m1 + 1;
    if ($day_of_year < 1) {
        $y--;
        $day_of_year = (is_leap_year($y) ? 366 : 365) + $day_of_year;
    }
    my $ref = is_leap_year($y) ?
        \@prev_month_doly : \@prev_month_doy;
    my $m;
    my $i = @$ref;
    for my $days (reverse @$ref) {
        if ($day_of_year > $days) {
            $m = $i;
            last;
        }
        $i--;
    }
    ($y, $m, $day_of_year - $ref->[$m-1]);
}

sub start_end_month {
    my($ts) = @_;
    my($y, $mo) = unpack 'A4A2', $ts;
    my $start = sprintf "%04d%02d01000000", $y, $mo;
    return $start unless wantarray;
    my $end = sprintf "%04d%02d%02d235959", $y, $mo, days_in($mo, $y);
    ($start, $end);
}

sub offset_time_list { gmtime offset_time(@_) }

sub offset_time {
    my($ts, $blog, $dir) = @_;
    my $offset;
    if (defined $blog) {
        if (!ref($blog)) {
            require MT::Blog;
            $blog = MT::Blog->load($blog);
        }
        $offset = $blog && $blog->server_offset ? $blog->server_offset : 0;
    } else {
        $offset = MT::ConfigMgr->instance->TimeOffset;
    }
    $offset += 1 if (localtime $ts)[8];
    $offset *= -1 if $dir && $dir eq '-';
    $ts += $offset * 3600;
    $ts;
}

sub html_text_transform {
    my $str = shift;
    $str ||= '';
    my @paras = split /\r?\n\r?\n/, $str;
    for my $p (@paras) {
        if ($p !~ m@^</?(?:h1|h2|h3|h4|h5|h6|table|ol|dl|ul|menu|dir|p|pre|center|form|fieldset|select|blockquote|address|div|hr)@) {
            $p =~ s!\r?\n!<br />\n!g;
            $p = "<p>$p</p>";
        }
    }
    join "\n\n", @paras;
}

{
    my %Map = (':' => '&#58;', '@' => '&#64;', '.' => '&#46;');
    sub spam_protect {
        my($str) = @_;
        my $look = join '', keys %Map;
        $str =~ s!([$look])!$Map{$1}!g;
        $str;
    }
}

sub encode_js {
    my($str) = @_;
    return '' unless defined $str;
    $str =~ s!(['"])!\\$1!g;
    $str =~ s!\n!\\n!g;
    $str =~ s!\f!\\f!g;
    $str =~ s!\r!\\r!g;
    $str =~ s!\t!\\t!g;
    $str;
}

sub encode_php {
    my($str, $meth) = @_;
    return '' unless defined $str;
    if ($meth eq 'qq') {
        $str = encode_phphere($str);
        $str =~ s!"!\\"!g;    ## Replace " with \"
    } elsif (substr($meth, 0, 4) eq 'here') {
        $str = encode_phphere($str);
    } else {
        $str =~ s!\\!\\\\!g;  ## Replace \ with \\
        $str =~ s!'!\\'!g;    ## Replace ' with \'
    }
    $str;
}

sub encode_phphere {
    my($str) = @_;
    $str =~ s!\\!\\\\!g;      ## Replace \ with \\
    $str =~ s!\$!\\\$!g;      ## Replace $ with \$
    $str =~ s!\n!\\n!g;       ## Replace character \n with string \n
    $str =~ s!\r!\\r!g;       ## Replace character \r with string \r
    $str =~ s!\t!\\t!g;       ## Replace character \t with string \t
    $str;
}

sub encode_url {
    my($str) = @_;
    $str =~ s!([^a-zA-Z0-9_.-])!uc sprintf "%%%02x", ord($1)!eg;
    $str;
}

sub decode_url {
    my($str) = @_;
    $str =~ s!%([0-9a-fA-F][0-9a-fA-F])!pack("H*",$1)!eg;
    $str;
}

{
    my $Have_Entities = eval 'use HTML::Entities; 1' ? 1 : 0;

    sub encode_html {
        my($html, $can_double_encode) = @_;
        return '' unless defined $html;
        $html =~ tr!\cM!!d;
        if ($Have_Entities && !MT::ConfigMgr->instance->NoHTMLEntities) {
            $html = HTML::Entities::encode_entities($html);
        } else {
            if ($can_double_encode) {
                $html =~ s!&!&amp;!g;
            } else {
                ## Encode any & not followed by something that looks like
                ## an entity, numeric or otherwise.
                $html =~ s/&(?!#?[xX]?(?:[0-9a-fA-F]+|\w{1,8});)/&amp;/g;
	    }
	    $html =~ s!"!&quot;!g;    #"
            $html =~ s!<!&lt;!g;
            $html =~ s!>!&gt;!g;
	  }
        $html;
    }

    sub decode_html {
        my($html) = @_;
        return '' unless defined $html;
        $html =~ tr!\cM!!d;
        if ($Have_Entities && !MT::ConfigMgr->instance->NoHTMLEntities) {
            $html = HTML::Entities::decode_entities($html);
        } else {
            $html =~ s!&quot;!"!g;  #"
            $html =~ s!&lt;!<!g;
            $html =~ s!&gt;!>!g;
            $html =~ s!&amp;!&!g;
        }
        $html;
    }
}

{
    my %Map = ('&' => '&amp;', '"' => '&quot;', '<' => '&lt;', '>' => '&gt;',
               '\'' => '&apos;');
    my %Map_Decode = reverse %Map;
    my $RE = join '|', keys %Map;
    my $RE_D = join '|', keys %Map_Decode;

    sub encode_xml {
        my($str, $nocdata) = @_;
	$nocdata ||= MT::ConfigMgr->instance->NoCDATA;
        if (!$nocdata && $str =~ m/
            <[^>]+>  ## HTML markup
            |        ## or
            &(?:(?!(\#([0-9]+)|\#x([0-9a-fA-F]+))).*?);
                     ## something that looks like an HTML entity.
        /x) {
            ## If ]]> exists in the string, encode the > to &gt;.
            $str =~ s/]]>/]]&gt;/g;
            $str = '<![CDATA[' . $str . ']]>';
        } else {
            $str =~ s!($RE)!$Map{$1}!g;
        }
        $str;
    }
    sub decode_xml {
        my($str) = @_;
        if ($str =~ s/<!\[CDATA\[(.*?)]]>/$1/g) {
            ## Decode encoded ]]&gt;
            $str =~ s/]]&(gt|#62);/]]>/g;
        } else {
            $str =~ s!($RE_D)!$Map_Decode{$1}!g;
        }
        $str;
    }
}

sub remove_html {
    my($text) = @_;
    return $text if !defined $text;  # suppress warnings
    $text =~ s!<[^>]+>!!gs;
    $text =~ s!<!&lt;!gs;
    $text;
}

sub dirify {
    my $s = $_[0];
    $s = convert_high_ascii($s);  ## convert high-ASCII chars to 7bit.
    $s = lc $s;                   ## lower-case.
    $s = remove_html($s);         ## remove HTML tags.
    $s =~ s!&[^;\s]+;!!g;         ## remove HTML entities.
    $s =~ s![^\w\s]!!g;           ## remove non-word/space chars.
    $s =~ tr! !_!s;               ## change space chars to underscores.
    $s;    
}

my %HighASCII = (
    "\xc0" => 'A',    # A`
    "\xe0" => 'a',    # a`
    "\xc1" => 'A',    # A'
    "\xe1" => 'a',    # a'
    "\xc2" => 'A',    # A^
    "\xe2" => 'a',    # a^
    "\xc4" => 'Ae',   # A:
    "\xe4" => 'ae',   # a:
    "\xc3" => 'A',    # A~
    "\xe3" => 'a',    # a~
    "\xc8" => 'E',    # E`
    "\xe8" => 'e',    # e`
    "\xc9" => 'E',    # E'
    "\xe9" => 'e',    # e'
    "\xca" => 'E',    # E^
    "\xea" => 'e',    # e^
    "\xcb" => 'Ee',   # E:
    "\xeb" => 'ee',   # e:
    "\xcc" => 'I',    # I`
    "\xec" => 'i',    # i`
    "\xcd" => 'I',    # I'
    "\xed" => 'i',    # i'
    "\xce" => 'I',    # I^
    "\xee" => 'i',    # i^
    "\xcf" => 'Ie',   # I:
    "\xef" => 'ie',   # i:
    "\xd2" => 'O',    # O`
    "\xf2" => 'o',    # o`
    "\xd3" => 'O',    # O'
    "\xf3" => 'o',    # o'
    "\xd4" => 'O',    # O^
    "\xf4" => 'o',    # o^
    "\xd6" => 'Oe',   # O:
    "\xf6" => 'oe',   # o:
    "\xd5" => 'O',    # O~
    "\xf5" => 'o',    # o~
    "\xd8" => 'Oe',   # O/
    "\xf8" => 'oe',   # o/
    "\xd9" => 'U',    # U`
    "\xf9" => 'u',    # u`
    "\xda" => 'U',    # U'
    "\xfa" => 'u',    # u'
    "\xdb" => 'U',    # U^
    "\xfb" => 'u',    # u^
    "\xdc" => 'Ue',   # U:
    "\xfc" => 'ue',   # u:
    "\xc7" => 'C',    # ,C
    "\xe7" => 'c',    # ,c
    "\xd1" => 'N',    # N~
    "\xf1" => 'n',    # n~
    "\xdf" => 'ss',
);
my $HighASCIIRE = join '|', keys %HighASCII;
sub convert_high_ascii {
    my($s) = @_;
    $s =~ s/($HighASCIIRE)/$HighASCII{$1}/g;
    $s;
}

sub first_n_words {
    my($text, $n) = @_;
    $text = remove_html($text);
    my @words = split /\s+/, $text;
    my $max = @words > $n ? $n : @words;
    return join ' ', @words[0..$max-1];
}

sub munge_comment {
    my($text, $blog) = @_;
    unless ($blog->allow_comment_html) {
        $text = remove_html($text);
        if ($blog->autolink_urls) {
            $text =~ s!(http://\S+)!<a href="$1">$1</a>!g;
        }
    }
    $text;
}

my %DynamicURIs = (
    'Individual' => 'entry/<$MTEntryID$>',
    'Weekly'     => 'archives/week/<$MTArchiveDate format="%Y/%m/%d"$>',
    'Monthly'    => 'archives/<$MTArchiveDate format="%Y/%m"$>',
    'Daily'      => 'archives/<$MTArchiveDate format="%Y/%m/%d"$>',
    'Category'   => 'section/<$MTCategoryID$>',
);


# basename must be unique across the entire blog it starts as dirified
# title and, if that already exists, an appended ctr is incremented
# until we get a non-existent basename
sub make_unique_basename {
    my ($entry) = @_;
    my $blog = $entry->blog;
    my $title = $entry->title;
    unless ($title) {
        if (my $text = $entry->text) {
            $title = MT::Util::first_n_words($text, 5);
        }
        $title = 'Post' unless $title;
    }
    my $base = substr(MT::Util::dirify($title), 0, 15);
    $base =~ s/_+$//;
    $base = 'post' if $base eq '';
    my $i = 1;
    my $base_copy = $base;

    while (MT::Entry->count({ blog_id => $blog->id,
                              basename => $base })) {
        $base = $base_copy . '_' . $i++;
    }
    $base;
}

##
## archive_file_for takes an entry to determine the timestamps,
## but if the entry is not available it uses the time_start
## and time_end values
##
sub archive_file_for {
    my($entry, $blog, $at, $cat, $map, $timestamp) = @_;
    return if $at eq 'None';
    my $file;
    if ($blog->is_dynamic) {
        require MT::TemplateMap;
        $map = MT::TemplateMap->new;
        $map->file_template($DynamicURIs{$at});
    }
    unless ($map) {
        my $cache = MT::Request->instance->cache('maps');
        unless ($cache) {
            MT::Request->instance->cache('maps', $cache = {});
        }
        unless ($map = $cache->{$blog->id . $at}) {
            require MT::TemplateMap;
            $map = MT::TemplateMap->load({ blog_id => $blog->id,
                                           archive_type => $at,
                                           is_preferred => 1 });
            $cache->{$blog->id . $at} = $map if $map;
        }
    }
    my $file_tmpl = $map ? $map->file_template : '';
    my($ctx);
    if ($file_tmpl) {
        require MT::Template::Context;
        $ctx = MT::Template::Context->new;
        $ctx->stash('blog', $blog);
    }
    local $ctx->{__stash}{category};
    $timestamp = $entry->created_on() if $entry;
    if ($at eq 'Individual') {
	Carp::croak "archive_file_for Individual archive needs an entry" 
	    unless $entry;
        if ($file_tmpl) {
            $ctx->stash('entry', $entry);
            $ctx->{current_timestamp} = $entry->created_on;
        } else {
	    if ($blog->old_style_archive_links) {
		$file = sprintf("%06d", $entry->id);
            } else {
		my $basename = $entry->basename();
		$basename ||= dirify($entry->title());
		$file = sprintf("%04d/%02d/%s", 
				unpack('A4A2', $entry->created_on),
				$basename);
	    }
        }
    } elsif ($at eq 'Daily') {
	if ($file_tmpl) {
	    ($ctx->{current_timestamp}, $ctx->{current_timestamp_end}) =
		start_end_day($timestamp);
        } else {
            my $start = start_end_day($timestamp);
            my($year, $mon, $mday) = unpack 'A4A2A2', $start;
	    if ($blog->old_style_archive_links) {
		$file = sprintf("%04d_%02d_%02d", $year, $mon, $mday);
	    } else {
		$file = sprintf("%04d/%02d/%02d/index", $year, $mon, $mday);
	    }
        }
    } elsif ($at eq 'Weekly') {
        if ($file_tmpl) {
            ($ctx->{current_timestamp}, $ctx->{current_timestamp_end}) =
                start_end_week($timestamp);
        } else {
            my $start = start_end_week($timestamp);
            my($year, $mon, $mday) = unpack 'A4A2A2', $start;
	    if ($blog->old_style_archive_links) {
		$file = sprintf("week_%04d_%02d_%02d", $year, $mon, $mday);
	    } else {
		$file = sprintf("%04d/%02d/%02d-week/index", $year, $mon, $mday);
	    }
        }
    } elsif ($at eq 'Monthly') {
        if ($file_tmpl) {
            ($ctx->{current_timestamp}, $ctx->{current_timestamp_end}) =
                start_end_month($timestamp);
        } else {
            my $start = start_end_month($timestamp);
            my($year, $mon) = unpack 'A4A2', $start;
	    if ($blog->old_style_archive_links) {
		$file = sprintf("%04d_%02d", $year, $mon);
	    } else {
		$file = sprintf("%04d/%02d/index", $year, $mon);
	    }
        }
    } elsif ($at eq 'Category') {
        my $this_cat = $cat ? $cat : $entry->category;
        if ($file_tmpl) {
            $ctx->stash('archive_category', $this_cat);
	    $ctx->{inside_mt_categories} = 1;
            $ctx->{__stash}{category} = $this_cat;
        } else {
            if (!$this_cat) {
		return "";
	    }
            my $label = '';
	    $label = dirify($this_cat->label);
	    if ($label !~ /\w/) {
		$label = $this_cat ? "cat" .  $this_cat->id : "";
	    }
	    if ($blog->old_style_archive_links) {
		$file = sprintf("cat_%s", $label);
	    } else {
		$file = sprintf("%s/index", $this_cat->category_path);
	    }

        }
    } else {
        return $entry->error(MT->translate(
            "Invalid Archive Type setting '[_1]'", $at ));
    }
    if ($file_tmpl) {
        require MT::Builder;
        my $build = MT::Builder->new;
        my $tokens = $build->compile($ctx, $file_tmpl) 
	    or return $blog->error($build->errstr());
        defined($file = $build->build($ctx, $tokens)) 
	    or return $blog->error($build->errstr());
    } else {
        my $ext = $blog->file_extension || 'html';
        $file .= '.' . $ext;
    }
    $file;
}

{
    my %Helpers = ( Monthly => \&start_end_month,
                    Weekly => \&start_end_week,
                    Daily => \&start_end_day,
                  );
    sub get_entry {
        my($ts, $blog_id, $at, $order) = @_;
        my($start, $end) = $Helpers{$at}->($ts);
        if ($order eq 'previous') {
            $order = 'descend';
            $ts = $start;
        } else {
            $order = 'ascend';
            $ts = $end;
        }
        my $entry = MT::Entry->load(
            { blog_id => $blog_id,
              status => MT::Entry::RELEASE() },
            { limit => 1,
              'sort' => 'created_on',
              direction => $order,
              start_val => $ts });
        $entry;
    }
}

sub is_valid_email {
    my($addr) = @_;
    return 0 if $addr =~ /[\n\r]/;
    if($addr =~ /\s*([^\" \t\n\r]+@[^ <>\t\n\r]+\.[^ <>\t\n\r][^ <>\t\n\r]+)\s*/) {
        return $1;
    } else {
        return 0;
    }
}


sub is_valid_url {
    my($url, $stringent) = @_;

    $url ||= "";

    # strip spaces
    $url =~ s/^\s*//;
    $url =~ s/\s*$//;

    return '' if ($url =~ /[ \"]/);

    # help fat-finger typists.
    $url =~ s,http;//,http://,;
    $url =~ s,http//,http://,;

    $url = "http://$url" unless ($url =~ m,http://,);

    my ($scheme, $host, $path, $query, $fragment) =
        $url =~ m,(?:([^:/?#]+):)?(?://([^/?#]*))?([^?#]*)(?:\?([^#]*))?(?:#(.*))?,;
    if ($scheme && $host) {
        # Note: no stringent checks; localhost is a legit hostname, for example.
        return $url;
    } else {
        return '';
    }
}

sub discover_tb {
    my($url, $find_all, $contents) = @_;
    my $c;
    if ($contents) {
        $c = $$contents;
    } else {
        my $ua = MT->new_ua;
        ## Wrap this in an eval in case some versions don't support it.
        eval { $ua->parse_head(0) };
        my $req = HTTP::Request->new(GET => $url);
        my $res = $ua->request($req);
        return unless $res->is_success;
        $c = $res->content;
    }
    (my $url_no_anchor = $url) =~ s/#.*$//;
    my(@items);
    while ($c =~ m!(<rdf:RDF.*?</rdf:RDF>)!sg) {
        my $rdf = $1;
        my($perm_url) = $rdf =~ m!dc:identifier="([^"]+)"!;   #"
        next unless $find_all ||
            $perm_url eq $url || $perm_url eq $url_no_anchor;
        (my $inner = $rdf) =~ s!^.*?<rdf:Description!!s;
        my $item = { permalink => $perm_url };
        while ($inner =~ /([\w:]+)="([^"]*)"/gs) {            #"
            $item->{$1} = $2;
        }
        $item->{ping_url} = $item->{'trackback:ping'};
        next unless $item->{ping_url};
        $item->{title} = decode_xml($item->{'dc:title'});
        if (!$item->{title} && $rdf =~ m!dc:description="([^"]+)"!) { #"
            $item->{title} = MT::Util::first_n_words($1, 5) . '...';
        }
        push @items, $item;
        last unless $find_all;
    }
    return unless @items;
    $find_all ? \@items : $items[0];
}

{
    my %Data = (
        'by' => {
              name => 'Attribution',
              requires => [ qw( Attribution Notice ) ],
              permits => [ qw( Reproduction Distribution DerivativeWorks ) ],
         },
        'by-nd' => {
              name => 'Attribution-NoDerivs',
              requires => [ qw( Attribution Notice ) ],
              permits => [ qw( Reproduction Distribution ) ],
         },
        'by-nd-nc' => {
              name => 'Attribution-NoDerivs-NonCommercial',
              requires => [ qw( Attribution Notice ) ],
              permits => [ qw( Reproduction Distribution ) ],
              prohibits => [ qw( CommercialUse) ],
         },
        'by-nc' => {
              name => 'Attribution-NonCommercial',
              requires => [ qw( Attribution Notice ) ],
              permits => [ qw( Reproduction Distribution DerivativeWorks ) ],
              prohibits => [ qw( CommercialUse ) ],
         },
        'by-nc-sa' => {
              name => 'Attribution-NonCommercial-ShareAlike',
              requires => [ qw( Attribution Notice ShareAlike ) ],
              permits => [ qw( Reproduction Distribution DerivativeWorks ) ],
              prohibits => [ qw( CommercialUse ) ],
         },
        'by-sa' => {
              name => 'Attribution-ShareAlike',
              requires => [ qw( Attribution Notice ShareAlike ) ],
              permits => [ qw( Reproduction Distribution DerivativeWorks ) ],
         },
        'nd' => {
              name => 'NonDerivative',
              requires => [ qw( Notice ) ],
              permits => [ qw( Reproduction Distribution ) ],
         },
        'nd-nc' => {
              name => 'NonDerivative-NonCommercial',
              requires => [ qw( Notice ) ],
              permits => [ qw( Reproduction Distribution ) ],
              prohibits => [ qw( CommercialUse ) ],
         },
        'nc' => {
              name => 'NonCommercial',
              requires => [ qw( Notice ) ],
              permits => [ qw( Reproduction Distribution DerivativeWorks ) ],
              prohibits => [ qw( CommercialUse ) ],
         },
        'nc-sa' => {
              name => 'NonCommercial-ShareAlike',
              requires => [ qw( Notice ShareAlike ) ],
              permits => [ qw( Reproduction Distribution DerivativeWorks ) ],
              prohibits => [ qw( CommercialUse ) ],
         },
        'sa' => {
              name => 'ShareAlike',
              requires => [ qw( Notice ShareAlike ) ],
              permits => [ qw( Reproduction Distribution DerivativeWorks ) ],
         },
        'pd' => {
              name => 'PublicDomain',
              permits => [ qw( Reproduction Distribution DerivativeWorks ) ],
         },
    );
    sub cc_url {
        my($code) = @_;
        $code eq 'pd' ?
            "http://web.resource.org/cc/PublicDomain" :
            "http://creativecommons.org/licenses/$code/1.0/";
    }
    sub cc_rdf {
        my($code) = @_;
        my $url = cc_url($code);
        my $rdf = <<RDF;
<License rdf:about="$url">
RDF
        for my $type (qw( requires permits prohibits )) {
            for my $item (@{ $Data{$code}{$type} }) {
                $rdf .= <<RDF;
<$type rdf:resource="http://web.resource.org/cc/$item" />
RDF
            }
        }
        $rdf . "</License>\n";
    }
    sub cc_name {
        $Data{$_[0]}{name};
    }
}

sub mark_odd_rows {
    my($list) = @_;
    my $i = 1;
    for my $row (@$list) {
        $row->{is_odd} = $i++ % 2 == 1;
    }
}

%Languages = (
    'en' => [
            [ qw( Sunday Monday Tuesday Wednesday Thursday Friday Saturday ) ],
            [ qw( January February March April May June
                  July August September October November December ) ],
            [ qw( AM PM ) ],
          ],

    'en_us' => [
            [ qw( Sunday Monday Tuesday Wednesday Thursday Friday Saturday ) ],
            [ qw( January February March April May June
                  July August September October November December ) ],
            [ qw( AM PM ) ],
          ],

    'fr' => [
            [ qw( dimanche lundi mardi mercredi jeudi vendredi samedi ) ],
            [ ('janvier', "f&#xe9;vrier", 'mars', 'avril', 'mai', 'juin',
               'juillet', "ao&#xfb;t", 'septembre', 'octobre', 'novembre',
               "d&#xe9;cembre") ],
            [ qw( AM PM ) ],
          ],

    'es' => [
            [ ('Domingo', 'Lunes', 'Martes', "Mi&#xe9;rcoles", 'Jueves',
               'Viernes', "S&#xe1;bado") ],
            [ qw( Enero Febrero Marzo Abril Mayo Junio Julio Agosto
                  Septiembre Octubre Noviembre Diciembre ) ],
            [ qw( AM PM ) ],
          ],

    'pt' => [
            [ ('domingo', 'segunda-feira', "ter&#xe7;a-feira", 'quarta-feira',
               'quinta-feira', 'sexta-feira', "s&#xe1;bado") ],
            [ ('janeiro', 'fevereiro', "mar&#xe7;o", 'abril', 'maio', 'junho',
               'julho', 'agosto', 'setembro', 'outubro', 'novembro',
               'dezembro' ) ],
            [ qw( AM PM ) ],
          ],

    'nl' => [
            [ qw( zondag maandag dinsdag woensdag donderdag vrijdag
                  zaterdag ) ],
            [ qw( januari februari maart april mei juni juli augustus
                  september oktober november december ) ],
            [ qw( am pm ) ],
	     "%d %B %Y %H:%M",
	     "%d %B %Y"
          ],

    'dk' => [
            [ ("s&#xf8;ndag", 'mandag', 'tirsdag', 'onsdag', 'torsdag',
               'fredag', "l&#xf8;rdag") ],
            [ qw( januar februar marts april maj juni juli august
                  september oktober november december ) ],
            [ qw( am pm ) ],
            "%d.%m.%Y %H:%M",
            "%d.%m.%Y",
            "%H:%M",
          ],

    'se' => [
            [ ("s&#xf6;ndag", "m&#xe5;ndag", 'tisdag', 'onsdag', 'torsdag',
               'fredag', "l&#xf6;rdag") ],
            [ qw( januari februari mars april maj juni juli augusti
                  september oktober november december ) ],
            [ qw( FM EM ) ],
          ],

    'no' => [
            [ ("S&#xf8;ndag", "Mandag", 'Tirsdag', 'Onsdag', 'Torsdag',
               'Fredag', "L&#xf8;rdag") ],
            [ qw( Januar Februar Mars April Mai Juni Juli August
                  September Oktober November Desember ) ],
            [ qw( FM EM ) ],
          ],

    'de' => [
            [ qw( Sonntag Montag Dienstag Mittwoch Donnerstag Freitag
                  Samstag ) ],
            [ ('Januar', 'Februar', "M&#xe4;rz", 'April', 'Mai', 'Juni',
               'Juli', 'August', 'September', 'Oktober', 'November',
               'Dezember') ],
            [ qw( FM EM ) ],
            "%d.%m.%y %H:%M",
            "%d.%m.%y",
            "%H:%M",
          ],

    'it' => [
            [ ('Domenica', "Luned&#xec;", "Marted&#xec;", "Mercoled&#xec;",
               "Gioved&#xec;", "Venerd&#xec;", 'Sabato') ],
            [ qw( Gennaio Febbraio Marzo Aprile Maggio Giugno Luglio
                  Agosto Settembre Ottobre Novembre Dicembre ) ],
            [ qw( AM PM ) ],
            "%d.%m.%y %H:%M",
            "%d.%m.%y",
            "%H:%M",
          ],

    'pl' => [
            [ ('niedziela', "poniedzia&#322;ek", 'wtorek', "&#347;roda",
               'czwartek', "pi&#261;tek", 'sobota') ],
            [ ('stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca',
               'lipca', 'sierpnia', "wrze&#347;nia", "pa&#378;dziernika",
               'listopada', 'grudnia') ],
            [ qw( AM PM ) ],
            "%e %B %Y %k:%M",
            "%e %B %Y",
            "%k:%M",
          ],

    'fi' => [
            [ qw( sunnuntai maanantai tiistai keskiviikko torstai perjantai
                  lauantai ) ],
            [ ('tammikuu', 'helmikuu', 'maaliskuu', 'huhtikuu', 'toukokuu',
               "kes&#xe4;kuu", "hein&#xe4;kuu", 'elokuu', 'syyskuu', 'lokakuu',
               'marraskuu', 'joulukuu') ],
            [ qw( AM PM ) ],
            "%d.%m.%y %H:%M",
          ],

    'is' => [
            [ ('Sunnudagur', "M&#xe1;nudagur", "&#xde;ri&#xf0;judagur",
               "Mi&#xf0;vikudagur", 'Fimmtudagur', "F&#xf6;studagur",
               'Laugardagur') ],
            [ ("jan&#xfa;ar", "febr&#xfa;ar", 'mars', "apr&#xed;l", "ma&#xed;",
               "j&#xfa;n&#xed;", "j&#xfa;l&#xed;", "&#xe1;g&#xfa;st", 'september',
               "okt&#xf3;ber", "n&#xf3;vember", 'desember') ],
            [ qw( FH EH ) ],
            "%d.%m.%y %H:%M",
          ],

    'si' => [
            [ ('nedelja', 'ponedeljek', 'torek', 'sreda', "&#xe3;etrtek",
               'petek', 'sobota',) ],
            [ qw( januar februar marec april maj junij julij avgust
                  september oktober november december ) ],
            [ qw( AM PM ) ],
            "%d.%m.%y %H:%M",
          ],

    'cz' => [
            [ ('Ned&#283;le', 'Pond&#283;l&#237;', '&#218;ter&#253;',
               'St&#345;eda', '&#268;tvrtek', 'P&#225;tek', 'Sobota') ],
            [ ('Leden', '&#218;nor', 'B&#345;ezen', 'Duben', 'Kv&#283;ten',
               '&#268;erven', '&#268;ervenec', 'Srpen', 'Z&#225;&#345;&#237;',
               '&#216;&#237;jen', 'Listopad', 'Prosinec') ],
            [ qw( AM PM ) ],
            "%e. %B %Y %k:%M",
            "%e. %B %Y",
            "%k:%M",
          ],

    'sk' => [
            [ ('nede&#318;a', 'pondelok', 'utorok', 'streda',
               '&#353;tvrtok', 'piatok', 'sobota') ],
            [ ('janu&#225;r', 'febru&#225;r', 'marec', 'apr&#237;l',
               'm&#225;j', 'j&#250;n', 'j&#250;l', 'august', 'september',
               'okt&#243;ber', 'november', 'december') ],
            [ qw( AM PM ) ],
            "%e. %B %Y %k:%M",
            "%e. %B %Y",
            "%k:%M",
          ],

    'jp' => [
            [ '&#26085;&#26332;&#26085;', '&#26376;&#26332;&#26085;',
              '&#28779;&#26332;&#26085;', '&#27700;&#26332;&#26085;',
	      '&#26408;&#26332;&#26085;', '&#37329;&#26332;&#26085;',
              '&#22303;&#26332;&#26085;'],
            [ qw( 1 2 3 4 5 6 7 8 9 10 11 12 ) ],
            [ qw( AM PM ) ],
            "%Y&#24180;%m&#26376;%d&#26085; %H:%M",
            "%Y&#24180;%m&#26376;%d&#26085;",
            "%H:%M",
            "%Y&#24180;%m&#26376;",
          ],

    'et' => [
            [ qw( p&uuml;hap&auml;ev esmasp&auml;ev teisip&auml;ev
                  kolmap&auml;ev neljap&auml;ev reede laup&auml;ev ) ],
            [ ('jaanuar', 'veebruar', 'm&auml;rts', 'aprill', 'mai',
               'juuni', 'juuli', 'august', 'september', 'oktoober',
              'november', 'detsember') ],
            [ qw( AM PM ) ],
            "%m.%d.%y %H:%M",
            "%e. %B %Y",
            "%H:%M",
          ],
);

sub launch_background_tasks {
    require MT::ConfigMgr;
    my $cfg = MT::ConfigMgr->instance();
    return !($ENV{MOD_PERL} || !$cfg->LaunchBackgroundTasks);
}

sub start_background_task {
    my ($func) = @_;
    if (!launch_background_tasks()) { $func->() }
    else {
	$| = 1;            # Flush open filehandles
	my $pid = fork();
	if (!$pid) {
	    # child
	    close STDIN; open STDIN, "</dev/null";
	    close STDOUT; open STDOUT, ">/dev/null"; 
	    
 	    MT::Object->driver->init();

	    $func->();
	    CORE::exit(0) if defined($pid) && !$pid;
	} else {
	    MT::Object->driver->init();
	}
    }
}

{
    eval { require bytes; 1; };

    sub addbin {
	#local $ENV{LANG} = undef;
	my ($a, $b) = @_;
	my $length = (length $a > length $b ? length $a : length $b);
	
	$a = "\0" x ($length - (length $a)) . $a;
	$b = "\0" x ($length - (length $b)) . $b;
	my $carry = 0;
	my $result = '';
	for (my $i=1; $i <= $length; $i++) {
	    my $adigit = ord(substr($a, -$i, 1));
	    my $bdigit = ord(substr($b, -$i, 1));
	    my $rdigit = $adigit + $bdigit + $carry;
	    $carry = $rdigit / 256;
	    $result = chr($rdigit % 256) . $result;
	}
	if ($carry) {
	    return $result = chr($carry) . $result;
	} else {
	    return $result;
	}
    }

    sub multbindec {
	my ($a, $b) = @_;
	# $b is decimal-ascii, $b < 256
	my @result;
	$result[(length $a)] = 0;
	for (my $i=1; $i <= length $a; $i++) {
	    my $adigit = substr($a, -$i, 1);
	    $result[-$i] = ord($adigit) * $b;
	}
	
	for (my $i=2; $i <= scalar @result; $i++)
	{
	    $result[-$i] += int($result[-$i+1] / 256);
	    $result[-$i+1] = $result[-$i+1] % 256;
	}

	shift @result while (@result && ($result[0] == 0));
	
	pack('C*', @result);
    }

    sub divbindec {
#       local $ENV{LANG} = undef;
	my ($a, $b) = @_;
	# $b is decimal-ascii, $b < 256

	my $acc = ord(substr($a, 0, 1));
	my $quot;
	while (length $a) {
	    $a = substr($a, 1);
	    $quot .= chr($acc / $b);
	    $acc = $acc % $b;
	    if (length $a) {
		$acc = $acc * 256 + ord(substr($a, 0, 1));
	    }
	}
	return ($quot, $acc);
    }

    sub dec2bin {
	my ($decimal) = @_;
	my @digits = split //, $decimal;
	my $result = "";
	foreach my $d (@digits) {
	    $result = multbindec($result, 10);
	    $result = addbin(pack('c', $d), $result);
	}
	while (substr($result, 0, 1) eq "\0") {
	    $result = substr($result, 1);
	}
	$result;
    }

    sub bin2dec {
	my $bin = $_[0];
	my $result = '';
	my $rem = 0;
	while ((length $bin) && ($bin ne "\0")) {
	    ($bin, $rem) = divbindec($bin, 10);
	    $result = $rem . $result;
	    $bin = substr($bin, 1) if (substr($bin, 0, 1) eq "\0");
	}
	$result;
    }


    sub perl_sha1_digest {   # thanks to Adam Back for the starting point of this
	my ($message) = @_;
	my $init_string = 'D9T4C`>_-JXF8NMS^$#)4=L/2X?!:@GF9;MGKH8\;O-S*8L\'6';
	# 67452301 efcdab89 98badcfe 10325476 c3d2e1f0
	my @A = unpack"N*",unpack 'u',$init_string;
	my @K=splice@A,5,4;
	sub M{my ($x, $m); ($x=pop)-($m=1+~0)*int$x/$m};   # modulo 0x100000000
        sub L{my ($n, $x); $n=pop;(($x=pop)<<$n|2**$n-1&$x>>32-$n) & (0xffffffff)} # left-rotate bit vector
	# magic SHA1 functions
	my @F = (sub { my ($a, $b, $c, $d) = @_; $b&($c^$d)^$d },
		 sub { my ($a, $b, $c, $d) = @_; $b^$c ^$d},
		 sub { my ($a, $b, $c, $d) = @_; ($b|$c)&$d|$b&$c},
		 sub { my ($a, $b, $c, $d) = @_; $b^$c ^$d});
	my $F = sub {
	    my $which = shift;
	    my ($a, $b, $c, $d) = @_; 
	    if ($which == 0)
	    { $b&($c^$d)^$d }
	    elsif ($which == 1)
	    { $b^$c ^$d }
	    elsif ($which == 2)
	    { ($b|$c)&$d|$b&$c }
	    elsif ($which == 3) 
	    { $b^$c ^$d }
	};

	my ($l, $r, $p);
	my  $t;
	my $S;
	
	my @W;

	do {
	    $_ = substr($message, 0, 64);
	    $message = length$message >= 64 ? substr($message, 64) : "";
	    $l += $r = length $_;
	    $r++, $_ .= "\x80" if $r < 64 && !$p++;
	    @W = unpack 'N16', $_."\0"x(64-length($_));
	    $W[15] = $l*8 if $r < 57;
	    for (16..79)
	    {
		push @W, L($W[$_-3]^$W[$_-8]^$W[$_-14]^$W[$_-16], 1);
	    }
	    my ($a,$b,$c,$d,$e)=@A;
	    for(0..79)
	    {
		$t=M(($F->(int($_/ 20), $a, $b, $c, $d))+$e+$W[$_]+$K[$_/20]+L$a,5);
		$e=$d;
		$d=$c;
		$c=L$b,30;
		$b=$a;
		$a=$t;
	    }
	    my $v='a';
	    $A[0] = M$A[0]+$a;
	    $A[1] = M$A[1]+$b;
	    $A[2] = M$A[2]+$c;
	    $A[3] = M$A[3]+$d;
	    $A[4] = M$A[4]+$e;
	} while $r > 56;

        pack('N*', @A[0..4]);
    }
}

sub perl_sha1_digest_hex {
    sprintf("%.8x"x5, unpack('N*', &perl_sha1_digest(@_)));
}

sub dsa_verify {
    my %param = @_;

    eval {
	require Crypt::DSA;
    };
    my $has_crypt_dsa = $@ ? 0 : 1;
    $has_crypt_dsa = 0 if $param{ForcePerl};
    if ($has_crypt_dsa) {
	$param{Key} = bless $param{Key}, 'Crypt::DSA::Key';
	$param{Signature} = bless $param{Signature}, 'Crypt::DSA::Signature';
	Crypt::DSA->new->verify(%param);
    } else {
	require Math::BigInt;

	my($key, $dgst, $sig);

	Carp::croak __PACKAGE__ . "dsa_verify: Need a Key" 
	    unless $key = $param{Key};

	unless ($dgst = $param{Digest}) {
	    Carp::croak "dsa_verify: Need either Message or Digest"
		unless $param{Message};
	      $dgst = perl_sha1_digest($param{Message});
	  }
	Carp::croak "dsa_verify: Need a Signature"
	    unless $sig = $param{Signature};
	my $r = new Math::BigInt($sig->{r});
	my $s = new Math::BigInt($sig->{s});
	my $p = new Math::BigInt($key->{p});
	my $q = new Math::BigInt($key->{q});
	my $g = new Math::BigInt($key->{g});
	my $pub_key = new Math::BigInt($key->{pub_key});
	my $u2 = $s->bmodinv($q);

	my $u1 = new Math::BigInt("0x" . unpack("H*", $dgst));

	$u1 = $u1->bmul($u2)->bmod($q);
	$u2 = $r->bmul($u2)->bmod($q);
	my $t1 = $g->bmodpow($u1, $p);
	my $t2 = $pub_key->bmodpow($u2, $p);
	$u1 = $t1->bmul($t2)->bmod($key->{p});
	$u1 = $u1->bmod($key->{q});
	my $result = $u1->bcmp($sig->{r});
	return defined($result) ? $result == 0 : 0;
    }
}

1;
__END__

=head1 NAME

MT::Util - Movable Type utility functions

=head1 SYNOPSIS

    use MT::Util qw( functions );

=head1 DESCRIPTION

I<MT::Util> provides a variety of utility functions used by the Movable Type
libraries.

=head1 USAGE

=head2 start_end_day($ts)

Given I<$ts>, a timestamp in form C<YYYYMMDDHHMMSS>, calculates the timestamp
corresponding to the start of the same day, and, if called in list context,
the end of the day. If called in scalar context, returns one timestamp
corresponding to the start of the day; if called in list context, returns two
timestamps, for the start and end of the day.

For example, given C<20020410160406>, returns C<20020410000000> in scalar
context, and C<20020410000000> and C<20020410235959> in list context.

=head2 start_end_week($ts)

Given I<$ts>, a timestamp in form C<YYYYMMDDHHMMSS>, calculates the timestamp
corresponding to the start of the week, and, if called in list context, the
end of the week. If called in scalar context, returns one timestamp
corresponding to the start of the week; if called in list context, returns two
timestamps, for the start and end of the week.

A week is defined as starting on Sunday.

For example, given C<20020410160406>, returns C<20020407000000> in scalar
context, and C<20020407000000> and C<20020413235959> in list context.

=head2 start_end_month($ts)

Given I<$ts>, a timestamp in form C<YYYYMMDDHHMMSS>, calculates the timestamp
corresponding to the start of the month, and, if called in list context,
the end of the month. If called in scalar context, returns one timestamp
corresponding to the start of the month; if called in list context, returns two
timestamps, for the start and end of the month.

For example, given C<20020410160406>, returns C<20020401000000> in scalar
context, and C<20020401000000> and C<20020430235959> in list context.

=head2 offset_time_list($unix_ts, $blog [, $direction ])

Given I<$unix_ts>, a timestamp in Unix epoch format (seconds since 1970),
applies the timezone offset specified in the blog I<$blog> (either an
I<MT::Blog> object or a numeric blog ID). If daylight saving time is in
effect in the local time zone (determined using the return value from
I<localtime()>), the offset is automatically adjusted.

Returns the return value of I<gmtime()> given the adjusted Unix timestamp.

=head2 format_ts($format, $ts, $blog)

Given a timestamp I<$ts> in form C<YYYYMMDDHHMMSS>, applies the format
specified in I<$format> and returns the formatted string.

If specified, I<$blog> should be an I<MT::Blog> object, from which the
date/time formatting language preference is taken (e.g. English, French, etc.).
If unspecified, English formatting is used.

If I<$format> is C<undef>, and I<$blog> is specified, I<format_ts> will
use a language-specific default format; if a language-specific format is not
defined, or if I<$blog> is unspecified, the default format used is
C<%B %e, %Y %I:%M %p>.

=head2 days_in($month, $year)

Returns the number of days in the month I<$month> in the year I<$year>.
I<$month> should be numeric, starting at C<1> for C<January>. I<$year> should
be a 4-digit year. The number of days is automatically adjusted in a leap
year.

=head2 wday_from_ts($year, $month, $day)

Returns the numeric day of the week, in the range C<0>-C<6>, where C<0> is
C<Sunday>, for the date specified in I<$year>, I<$month>, and I<$day>.
I<$year> should be a 4-digit year; I<$month> a numeric value in the range
C<1>-C<12>; and I<$day> the numeric day of the month.

=head2 first_n_words($str, $n)

Given a string I<$str>, returns the first I<$n> words in the string, after
removing any HTML tags.

=head2 dirify($str)

Munges a string I<$str> so that it is suitable for use as a file/directory
name. HTML is removed; HTML-entities are removed; non-word/space characters
are removed; spaces are changed to underscores; the entire string is
converted to lower-case.

For example, the string C<Foo E<lt>bE<gt>BarE<lt>/bE<gt> E<amp>quot;BazE<amp>quot;> would be transformed into C<foo_bar_baz>.

=head2 encode_html($str)

Encodes any special characters in I<$str> into HTML entities and returns the
transformed string.

If I<HTML::Entities> is available, and if the configuration setting
I<NoHTMLEntities> is not set, uses I<HTML::Entities> for entity-encoding.
Otherwise, very simple encoding is done to catch the most common characters
that need encoding.

=head2 decode_html($str)

Decodes any HTML entities in I<$str> into the corresponding characters and
returns the transformed string.

If I<HTML::Entities> is available, and if the configuration setting
I<NoHTMLEntities> is not set, uses I<HTML::Entities> for entity-decoding.
Otherwise, very simple decoding is done to catch the most common entities
that need decoding.

=head2 remove_html($str)

Removes any HTML tags from I<$str> and returns the result.

=head2 encode_js($str)

Escapes/encodes any special characters in I<$str> so that the string can be
used safely as the value in Javascript; returns the transformed string.

=head2 encode_php($str [, $type ])

Escapes/encodes any special characters in I<$str> so that the string can be
used safely as the value in PHP code; returns the transformed string.

I<$type> can be either C<qq> (double-quote interpolation), C<here> (heredoc
interpolation), or C<q> (single-quote interpolation). C<q> is the default.

=head2 spam_protect($email_address)

Given an email address I<$email_address>, encodes any characters that will
identify it as an email address (C<:>, C<@>, and C<.>) into HTML entities,
so that spam harvesters will not see the email address as easily. Returns
the transformed address.

=head2 is_valid_email($email_address)

Checks the email address I<$email_address> for syntax validity; if the
address--or part of it--is valid, I<is_valid_email> returns the valid (part
of) the email address. Otherwise, it returns C<0>.

=head2 perl_sha1_digest($msg)

Returns a SHA1 digest of $msg. The result is the usual packed binary
representation. Use perl_sha1_digest_hex to get a printable string.

=head2 perl_sha1_digest_hex($msg)

Returns a SHA1 digest of $msg. The result is an ASCII string of hex
digits. Use perl_sha1_digest to get a binary representation.

=head2 dsa_verify(Key => $key, Signature => $sig,
    [ Message => $msg | $Digest => $dgst ])

Verifies that sig is a DSA signature of $msg (or $dgst) produced using
the private half of the public key given in $key. Requires
Math::BigInt but doesn't call for any non-perl libraries.

=head1 AUTHOR & COPYRIGHTS

Please see the I<MT> manpage for author, copyright, and license information.

=cut
