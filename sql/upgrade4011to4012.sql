# --------------------------------------------------------
#
# Upgrade SQL for Mambo 4.0.11 -> Mambo 4.0.12
#
# --------------------------------------------------------
#
# Table Rename...Add mos_ prefix
#
ALTER TABLE articles RENAME TO mos_articles;
ALTER TABLE banner RENAME TO mos_banner;
ALTER TABLE bannerclient RENAME TO mos_bannerclient;
ALTER TABLE bannerfinish RENAME TO mos_bannerfinish;
ALTER TABLE categories RENAME TO mos_categories;
ALTER TABLE component_module RENAME TO mos_component_module;
ALTER TABLE components RENAME TO mos_components;
ALTER TABLE contact_details RENAME TO mos_contact_details;
ALTER TABLE counter RENAME TO mos_counter;
ALTER TABLE faqcont RENAME TO mos_faqcont;
ALTER TABLE links RENAME TO mos_links;
ALTER TABLE mambo_modules RENAME TO mos_mambo_modules;
ALTER TABLE menu RENAME TO mos_menu;
ALTER TABLE menucontent RENAME TO mos_menucontent;
ALTER TABLE newsfeedscategory RENAME TO mos_newsfeedscategory;
ALTER TABLE newsfeedslinks RENAME TO mos_newsfeedslinks;
ALTER TABLE newsflash RENAME TO mos_newsflash;
ALTER TABLE poll_data RENAME TO mos_poll_data;
ALTER TABLE poll_date RENAME TO mos_poll_date;
ALTER TABLE poll_desc RENAME TO mos_poll_desc;
ALTER TABLE poll_menu RENAME TO mos_poll_menu;
ALTER TABLE queue RENAME TO mos_queue;
ALTER TABLE session RENAME TO mos_session;
ALTER TABLE stories RENAME TO mos_stories;
ALTER TABLE system RENAME TO mos_system;
ALTER TABLE users RENAME TO mos_users;

#
# Rename category id column to be consistent
#

ALTER TABLE `mos_articles` CHANGE `secid` `catid` INT( 11 ) DEFAULT '0' NOT NULL; 
ALTER TABLE `mos_stories` CHANGE `topic` `catid` INT( 11 ) DEFAULT '1' NOT NULL; 
ALTER TABLE `mos_faqcont` CHANGE `faqid` `catid` INT( 11 ) DEFAULT '0' NOT NULL; 
ALTER TABLE `mos_links` CHANGE `cid` `catid` INT( 11 ) DEFAULT '0' NOT NULL;
#
# Add type column to banner 
#
ALTER TABLE `mos_banner` ADD `type` VARCHAR( 10 ) AFTER `cid` ;
ALTER TABLE `mos_bannerfinish` ADD `type` VARCHAR( 10 ) NOT NULL AFTER `cid` ;

#
# Add Access Restriction fields/tables
#
CREATE TABLE mos_groups (
  id tinyint(3) unsigned NOT NULL default '0',
  name varchar(50) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

INSERT INTO mos_groups VALUES (0, 'Public');
INSERT INTO mos_groups VALUES (1, 'Registered');
INSERT INTO mos_groups VALUES (2, 'Special');

ALTER TABLE mos_categories ADD access tinyint(3) unsigned NOT NULL default '0';
ALTER TABLE mos_components ADD access tinyint(3) unsigned NOT NULL default '0';
ALTER TABLE mos_stories ADD access tinyint(3) unsigned NOT NULL default '0';
ALTER TABLE mos_menu ADD access tinyint(3) unsigned NOT NULL default '0';
ALTER TABLE mos_session ADD gid tinyint(3) unsigned NOT NULL default '0';
ALTER TABLE mos_users ADD gid tinyint(3) unsigned NOT NULL default '1';
ALTER TABLE `mos_stories` ADD `author` VARCHAR( 50 ) AFTER `time` ;
#
# Move mainmenu into components table
#
INSERT INTO mos_components VALUES (80,'Main Menu',1,'left',0,'00:00:00',1,'','main_menu',0,0);
ALTER TABLE mos_links ADD description varchar(200) NOT NULL default '';

DROP TABLE IF EXISTS mos_newsfeedslinks;
CREATE TABLE `mos_newsfeedslinks` (
  `categoryid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `inuse` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `inuse` (`inuse`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_newsfeedslinks`
#

INSERT INTO mos_newsfeedslinks VALUES (12,1,'Linux Today','http://linuxtoday.com/backend/my-netscape.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (1,2,'Internet:Business News','http://headlines.internet.com/internetnews/bus-news/news.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (6,3,'Web Developer News','http://headlines.internet.com/internetnews/wd-news/news.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (12,4,'Linux Central:New Products','http://linuxcentral.com/backend/lcnew.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (12,5,'Linux Central:Best Selling','http://linuxcentral.com/backend/lcbestns.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (12,6,'Linux Central:Daily Specials','http://linuxcentral.com/backend/lcspecialns.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (8,7,'BBC: UK News','http://www.bbc.co.uk/syndication/feeds/news/ukfs_news/uk/rss091.xml','',0);
INSERT INTO mos_newsfeedslinks VALUES (12,8,'BBC: Technology','http://www.bbc.co.uk/syndication/feeds/news/ukfs_news/technology/rss091.xml','',0);
INSERT INTO mos_newsfeedslinks VALUES (11,9,'NHL','http://www.sportingnews.com/klip/foods/sportingNewsNHL.food','',0);
INSERT INTO mos_newsfeedslinks VALUES (11,10,'NASCAR','http://www.sportingnews.com/klip/foods/sportingNewsNASCAR.food','',0);
INSERT INTO mos_newsfeedslinks VALUES (11,11,'NFL','http://www.sportingnews.com/klip/foods/sportingNewsNFL.food','',0);
INSERT INTO mos_newsfeedslinks VALUES (11,12,'NBA','http://www.sportingnews.com/klip/foods/sportingNewsNBA.food','',0);
INSERT INTO mos_newsfeedslinks VALUES (6,13,'Security Forums','http://www.security-forums.com/klip/content_feed.php','',0);
INSERT INTO mos_newsfeedslinks VALUES (4,14,'Internet:Finance News','http://headlines.internet.com/internetnews/fina-news/news.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (15,15,'BBC: World News','http://www.bbc.co.uk/syndication/feeds/news/ukfs_news/world/rss091.xml','',0);
INSERT INTO mos_newsfeedslinks VALUES (9,16,'Space.com','http://myrss.com/f/s/p/space99znm12.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (7,17,'Amazon : DVD Releases','http://myrss.com/f/a/m/amazon102Minus3289784Minus3662556N6f8pb3.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (4,18,'Bloomberg','http://myrss.com/f/b/l/bloombergH8n6k63.rss','',1);

