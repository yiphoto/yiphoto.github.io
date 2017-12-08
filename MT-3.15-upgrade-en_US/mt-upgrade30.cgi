#!/usr/bin/perl -w
use strict;

# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-upgrade30.cgi,v 1.30 2004/09/09 00:28:14 ezra Exp $
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

sub has_column
{
    my ($dbh, $table, $column) = @_;

    my $sth = $dbh->prepare("describe $table");
    if ($sth && $sth->execute()) {
	my $ddl = $sth->fetchall_arrayref();

	my @columns = map { $$_[0] } @$ddl;

	return (grep { $_ =~ /$column/ } @columns) ? 1 : 0;
    } else {
	$sth = $dbh->prepare("select $column from $table");
	$sth->execute() or return 0;
	return 1;
    }
}

eval {
    local $SIG{__WARN__} = sub { print "**** WARNING: $_[0]\n" };

    require MT;
    if (MT->version_number < 3.0) {
        print "You have not yet upgraded to the 3.0 version of MT. Please do that before you run this script. Exiting...";
        exit;
    }

    my $mt = MT->new( Config => $MT_DIR . 'mt.cfg')
        or die MT->errstr;

    print "Upgrading your databases:\n";
    

    my $dbh = MT::Object->driver->{dbh};

    my @stmts;
    if ($mt->{cfg}->ObjectDriver =~ /mysql/) {

	push @stmts,'alter table mt_blog add blog_require_comment_emails tinyint'
	    unless has_column($dbh, 'mt_blog', 'blog_require_comment_emails');
	push @stmts, ('alter table mt_entry add entry_basename varchar(50)',
			'update mt_entry set entry_basename = \'\'',
		  'create index mt_entry_basename ON mt_entry (entry_basename)')
	    unless has_column($dbh, 'mt_entry', 'entry_basename');
	push @stmts, <<CREATE,
create table mt_session (
    session_id varchar(80) not null primary key,
    session_data text,
    session_email varchar(255),
    session_name varchar(255),
    session_start int not null,
    session_kind varchar(2),
    index (session_start)
)
CREATE
            unless has_column($dbh, 'mt_session', 'session_id');
	push @stmts, ('alter table mt_author add author_type tinyint not null',
		  'alter table mt_author drop index author_name',
		  'alter table mt_author add unique (author_name,author_type)')
	    unless has_column($dbh, 'mt_author', 'author_type');
	push @stmts, ('update mt_author set author_type = 1 where author_type <> 2');
	push @stmts, ('alter table mt_author add author_remote_auth_username varchar(50)')
	    unless has_column($dbh, 'mt_author', 'author_remote_auth_username');
	push @stmts, 'alter table mt_author add author_remote_auth_token varchar(50)'
	    unless has_column($dbh, 'mt_author', 'author_remote_auth_token');
	push @stmts, ('alter table mt_blog add blog_allow_unreg_comments tinyint',
		      'update mt_blog set blog_allow_unreg_comments = 1')
	    unless has_column($dbh, 'mt_blog', 'blog_allow_unreg_comments');
	push @stmts, ('alter table mt_blog add blog_allow_reg_comments tinyint',
		      'update mt_blog set blog_allow_reg_comments = 1')
	    unless has_column($dbh, 'mt_blog', 'blog_allow_reg_comments');
	push @stmts, ('alter table mt_blog add blog_manual_approve_commenters tinyint',
		      'update mt_blog set blog_manual_approve_commenters = 0')
	    unless has_column($dbh, 'mt_blog', 'blog_manual_approve_commenters');
	push @stmts, ('alter table mt_blog add blog_old_style_archive_links tinyint',
		      'update mt_blog set blog_old_style_archive_links = 1')
	    unless has_column($dbh, 'mt_blog', 'blog_old_style_archive_links');
	push @stmts, 'alter table mt_comment add comment_commenter_id integer'
	    unless has_column($dbh, 'mt_comment', 'comment_commenter_id');
	push @stmts, ('alter table mt_comment add comment_visible tinyint',
		      'update mt_comment set comment_visible = 1')
	    unless has_column($dbh, 'mt_comment', 'comment_visible');
	push @stmts, ('alter table mt_blog add blog_moderate_unreg_comments tinyint')
	    unless has_column($dbh, 'mt_blog', 'blog_moderate_unreg_comments');
	push @stmts, 'alter table mt_blog add blog_remote_auth_token varchar(50)'
	    unless has_column($dbh, 'mt_blog', 'blog_remote_auth_token');
    } elsif ($mt->{cfg}->ObjectDriver =~ /postgres/) {
	push @stmts, ('alter table mt_author add author_type smallint',
		      'alter table mt_author alter column author_type SET DEFAULT 1',
		      'alter table mt_author drop constraint mt_author_author_name_key',
		      'alter table mt_author add unique (author_name,author_type)')
	    unless has_column($dbh, 'mt_author', 'author_type');
	push @stmts, ('update mt_author set author_type = 1 where author_type <> 2 or author_type is NULL');
	push @stmts, 'alter table mt_author add author_remote_auth_username varchar(50)'
	    unless has_column($dbh, 'mt_author', 'author_remote_auth_username');
	push @stmts, 'alter table mt_author add author_remote_auth_token varchar(50)'
	    unless has_column($dbh, 'mt_author', 'author_remote_auth_token');
	push @stmts, ('alter table mt_blog add blog_allow_unreg_comments smallint',
		      'update mt_blog set blog_allow_unreg_comments = 1')
	    unless has_column($dbh, 'mt_blog', 'blog_allow_unreg_comments');
	push @stmts, ('alter table mt_blog add blog_allow_reg_comments smallint',
		      'update mt_blog set blog_allow_reg_comments = 1')
	    unless has_column($dbh, 'mt_blog', 'blog_allow_reg_comments');
	push @stmts, ('alter table mt_blog add blog_manual_approve_commenters smallint',
		      'update mt_blog set blog_manual_approve_commenters = 0')
	    unless has_column($dbh, 'mt_blog', 'blog_manual_approve_commenters');
	push @stmts, ('alter table mt_blog add blog_old_style_archive_links smallint',
		'update mt_blog set blog_old_style_archive_links = 1')
	    unless has_column($dbh, 'mt_blog', 'blog_old_style_archive_links');
	push @stmts, 'alter table mt_comment add comment_commenter_id integer'
	    unless has_column($dbh, 'mt_comment', 'comment_commenter_id');
	push @stmts, ('alter table mt_comment add comment_visible smallint',
		     'update mt_comment set comment_visible = 1')
	    unless has_column($dbh, 'mt_comment', 'comment_visible');
	push @stmts, ('alter table mt_blog add blog_require_comment_emails smallint')
	    unless has_column($dbh, 'mt_blog', 'blog_require_comment_emails');
	push @stmts, 'alter table mt_blog add blog_moderate_unreg_comments smallint'
	    unless has_column($dbh, 'mt_blog', 'blog_moderate_unreg_comments');
	push @stmts, 'alter table mt_blog add blog_remote_auth_token varchar(50)'
	    unless has_column($dbh, 'mt_blog', 'blog_remote_auth_token');
	push @stmts, ('alter table mt_entry add entry_basename varchar(50)',
		'create index mt_entry_basename on mt_entry (entry_basename)')
	    unless has_column($dbh, 'mt_entry', 'entry_basename');
	push @stmts, (<<CREATE,
create table mt_session (
    session_id varchar(80) not null primary key,
    session_data text,
    session_email varchar(255),
    session_name varchar(255),
    session_start integer not null,
    session_kind varchar(2)
)
CREATE
		'create index mt_session_start on mt_session (session_start)')
	    unless has_column($dbh, 'mt_session', 'session_id');
    } elsif ($mt->{cfg}->ObjectDriver =~ /sqlite/) {
	my @tables = qw( mt_author mt_comment mt_blog mt_entry );

	@stmts = map { 'create temporary table '. $_ .'_temp as select * from '. $_ }
	    qw( mt_author mt_comment mt_blog mt_entry );
	push @stmts, map { 'drop table '. $_ } qw( mt_author mt_comment mt_blog mt_entry );
	push @stmts, <<'CREATE',
create table mt_author (
    author_id integer not null primary key,
    author_name varchar(50) not null,
    author_type smallint not null,
    author_nickname varchar(50),
    author_password varchar(60) not null,
    author_email varchar(75) not null,
    author_url varchar(255),
    author_can_create_blog boolean,
    author_can_view_log boolean,
    author_hint varchar(75),
    author_created_by integer,
    author_public_key text,
    author_preferred_language varchar(50),
    author_remote_auth_username varchar(50),
    author_remote_auth_token varchar(50),
    unique (author_name, author_type)
)
CREATE
	    'create index mt_author_email on mt_author (author_email)', 
	    <<'CREATE',
create table mt_blog (
    blog_id integer not null primary key,
    blog_name varchar(255) not null,
    blog_description text,
    blog_site_path varchar(255),
    blog_site_url varchar(255),
    blog_archive_path varchar(255),
    blog_archive_url varchar(255),
    blog_archive_type varchar(255),
    blog_archive_type_preferred varchar(25),
    blog_days_on_index smallint,
    blog_language varchar(5),
    blog_file_extension varchar(10),
    blog_email_new_comments boolean,
    blog_email_new_pings boolean,
    blog_allow_comment_html boolean,
    blog_autolink_urls boolean,
    blog_sort_order_posts varchar(8),
    blog_sort_order_comments varchar(8),
    blog_allow_comments_default boolean,
    blog_allow_pings_default boolean,
    blog_server_offset float,
    blog_convert_paras varchar(30),
    blog_convert_paras_comments varchar(30),
    blog_status_default smallint,
    blog_allow_anon_comments boolean,
    blog_allow_unreg_comments smallint,
    blog_allow_reg_comments smallint,
    blog_moderate_unreg_comments smallint,
    blog_require_comment_emails smallint,
    blog_manual_approve_commenters smallint,
    blog_words_in_excerpt smallint,
    blog_ping_weblogs boolean,
    blog_ping_blogs boolean,
    blog_ping_others text,
    blog_mt_update_key varchar(30),
    blog_autodiscover_links boolean,
    blog_welcome_msg text,
    blog_old_style_archive_links smallint,
    blog_archive_tmpl_monthly varchar(255),
    blog_archive_tmpl_weekly varchar(255),
    blog_archive_tmpl_daily varchar(255),
    blog_archive_tmpl_individual varchar(255),
    blog_archive_tmpl_category varchar(255),
    blog_google_api_key varchar(32),
    blog_sanitize_spec varchar(255),
    blog_cc_license varchar(255),
    blog_is_dynamic boolean,
    blog_remote_auth_token varchar(50)
)
CREATE
	    'create index mt_blog_name on mt_blog (blog_name)',
	    <<'CREATE',
create table mt_comment (
    comment_id integer not null primary key,
    comment_blog_id integer not null,
    comment_entry_id integer not null,
    comment_ip varchar(16),
    comment_author varchar(100),
    comment_email varchar(75),
    comment_url varchar(255),
    comment_commenter_id integer,
    comment_visible smallint,
    comment_text text,
    comment_created_on timestamp not null,
    comment_modified_on timestamp not null,
    comment_created_by integer,
    comment_modified_by integer
)
CREATE
	    'create index mt_comment_created_on on mt_comment (comment_created_on)',
	    'create index mt_comment_entry_id on mt_comment (comment_entry_id)',
	    'create index mt_comment_blog_id on mt_comment (comment_blog_id)',
	    <<'CREATE',
create table mt_entry (
    entry_id integer not null primary key,
    entry_blog_id integer not null,
    entry_status smallint not null,
    entry_author_id integer not null,
    entry_allow_comments boolean,
    entry_allow_pings boolean,
    entry_convert_breaks varchar(30),
    entry_category_id integer,
    entry_title varchar(255),
    entry_excerpt text,
    entry_text text,
    entry_text_more text,
    entry_to_ping_urls text,
    entry_pinged_urls text,
    entry_keywords text,
    entry_tangent_cache text,
    entry_created_on timestamp not null,
    entry_modified_on timestamp not null,
    entry_basename varchar(50),
    entry_created_by integer,
    entry_modified_by integer
)
CREATE
	    'create index mt_entry_blog_id on mt_entry (entry_blog_id)',
	    'create index mt_entry_status on mt_entry (entry_status)',
	    'create index mt_entry_author_id on mt_entry (entry_author_id)',
	    'create index mt_entry_created_on on mt_entry (entry_created_on)',
	    'create index mt_entry_basename on mt_entry (entry_basename)';

	
	push @stmts, <<CREATE,
create table mt_session (
    session_id varchar(80) not null primary key,
    session_data text,
    session_email varchar(255),
    session_name varchar(255),
    session_start integer not null,
    session_kind varchar(2)
)
CREATE
	    'create index mt_session_start on mt_session (session_start)';

	push @stmts,
	    'insert into mt_author (author_id, author_name, author_nickname, author_password, author_email, author_url, author_can_create_blog, author_can_view_log, author_hint, author_created_by, author_public_key, author_preferred_language, author_type) select *, 1 from mt_author_temp',
	    'insert into mt_comment (comment_id, comment_blog_id, comment_entry_id, comment_ip, comment_author, comment_email, comment_url, comment_text, comment_created_on, comment_modified_on, comment_created_by, comment_modified_by) select * from mt_comment_temp',
	    'insert into mt_blog (blog_id, blog_name, blog_description, blog_site_path, blog_site_url, blog_archive_path, blog_archive_url, blog_archive_type, blog_archive_type_preferred, blog_days_on_index, blog_language, blog_file_extension, blog_email_new_comments, blog_email_new_pings, blog_allow_comment_html, blog_autolink_urls, blog_sort_order_posts, blog_sort_order_comments, blog_allow_comments_default, blog_allow_pings_default, blog_server_offset, blog_convert_paras, blog_convert_paras_comments, blog_status_default, blog_allow_anon_comments, blog_words_in_excerpt, blog_ping_weblogs, blog_ping_blogs, blog_ping_others, blog_mt_update_key, blog_autodiscover_links, blog_welcome_msg, blog_archive_tmpl_monthly, blog_archive_tmpl_weekly, blog_archive_tmpl_daily, blog_archive_tmpl_individual, blog_archive_tmpl_category, blog_google_api_key, blog_sanitize_spec, blog_cc_license, blog_is_dynamic) select * from mt_blog_temp',
	    'insert into mt_entry (entry_id, entry_blog_id, entry_status, entry_author_id, entry_allow_comments, entry_allow_pings, entry_convert_breaks, entry_category_id, entry_title, entry_excerpt, entry_text, entry_text_more, entry_to_ping_urls, entry_pinged_urls, entry_keywords, entry_tangent_cache, entry_created_on, entry_modified_on, entry_created_by, entry_modified_by) select * from mt_entry_temp';

	push @stmts,
	    'update mt_author set author_type = 1 where author_type <> 2',
	    'update mt_comment set comment_visible = 1',
	    'update mt_blog set blog_allow_unreg_comments = 1',
	    'update mt_blog set blog_allow_reg_comments = 1',
	    'update mt_blog set blog_manual_approve_commenters = 0',
	    'update mt_blog set blog_old_style_archive_links = 1';

    } elsif ($mt->{cfg}->ObjectDriver =~ /DBM/) {
	#### FIXME break this up into separate scripts?
	my @objs;
	my $obj;
        MT::ObjectDriver::DBM->no_build_indexes(1);
	@objs = MT::Author->load();
	for $obj (@objs) {
	    $obj->type(1);
	    $obj->save();
	}
	@objs = MT::Blog->load();
	for $obj (@objs) {
	    $obj->allow_unreg_comments(1);
	    $obj->allow_reg_comments(1);
	    $obj->manual_approve_commenters(0);
	    $obj->old_style_archive_links(1);
	    $obj->moderate_unreg_comments(0);
	    $obj->save();
	}
	my $obj_iter= MT::Comment->load_iter();
	my @cmt_ids = ();
	while ($obj =$obj_iter->()) {
	    push @cmt_ids, $obj->id;
	}
	for my $obj_id (@cmt_ids) {
	    $obj = MT::Comment->load($obj_id);
	    $obj->visible(1);
	    $obj->save();
	}
        MT::ObjectDriver::DBM->no_build_indexes(0);
        $MT::Object::DRIVER->rebuild_indexes("MT::Blog");
        $MT::Object::DRIVER->rebuild_indexes("MT::Author");
        $MT::Object::DRIVER->rebuild_indexes("MT::Comment");
    } else {
	print "Hm; I don't recognize your ObjectDriver setting. " 
	    . "Please set it to one of DBM, DBI::mysql, DBI::sqlite, "
	    . "or DBI::postgres";
    }
    
    for my $sql (@stmts) {
        print "Running '$sql'\n";
        $dbh->do($sql) or die $dbh->errstr . " on $sql";
    }

    require MT::Template;
    my $comment_pending_template = 
	MT::Template->count({type => 'comment_pending'});

    if (!$comment_pending_template) {
	my $default_templates = require 'MT/default-templates.pl' 
	    or die "Couldn't find MT/default-templates.pl";
	require MT::Blog;
	my @blogs = MT::Blog->load();
	foreach my $tmpl (@$default_templates) {
	    if ($tmpl->{type} eq 'comment_pending') {
		print "Creating comment_pending template.\n";
		foreach my $blog (@blogs) {
		    $tmpl->{text} = $mt->translate_templatized($tmpl->{text});
		    require MT::Template;
		    my $obj = MT::Template->new;
		    $obj->set_values($tmpl);
                    $obj->build_dynamic(0);
		    $obj->blog_id($blog->id);
		    $obj->save or die $obj->errstr;
		    $obj->commit();
		}
	    }
	}
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
