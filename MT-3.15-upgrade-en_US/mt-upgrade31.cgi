#!/usr/bin/perl -w
use strict;

# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-upgrade31.cgi,v 1.15.2.1 2004/10/12 18:52:03 ezra Exp $
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

sub add_once {
    my ($stmts, $dbh, $table, $col, $type) = @_;
    
    push @$stmts, "alter table $table add $col $type"
        unless has_column($dbh, $table, $col);
    return @$stmts;
}

eval {
    local $SIG{__WARN__} = sub { print "**** WARNING: $_[0]\n" };

    require MT;
    if (MT->version_number < 3.1) {
        print "You have not yet upgraded to the 3.0 version of MT. Please do that before you run this script. Exiting...";
        exit;
    }

    my $mt = MT->new( Config => $MT_DIR . 'mt.cfg')
        or die MT->errstr;

    print "Upgrading your databases:\n";
    

    my $dbh = MT::Object->driver->{dbh};

    my @stmts;
    if ($mt->{cfg}->ObjectDriver =~ /mysql/) {
        @stmts = add_once(\@stmts, $dbh, 'mt_blog', 'blog_ping_technorati', 'tinyint')
            unless has_column($dbh, 'mt_blog', 'blog_ping_technorati');
        @stmts = add_once(\@stmts, $dbh, 'mt_blog', 'blog_children_modified_on', 'datetime')
            unless has_column($dbh, 'mt_blog', 'blog_children_modified_on');
        push @stmts, ('alter table mt_blog add blog_custom_dynamic_templates varchar(25)',
                      "update mt_blog set blog_custom_dynamic_templates = 'none'")
            unless has_column($dbh, 'mt_blog', 'blog_custom_dynamic_template');
        @stmts = add_once(\@stmts, $dbh, 'mt_template', 'template_created_on', 'datetime not null');
        @stmts = add_once(\@stmts, $dbh, 'mt_template', 'template_modified_on', 'timestamp not null');
        @stmts = add_once(\@stmts, $dbh, 'mt_template', 'template_created_by', 'integer');
        @stmts = add_once(\@stmts, $dbh, 'mt_template', 'template_modified_by', 'integer');
        push @stmts, ('alter table mt_template add template_build_dynamic tinyint')
            unless has_column($dbh, 'mt_template', 'template_build_dynamic');
        push @stmts, ('update mt_template set template_build_dynamic = 0 where template_build_dynamic <> 1',
                      'alter table mt_template modify template_build_dynamic tinyint not null');

        push @stmts, ('alter table mt_category add category_parent integer',
                      'update mt_category set category_parent = 0',
                      'alter table mt_category modify category_parent integer not null')
            unless has_column($dbh, 'mt_category', 'category_parent');
        push @stmts, 'alter table mt_entry modify entry_basename varchar(50) not null';
        push @stmts, <<FILEINFO
create table mt_fileinfo (
    fileinfo_id integer primary key auto_increment,
    fileinfo_blog_id integer not null,
    fileinfo_entry_id integer,
    fileinfo_url varchar(255),
    fileinfo_file_path text,
    fileinfo_template_id integer,
    fileinfo_templatemap_id integer,
    fileinfo_archive_type varchar(255),
    fileinfo_category_id integer,
    fileinfo_startdate varchar(80),
    fileinfo_virtual tinyint,
    index(fileinfo_blog_id),
    index(fileinfo_entry_id),
    index(fileinfo_url)
)
FILEINFO
            unless has_column($dbh, 'mt_fileinfo', 'fileinfo_id');
    } elsif ($mt->{cfg}->ObjectDriver =~ /postgres/) {
        @stmts = add_once(\@stmts, $dbh, 'mt_blog', 'blog_ping_technorati', 'smallint')
            unless has_column($dbh, 'mt_blog', 'blog_ping_technorati');
        @stmts = add_once(\@stmts, $dbh, 'mt_blog', 'blog_children_modified_on', 'timestamp')
            unless has_column($dbh, 'mt_blog', 'blog_children_modified_on');
        push @stmts, ('alter table mt_blog add blog_custom_dynamic_templates varchar(25)',
                      "update mt_blog set blog_custom_dynamic_templates = 'none'")
            unless has_column($dbh, 'mt_blog', 'blog_custom_dynamic_template');
        @stmts = add_once(\@stmts, $dbh, 'mt_template', 'template_created_on', 'timestamp');
        @stmts = add_once(\@stmts, $dbh, 'mt_template', 'template_modified_on', 'timestamp');
        @stmts = add_once(\@stmts, $dbh, 'mt_template', 'template_created_by', 'integer');
        @stmts = add_once(\@stmts, $dbh, 'mt_template', 'template_modified_by', 'integer');
        push @stmts, ('alter table mt_template add template_build_dynamic smallint')
            unless has_column($dbh, 'mt_template', 'template_build_dynamic');
        push @stmts, ('update mt_template set template_build_dynamic = 0 where template_build_dynamic <> 1 or template_build_dynamic is null',
                      'alter table mt_template alter column template_build_dynamic set not null');            
        push @stmts, ('alter table mt_category add category_parent integer',
                      'update mt_category set category_parent = 0',
                      'alter table mt_category alter column category_parent set not null')
            unless has_column($dbh, 'mt_category', 'category_parent');
        push @stmts, ("update mt_entry set entry_basename = '' where entry_basename is null",
                      'alter table mt_entry alter column entry_basename set not null');
        unless (has_column($dbh, 'mt_fileinfo', 'fileinfo_id')) {
            push @stmts, <<FILEINFO;
create table mt_fileinfo (
    fileinfo_id integer primary key,
    fileinfo_blog_id integer not null,
    fileinfo_entry_id integer,
    fileinfo_url varchar(255),
    fileinfo_file_path text,
    fileinfo_template_id integer,
    fileinfo_templatemap_id integer,
    fileinfo_archive_type varchar(255),
    fileinfo_category_id integer,
    fileinfo_startdate varchar(80),
    fileinfo_virtual smallint
)
FILEINFO
            push @stmts, ("create sequence mt_fileinfo_id",
                          "create index mt_fileinfo_blog_id on mt_fileinfo (fileinfo_blog_id)",
                          "create index mt_fileinfo_entry_id on mt_fileinfo (fileinfo_entry_id)",
                          "create index mt_fileinfo_url on mt_fileinfo (fileinfo_url)");
        }
    } elsif ($mt->{cfg}->ObjectDriver =~ /sqlite/) {
        my @tables = qw( mt_blog mt_category mt_template );
        @stmts = map { 'create temporary table '. $_ .'_temp as select * from '. $_ }
              @tables;
        push @stmts, map { 'drop table '. $_ } @tables;
        push @stmts, ('create table mt_blog (
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
    blog_remote_auth_token varchar(50),
    blog_ping_technorati boolean,
    blog_children_modified_on datetime,
    blog_custom_dynamic_templates varchar(25)
)',
    'create index mt_blog_name on mt_blog (blog_name)');
        push @stmts, 'create table mt_category (
    category_id integer not null primary key,
    category_blog_id integer not null,
    category_allow_pings boolean,
    category_label varchar(100) not null,
    category_description text,
    category_author_id integer,
    category_ping_urls text,
    category_parent integer not null default 0,
    unique (category_blog_id, category_label)
)';
        push @stmts, 'create table mt_template (
    template_id integer not null primary key,
    template_blog_id integer not null,
    template_name varchar(50) not null,
    template_type varchar(25) not null,
    template_outfile varchar(255),
    template_rebuild_me boolean,
    template_text text,
    template_linked_file varchar(255),
    template_linked_file_mtime varchar(10),
    template_linked_file_size integer,
    template_created_on datetime not null,
    template_modified_on timestamp not null,
    template_created_by integer,
    template_modified_by integer,
    template_build_dynamic boolean not null default 0,
    unique (template_blog_id, template_name)
)',
    'create index mt_template_type on mt_template (template_type)';
        push @stmts, 'create table mt_fileinfo (
    fileinfo_id INTEGER PRIMARY KEY,
    fileinfo_blog_id integer not null,
    fileinfo_entry_id integer,
    fileinfo_url varchar(255),
    fileinfo_file_path text,
    fileinfo_template_id integer,
    fileinfo_templatemap_id integer,
    fileinfo_archive_type varchar(255),
    fileinfo_category_id integer,
    fileinfo_startdate varchar(80),
    fileinfo_virtual tinyint
)',
    'create index mt_fileinfo_blog_id on mt_fileinfo (fileinfo_blog_id)',
    'create index mt_fileinfo_entry_id on mt_fileinfo (fileinfo_entry_id)',
    'create index mt_fileinfo_url on mt_fileinfo (fileinfo_url)';
    push @stmts,
        'insert into mt_blog (blog_id, blog_name, blog_description, blog_site_path, blog_site_url, blog_archive_path, blog_archive_url, blog_archive_type, blog_archive_type_preferred, blog_days_on_index, blog_language, blog_file_extension, blog_email_new_comments, blog_email_new_pings, blog_allow_comment_html, blog_autolink_urls, blog_sort_order_posts, blog_sort_order_comments, blog_allow_comments_default, blog_allow_pings_default, blog_server_offset, blog_convert_paras, blog_convert_paras_comments, blog_status_default, blog_allow_anon_comments, blog_allow_unreg_comments, blog_allow_reg_comments, blog_moderate_unreg_comments, blog_require_comment_emails, blog_manual_approve_commenters, blog_words_in_excerpt, blog_ping_weblogs, blog_ping_blogs, blog_ping_others, blog_mt_update_key, blog_autodiscover_links, blog_welcome_msg, blog_old_style_archive_links, blog_archive_tmpl_monthly, blog_archive_tmpl_weekly, blog_archive_tmpl_daily, blog_archive_tmpl_individual, blog_archive_tmpl_category, blog_google_api_key, blog_sanitize_spec, blog_cc_license, blog_is_dynamic, blog_remote_auth_token, blog_ping_technorati, blog_children_modified_on, blog_custom_dynamic_templates) select *, 0, \'2004-01-01 00:00:00\', \'none\' from mt_blog_temp',
        'insert into mt_category (category_id, category_blog_id, category_allow_pings, category_label, category_description, category_author_id, category_ping_urls, category_parent) select *, 0 from mt_category_temp',
        'insert into mt_template (template_id, template_blog_id, template_name, template_type, template_outfile, template_rebuild_me, template_text, template_linked_file, template_linked_file_mtime, template_linked_file_size, template_created_on, template_modified_on, template_created_by, template_modified_by, template_build_dynamic) select *, \'2004-01-01 00:00:00\', \'\', \'2004-01-01 00:00:00\', \'\', 0 from mt_template_temp'
    } elsif ($mt->{cfg}->ObjectDriver =~ /DBM/) {
        my @blogs = MT::Blog->load();
        for my $blog (@blogs) {
            $blog->custom_dynamic_templates('none');
            $blog->save();
        }
        require MT::Category;
        foreach my $cat (MT::Category->load()) {
            $cat->parent(0);
            $cat->save();
        }
        require MT::Template;
        foreach my $tmpl (MT::Template->load()) {
            $tmpl->build_dynamic(0);
            $tmpl->save();
        }
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
    my $bootstrap_template = 
	MT::Template->count({name => 'Dynamic Site Bootstrapper'});
    my $dyn_error_template = 
	MT::Template->count({type => 'dynamic_error'});


    if (!$bootstrap_template || !$dyn_error_template) {
	my $default_templates = require 'MT/default-templates.pl' 
	    or die "Couldn't find MT/default-templates.pl";
	require MT::Blog;
	my @blogs = MT::Blog->load();
	foreach my $tmpl (@$default_templates) {
	    if ($tmpl->{name} eq 'Dynamic Site Bootstrapper'
                || $tmpl->{type} eq 'dynamic_error') {
		print "Creating " . $tmpl->{name} . ".\n";
		foreach my $blog (@blogs) {
		    $tmpl->{text} = $mt->translate_templatized($tmpl->{text});
		    require MT::Template;
		    my $obj = MT::Template->new;
		    $obj->set_values($tmpl);
                    $obj->build_dynamic(0) unless $obj->build_dynamic;
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
