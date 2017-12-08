# Mambo Open Source v4.012 RC4 MySQL-Dump
# http://www.mamboserver.com
#
# Generation Time: Feb 27, 2003 at 13:58
# --------------------------------------------------------

#
# Table structure for table `mos_articles`
#
DROP TABLE IF EXISTS mos_articles;
CREATE TABLE `mos_articles` (
  `artid` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `userID` int(11) NOT NULL default '0',
  `author` varchar(50) default NULL,
  `content` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `counter` int(11) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time NOT NULL default '00:00:00',
  `editor` varchar(50) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`artid`),
  KEY `show` (`artid`,`published`,`catid`),
  KEY `listsections` (`catid`,`approved`,`published`,`archived`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_articles`
#

INSERT INTO mos_articles VALUES (1,2,'Mambo - The portal engine for the rest of us',0,'Admin','<P>If you\'ve read anything at all about portals, you\'ll probably know at least three things: Portals are the most exciting way to do business, Portals can be really, I mean <I>really</I>, complicated and lastly Portals are absolutely, outrageously, often <I>unaffordably</I> expensive. </P><IMG hspace=6 src=\"images/stories/mambositeserver.gif\" align=right> 
<P>Mambo Open Source is set to change all that ... Mambo Site server is different from the normal models for portal software. For a start, it\'s not complicated. Mambo has been developed for the masses. It\'s licensed under GPL, easy to install and administer and reliable. Mambo doesn\'t even require the user or administrator of the system to know HTML to operate it once it\'s up and running. 
<P>
<H4><FONT color=ff6600>Mambo features:</FONT></H4>
<UL>&nbsp; 
<LI>Completely database driven site engine using PHP/MySQL&nbsp; 
<LI>Security module for multi-level user/administrator logins 
<LI>News, products or services sections fully editable and manageable 
<LI>Topics sections can be added to by contributing authors 
<LI>Fully customisable layouts including left, center and right menu boxes 
<LI>Browser upload of images to your own library for use anywhere in the site 
<LI>Dynamic Forum/Poll/Voting booth for on-the-spot results 
<LI>Runs on Linux, FreeBSD, MacOSX server, Solaris, AIX, SCO, WinNT, Win2K&nbsp; 
<P></P></LI></UL>
<H4><FONT color=ff6600>Extensive Administration:</FONT></H4>
<UL>
<LI>Change order of objects including news, FAQ\'s, articles etc. 
<LI>Random Newsflash generator 
<LI>Remote author submission module for News, Articles, FAQ\'s and Links 
<LI>Object hierarchy - as many sections, departments, divisions and pages as you want 
<LI>Image library - now store all you GIF\'s and JPEG\'s online for easy use 
<LI>Automatic Path-Finder. Place a picture and let Mambo fix the link 
<LI>News feed manager. Choose from over 360 news feeds from around the world 
<LI>Archive manager. Put your old articles into cold storage rather than throw them out 
<LI>Email-a-friend and Print-format&nbsp;for every story and article 
<LI>In-line Text editor similar to Word Pad 
<LI>User editable look and feel 
<LI>Polls/Surveys - Now put a different one on each page 
<LI>Layout preview. See how it looks before going live 
<LI>Banner manager. Make money out of your site</LI></UL>','2003-02-18',0,1,0,1,0,'00:00:00','',1);
INSERT INTO mos_articles VALUES (2,5,'Another article would go here',0,'Admin','And this is where the content would go','2003-02-18',0,1,0,1,0,'00:00:00','',1);
# --------------------------------------------------------

#
# Table structure for table `mos_banner`
#
DROP TABLE IF EXISTS mos_banner;
CREATE TABLE `mos_banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default 'banner',
  `name` varchar(50) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_banner`
#

INSERT INTO mos_banner VALUES (1,1,'banner','Ka-Ching',0,99,0,'ka-chingBanner.gif','http://www.miro.com.au','2003-01-01 16:12:55',1,0,'00:00:00','');
INSERT INTO mos_banner VALUES (2,1,'banner','Mambo2002',0,85,0,'Mambo2002Banner.gif','www.miro.com.au','2003-01-01 15:20:37',1,0,'00:00:00','');
# --------------------------------------------------------

#
# Table structure for table `mos_bannerclient`
#
DROP TABLE IF EXISTS mos_bannerclient;
CREATE TABLE `mos_bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_bannerclient`
#

INSERT INTO mos_bannerclient VALUES (1,'Miro International Pty. Limited','Administrator','admin@miro.com.au','',0,'00:00:00','');
# --------------------------------------------------------

#
# Table structure for table `mos_bannerfinish`
#
DROP TABLE IF EXISTS mos_bannerfinish;
CREATE TABLE `mos_bannerfinish` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `impressions` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(50) NOT NULL default '',
  `datestart` datetime default NULL,
  `dateend` datetime default NULL,
  PRIMARY KEY  (`bid`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_bannerfinish`
#

# --------------------------------------------------------

#
# Table structure for table `mos_categories`
#
DROP TABLE IF EXISTS mos_categories;
CREATE TABLE `mos_categories` (
  `categoryid` int(11) NOT NULL auto_increment,
  `categoryname` text NOT NULL,
  `categoryimage` varchar(50) default NULL,
  `section` varchar(20) NOT NULL default '',
  `image_position` varchar(20) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time NOT NULL default '00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`categoryid`),
  KEY `articles` (`section`,`published`,`access`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_categories`
#

INSERT INTO mos_categories VALUES (1,'My News','','News','',1,0,'00:00:00','',0,0);
INSERT INTO mos_categories VALUES (2,'My Articles' ,'','Articles','',1,0,'00:00:00','',0,0);
INSERT INTO mos_categories VALUES (4,'My Web Links','','Weblinks','',1,0,'00:00:00','',0,0);
INSERT INTO mos_categories VALUES (3,'My FAQ','','Faq','',1,0,'00:00:00','',0,0);
INSERT INTO mos_categories VALUES (5,'More Articles','','Articles','',1,0,'00:00:00','',0,0);
INSERT INTO mos_categories VALUES (6,'More News','','News','',1,0,'00:00:00','',0,0);
INSERT INTO mos_categories VALUES (7,'More Web Links','','Weblinks','',1,0,'00:00:00','',0,0);
INSERT INTO mos_categories VALUES (8,'More FAQ','','Faq','',1,0,'00:00:00','',0,0);
# --------------------------------------------------------

#
# Table structure for table `mos_component_module`
#
DROP TABLE IF EXISTS mos_component_module;
CREATE TABLE `mos_component_module` (
  `id` int(4) NOT NULL auto_increment,
  `content` text NOT NULL,
  `componentid` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_component_module`
#

# --------------------------------------------------------

#
# Table structure for table `mos_components`
#
DROP TABLE IF EXISTS mos_components;
CREATE TABLE `mos_components` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `ordering` tinyint(4) NOT NULL default '0',
  `position` varchar(10) default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `publish` tinyint(1) NOT NULL default '0',
  `editor` varchar(50) default NULL,
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `publish` (`publish`,`access`),
  KEY `newsfeeds` (`module`,`publish`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_components`
#

INSERT INTO mos_components VALUES (1,'Contributing authors Login ...',2,'left',0,'00:00:00',1,'','login',0,0);
INSERT INTO mos_components VALUES (2,'Surveys/Polls',1,'right',0,'00:00:00',1,'','survey',0,0);
INSERT INTO mos_components VALUES (3,'Todays\' Newsfeeds',3,'left',0,'00:00:00',0,'','newsfeeds',3,0);
INSERT INTO mos_components VALUES (4,'Past Articles',4,'right',0,'00:00:00',1,'','articlearchive',0,0);
INSERT INTO mos_components VALUES (5,'Past News',5,'right',0,'00:00:00',1,'','newsarchive',0,0);
INSERT INTO mos_components VALUES (6,'User Menu',3,'left',0,'00:00:00',1,'','usermenu',0,0);
INSERT INTO mos_components VALUES (7,'Who\'s online',4,'left',0,'00:00:00',1,'','whos_online',0,0);
INSERT INTO mos_components VALUES (8,'Main Menu - without categories',1,'left',0,'00:00:00',1,'','main_menu',0,0);
INSERT INTO mos_components VALUES (9,'Main Menu - with categories',1,'left',0,'00:00:00',0,'','main_menu2',0,0);
# --------------------------------------------------------

#
# Table structure for table `mos_contact_details`
#
DROP TABLE IF EXISTS mos_contact_details;
CREATE TABLE `mos_contact_details` (
  `id` int(11) NOT NULL default '1',
  `name` varchar(100) NOT NULL default '',
  `ACN` varchar(20) default NULL,
  `address` text,
  `suburb` varchar(50) default NULL,
  `state` varchar(20) default NULL,
  `country` varchar(50) default NULL,
  `postcode` varchar(10) default NULL,
  `telephone` varchar(25) default NULL,
  `fax` varchar(25) default NULL,
  `email_to` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_contact_details`
#

INSERT INTO mos_contact_details VALUES (1,'Your Name Here','','','','','','','','','your_email@some-address.com');
# --------------------------------------------------------

#
# Table structure for table `mos_counter`
#
DROP TABLE IF EXISTS mos_counter;
CREATE TABLE `mos_counter` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(25) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `count` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_counter`
#

INSERT INTO mos_counter VALUES (1,'browser','Netscape',0);
INSERT INTO mos_counter VALUES (2,'browser','MSIE',0);
INSERT INTO mos_counter VALUES (3,'browser','Unknown',0);
INSERT INTO mos_counter VALUES (4,'OS','Windows',0);
INSERT INTO mos_counter VALUES (5,'OS','Mac',0);
INSERT INTO mos_counter VALUES (6,'OS','Unknown',0);
INSERT INTO mos_counter VALUES (7,'OS','Linux',0);
INSERT INTO mos_counter VALUES (8,'OS','FreeBSD',0);
INSERT INTO mos_counter VALUES (9,'browser','Lynx',0);
# --------------------------------------------------------

#
# Table structure for table `mos_faqcont`
#
DROP TABLE IF EXISTS mos_faqcont;
CREATE TABLE `mos_faqcont` (
  `artid` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `content` text NOT NULL,
  `counter` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time NOT NULL default '00:00:00',
  `editor` varchar(50) NOT NULL default '',
  `archived` tinyint(1) NOT NULL default '0',
  `ordering` int(11) default NULL,
  `approved` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`artid`),
  KEY `catid` (`catid`,`published`,`archived`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_faqcont`
#

INSERT INTO mos_faqcont VALUES (1,3,'My First Question','The answer would go here',2,1,0,'00:00:00','',0,1,1);
INSERT INTO mos_faqcont VALUES (2,8,'My Second Question','The answer would go here',2,1,0,'00:00:00','',0,1,1);
# --------------------------------------------------------

#
# Table structure for table `mos_groups`
#
DROP TABLE IF EXISTS mos_groups;
CREATE TABLE `mos_groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_groups`
#

INSERT INTO mos_groups VALUES (0,'Public');
INSERT INTO mos_groups VALUES (1,'Registered');
INSERT INTO mos_groups VALUES (2,'Special');
# --------------------------------------------------------

#
# Table structure for table `mos_links`
#
DROP TABLE IF EXISTS mos_links;
CREATE TABLE `mos_links` (
  `lid` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `description` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time NOT NULL default '00:00:00',
  `editor` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) default '1',
  PRIMARY KEY  (`lid`),
  KEY `catid` (`catid`,`published`,`archived`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_links`
#

INSERT INTO mos_links VALUES (1,4,0,'Miro International Pty Ltd','http://www.miro.com.au','Where Mambo was born','2003-02-18 11:32:45',0,1,0,'00:00:00','',0,0,1);
INSERT INTO mos_links VALUES (2,4,0,'Mambo Open Source Project','http://www.mamboserver.com','Where Mambo lives since leaving home', '2003-02-18 11:33:24',0,1,0,'00:00:00','',0,0,1);
INSERT INTO mos_links VALUES (3,7,0,'php.net','http://www.php.net','The language that Mambo is developed in', '2003-02-18 11:33:24',0,1,0,'00:00:00','',0,0,1);

# --------------------------------------------------------

#
# Table structure for table `mos_mambo_modules`
#
DROP TABLE IF EXISTS mos_mambo_modules;
CREATE TABLE `mos_mambo_modules` (
  `moduleid` int(11) NOT NULL auto_increment,
  `modulename` varchar(50) NOT NULL default '',
  `modulelink` varchar(50) default NULL,
  `menuid` int(4) default NULL,
  PRIMARY KEY  (`moduleid`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_mambo_modules`
#

INSERT INTO mos_mambo_modules VALUES (1,'Story','index.php',1);
INSERT INTO mos_mambo_modules VALUES (2,'Stories List','index.php?option=news',2);
INSERT INTO mos_mambo_modules VALUES (3,'Articles','index.php?option=articles',3);
INSERT INTO mos_mambo_modules VALUES (4,'Web Links','index.php?option=weblinks',4);
INSERT INTO mos_mambo_modules VALUES (5,'FAQ','index.php?option=faq',5);
INSERT INTO mos_mambo_modules VALUES (6,'Contact Us','index.php?option=contact',6);
# --------------------------------------------------------

#
# Table structure for table `mos_menu`
#
DROP TABLE IF EXISTS mos_menu;
CREATE TABLE `mos_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(25) default NULL,
  `name` varchar(25) default NULL,
  `link` text,
  `contenttype` varchar(10) default NULL,
  `inuse` tinyint(1) NOT NULL default '0',
  `componentid` int(11) default NULL,
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`inuse`,`access`),
  KEY `menutype` (`menutype`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_menu`
#

INSERT INTO mos_menu VALUES (1,'mainmenu','Home','index.php','mambo',1,0,0,1,0,'00:00:00','',1,0,0);
INSERT INTO mos_menu VALUES (2,'mainmenu','News','index.php?option=news','mambo',1,0,0,2,0,'00:00:00','',2,0,0);
INSERT INTO mos_menu VALUES (3,'mainmenu','Articles','index.php?option=articles','mambo',1,0,0,3,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (4,'mainmenu','Web Links','index.php?option=weblinks','mambo',1,0,0,4,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (5,'mainmenu','FAQ','index.php?option=faq','mambo',1,0,0,5,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (6,'mainmenu','Contact Us','index.php?option=contact','mambo',1,0,0,6,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (7,'usermenu','Your Details','index.php?option=user&op=UserDetails','',0,0,0,1,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (8,'usermenu','Submit Article','index.php?option=user&op=UserArticle','',0,0,0,3,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (9,'usermenu','Logout','index.php?option=logout','',0,0,0,6,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (26,'usermenu','Submit FAQ','index.php?option=user&op=UserFAQ','',0,0,0,4,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (27,'usermenu','Submit Weblink','index.php?option=user&op=UserLink','',0,0,0,5,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (28,'usermenu','Submit News','index.php?option=user&op=UserNews','',0,0,0,2,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (49,'mainmenu','Second Level','','typed',1,48,2,2,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (48,'mainmenu','First Level','','typed',1,47,1,1,0,'00:00:00','',0,0,0);
INSERT INTO mos_menu VALUES (47,'mainmenu','My category','','typed',1,0,0,7,0,'00:00:00','',0,0,0);
# --------------------------------------------------------

#
# Table structure for table `mos_menucontent`
#
DROP TABLE IF EXISTS mos_menucontent;
CREATE TABLE `mos_menucontent` (
  `mcid` int(11) NOT NULL auto_increment,
  `menuid` int(11) NOT NULL default '0',
  `content` text NOT NULL,
  `heading` varchar(100) default NULL,
  PRIMARY KEY  (`mcid`),
  KEY `menuid` (`menuid`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_menucontent`
#

INSERT INTO mos_menucontent VALUES (25,48,'This page is on the first level of navigation under the home page.','First level of navigation');
INSERT INTO mos_menucontent VALUES (26,49,'This is the second page in this sub-category<BR>
<IMG SRC=images/stories/messy_trashcan.jpg ALIGN=left HSPACE=6><BR>
<IMG SRC=images/stories/messy_trashcan.jpg ALIGN=left HSPACE=6><BR>','second level of navigation');
INSERT INTO mos_menucontent VALUES (24,47,'<IMG SRC=images/stories/hour_glass.jpg ALIGN=left HSPACE=6>This is where you would place your own category. This page is a primary level navigation page and can have unlimited number of sub-categories and sub-pages.','My Category Page');
# --------------------------------------------------------

#
# Table structure for table `mos_newsfeedscategory`
#
DROP TABLE IF EXISTS mos_newsfeedscategory;
CREATE TABLE `mos_newsfeedscategory` (
  `id` int(11) NOT NULL auto_increment,
  `category` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_newsfeedscategory`
#

INSERT INTO mos_newsfeedscategory VALUES (1,'Business: general');
INSERT INTO mos_newsfeedscategory VALUES (2,'Companies');
INSERT INTO mos_newsfeedscategory VALUES (3,'Entertainment');
INSERT INTO mos_newsfeedscategory VALUES (4,'Finance');
INSERT INTO mos_newsfeedscategory VALUES (5,'Industry');
INSERT INTO mos_newsfeedscategory VALUES (6,'Internet');
INSERT INTO mos_newsfeedscategory VALUES (7,'Lifestyle');
INSERT INTO mos_newsfeedscategory VALUES (8,'Regional');
INSERT INTO mos_newsfeedscategory VALUES (9,'Science');
INSERT INTO mos_newsfeedscategory VALUES (10,'Society');
INSERT INTO mos_newsfeedscategory VALUES (11,'Sports');
INSERT INTO mos_newsfeedscategory VALUES (12,'Technology');
INSERT INTO mos_newsfeedscategory VALUES (13,'US regional');
INSERT INTO mos_newsfeedscategory VALUES (14,'Business: media');
INSERT INTO mos_newsfeedscategory VALUES (15,'Top Stories');
# --------------------------------------------------------

#
# Table structure for table `mos_newsfeedslinks`
#
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

INSERT INTO mos_newsfeedslinks VALUES (6,1,'Linux Today','http://linuxtoday.com/backend/my-netscape.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (1,2,'Internet:Business News','http://headlines.internet.com/internetnews/bus-news/news.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (6,3,'Web Developer News','http://headlines.internet.com/internetnews/wd-news/news.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (6,4,'Linux Central:New Products','http://linuxcentral.com/backend/lcnew.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (6,5,'Linux Central:Best Selling','http://linuxcentral.com/backend/lcbestns.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (6,6,'Linux Central:Daily Specials','http://linuxcentral.com/backend/lcspecialns.rdf','',0);
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
INSERT INTO mos_newsfeedslinks VALUES (4,18,'Bloomberg','http://myrss.com/f/b/l/bloombergH8n6k63.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (3,19,'Motley Fool','http://www.fool.com/xml/foolnews_rss091.xml','',0);
INSERT INTO mos_newsfeedslinks VALUES (12,20,'PDA Buzz','http://www.pdabuzz.com/netscape.txt','',0);
INSERT INTO mos_newsfeedslinks VALUES (3,21,'Digital Theatre','http://www.dtheatre.com/backend.php?xml=yes','',0);
INSERT INTO mos_newsfeedslinks VALUES (7,22,'Cars Everything','http://www.carseverything.com/data/headlines.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (9,23,'Beyond 2000','http://www.beyond2000.com/b2k.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (10,24,'The Cancer Letter','http://www.cancerletter.com/cancerletter.xml','',0);
INSERT INTO mos_newsfeedslinks VALUES (4,25,'Asia Street Intelligence Ezine','http://www.apmforum.com/channel.xml','',0);
INSERT INTO mos_newsfeedslinks VALUES (7,26,'Car Survey','http://www.carsurvey.org/carsurvey.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (7,27,'Beer News','http://realbeer.com/rdf/realbeernews.rdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (9,28,'NASA\'s Earth Observatory','http://earthobservatory.nasa.gov/eo.rss','',0);
INSERT INTO mos_newsfeedslinks VALUES (6,29,'BSD Today','http://www.bsdtoday.com/backend/bt.rdf','',1);
INSERT INTO mos_newsfeedslinks VALUES (2,30,'Company News','http://www.newsisfree.com/HPE/xml/feeds/07/1107.xml','',0);
INSERT INTO mos_newsfeedslinks VALUES (7,31,'Garden Guides','http://www.gardenguides.com/ggrdf.cdf','',0);
INSERT INTO mos_newsfeedslinks VALUES (11,32,'Cricket','http://www.newsisfree.com/HPE/xml/feeds/24/1324.xml','',0);

# --------------------------------------------------------

#
# Table structure for table `mos_newsflash`
#
DROP TABLE IF EXISTS mos_newsflash;
CREATE TABLE `mos_newsflash` (
  `newsflashID` int(11) NOT NULL auto_increment,
  `flashtitle` varchar(50) NOT NULL default '',
  `flashcontent` text NOT NULL,
  `showflash` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) default NULL,
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`newsflashID`,`showflash`),
  KEY `showflash` (`showflash`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_newsflash`
#

INSERT INTO mos_newsflash VALUES (1,'Newsflash 1','Mambo 4.0 now comes complete with a brand new complete site search facility.  Also, changes have been made so that customizing the look and feel for your site is now even easier.',1,0,'00:00:00','');
INSERT INTO mos_newsflash VALUES (2,'Newsflash 2','Yesterday all servers in the U.S. went out on strike in a bid to get more RAM and better CPU\'s. A spokes \'puter said that the need for better RAM was due to some fool increasing the front-side bus speed. In future, busses will be told to slow down in residential motherboards.',1,0,'00:00:00','');
INSERT INTO mos_newsflash VALUES (3,'Newsflash 3','Mambo 4.0 comes with so many new features including, a theme manager and 4 new themes, a custom page module installer and 4 custom page modules.  Not only that, Mambo 4.0 has had a complete cosmetic overhaul.',1,0,'00:00:00','');
# --------------------------------------------------------

#
# Table structure for table `mos_poll_data`
#
DROP TABLE IF EXISTS mos_poll_data;
CREATE TABLE `mos_poll_data` (
  `pollid` int(4) NOT NULL default '0',
  `optionText` text NOT NULL,
  `optionCount` int(11) NOT NULL default '0',
  `voteid` int(11) NOT NULL default '0',
  KEY `pollid` (`pollid`,`optionText`(1))
) TYPE=MyISAM;

#
# Dumping data for table `mos_poll_data`
#

INSERT INTO mos_poll_data VALUES (14,'',0,12);
INSERT INTO mos_poll_data VALUES (14,'',0,11);
INSERT INTO mos_poll_data VALUES (14,'',0,10);
INSERT INTO mos_poll_data VALUES (14,'',0,9);
INSERT INTO mos_poll_data VALUES (14,'',0,8);
INSERT INTO mos_poll_data VALUES (14,'',0,7);
INSERT INTO mos_poll_data VALUES (14,'My dog ran away with the README ...',0,6);
INSERT INTO mos_poll_data VALUES (14,'I had no idea and got my friend to do it',0,5);
INSERT INTO mos_poll_data VALUES (14,'I had to install extra server stuff',0,4);
INSERT INTO mos_poll_data VALUES (14,'Not straight-forward but I worked it out',0,3);
INSERT INTO mos_poll_data VALUES (14,'Reasonably easy',0,2);
INSERT INTO mos_poll_data VALUES (14,'Absolutely simple',0,1);
# --------------------------------------------------------

#
# Table structure for table `mos_poll_date`
#
DROP TABLE IF EXISTS mos_poll_date;
CREATE TABLE `mos_poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_poll_date`
#

# --------------------------------------------------------

#
# Table structure for table `mos_poll_desc`
#
DROP TABLE IF EXISTS mos_poll_desc;
CREATE TABLE `mos_poll_desc` (
  `pollID` int(11) NOT NULL auto_increment,
  `pollTitle` varchar(100) NOT NULL default '',
  `voters` mediumint(9) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time NOT NULL default '00:00:00',
  `editor` varchar(50) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`pollID`,`published`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_poll_desc`
#

INSERT INTO mos_poll_desc VALUES (14,'<FONT color=ff6600><b>This Mambo installation was ....</b></font>',0,0,'00:00:00','',1);
# --------------------------------------------------------

#
# Table structure for table `mos_poll_menu`
#
DROP TABLE IF EXISTS mos_poll_menu;
CREATE TABLE `mos_poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_poll_menu`
#

INSERT INTO mos_poll_menu VALUES (14,1);
INSERT INTO mos_poll_menu VALUES (14,4);
# --------------------------------------------------------

#
# Table structure for table `mos_queue`
#
DROP TABLE IF EXISTS mos_queue;
CREATE TABLE `mos_queue` (
  `qid` smallint(5) unsigned NOT NULL auto_increment,
  `uid` mediumint(9) NOT NULL default '0',
  `uname` varchar(40) NOT NULL default '',
  `subject` varchar(100) NOT NULL default '',
  `story` text,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `topic` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`qid`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_queue`
#

# --------------------------------------------------------

#
# Table structure for table `mos_session`
#
DROP TABLE IF EXISTS mos_session;
CREATE TABLE `mos_session` (
  `username` varchar(50) default NULL,
  `time` varchar(14) default NULL,
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default NULL,
  `usertype` varchar(50) default NULL,
  `gid` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) TYPE=MyISAM;

#
# Table structure for table `mos_stories`
#
DROP TABLE IF EXISTS mos_stories;
CREATE TABLE `mos_stories` (
  `sid` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `author` varchar(50) default NULL,
  `introtext` text NOT NULL,
  `fultext` text,
  `counter` mediumint(8) unsigned default '0',
  `catid` int(11) NOT NULL default '1',
  `hits` int(11) default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `newsimage` varchar(40) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  `image_position` varchar(10) NOT NULL default '',
  `ordering` int(11) default '0',
  `frontpage` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`sid`),
  KEY `body` (`archived`,`published`,`frontpage`),
  KEY `news` (`catid`,`published`,`frontpage`,`archived`),
  KEY `published` (`published`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_stories`
#

INSERT INTO mos_stories VALUES (1,'Welcome to Mambo','2003-02-18 09:25:58','Admin','<P>If you\'ve read anything at all about portals, you\'ll probably know at least three things: Portals are the most exciting way to do business, Portals can be really, I mean <I>really</I>, complicated and lastly Portals are absolutely, outrageously, often <I>unaffordably</I> expensive. </P>
<P>Mambo Open Source is set to change all that ... Mambo Site server is different from the normal models for portal software. For a start, it\'s not complicated. Mambo has been developed for the masses. It\'s licensed under GPL, easy to install and administer and reliable. Mambo doesn\'t even require the user or administrator of the system to know HTML to operate it once it\'s up and running.','<H4><FONT color=ff6600>Mambo features:</FONT></H4>
<UL>
<LI>Completely database driven site engine using PHP/MySQL 
<LI>Security module for multi-level user/administrator logins 
<LI>News, products or services sections fully editable and manageable 
<LI>Topics sections can be added to by contributing authors 
<LI>Fully customisable layouts including left, center and right menu boxes 
<LI>Browser upload of images to your own library for use anywhere in the site 
<LI>Dynamic Forum/Poll/Voting booth for on-the-spot results 
<LI>Runs on Linux, FreeBSD, MacOSX server, Solaris, AIX, SCO, WinNT, Win2K 
<P></P></LI></UL>
<H4>Extensive Administration:</H4>
<UL>
<LI>Change order of objects including news, FAQ\'s, articles etc. 
<LI>Random Newsflash generator 
<LI>Remote author submission module for News, Articles, FAQ\'s and Links 
<LI>Object hierarchy - as many sections, departments, divisions and pages as you want 
<LI>Image library - store all your PNG\'s, PDF\'s, DOC\'s, XLS\'s, GIF\'s and JPEG\'s online for easy use 
<LI>Automatic Path-Finder. Place a picture and let Mambo fix the link 
<LI>News feed manager. Choose from over 360 news feeds from around the world 
<LI>Archive manager. Put your old articles into cold storage rather than throw them out 
<LI>Email-a-friend and Print-format for every story and article 
<LI>In-line Text editor similar to Word Pad 
<LI>User editable look and feel 
<LI>Polls/Surveys - Now put a different one on each page 
<LI>Custom Page Modules.  Download custom page modules to spice up your site 
<LI>Theme Manager.  Download themes and implement them in seconds 
<LI>Layout preview. See how it looks before going live 
<LI>Banner manager. Make money out of your site</LI></UL>',0,1,0,0,'mambositeserver.gif',1,0,'00:00:00','','left',1,1,1,0);
INSERT INTO mos_stories VALUES (2,'Welcome to Mambo','2003-02-18 09:25:58','Admin','<P>If you\'ve read anything at all about portals, you\'ll probably know at least three things: Portals are the most exciting way to do business, Portals can be really, I mean <I>really</I>, complicated and lastly Portals are absolutely, outrageously, often <I>unaffordably</I> expensive. </P>
<P>Mambo Open Source is set to change all that ... Mambo Site server is different from the normal models for portal software. For a start, it\'s not complicated. Mambo has been developed for the masses. It\'s licensed under GPL, easy to install and administer and reliable. Mambo doesn\'t even require the user or administrator of the system to know HTML to operate it once it\'s up and running.','<H4><FONT color=ff6600>Mambo features:</FONT></H4>
<UL>
<LI>Completely database driven site engine using PHP/MySQL 
<LI>Security module for multi-level user/administrator logins 
<LI>News, products or services sections fully editable and manageable 
<LI>Topics sections can be added to by contributing authors 
<LI>Fully customisable layouts including left, center and right menu boxes 
<LI>Browser upload of images to your own library for use anywhere in the site 
<LI>Dynamic Forum/Poll/Voting booth for on-the-spot results 
<LI>Runs on Linux, FreeBSD, MacOSX server, Solaris, AIX, SCO, WinNT, Win2K 
<P></P></LI></UL>
<H4>Extensive Administration:</H4>
<UL>
<LI>Change order of objects including news, FAQ\'s, articles etc. 
<LI>Random Newsflash generator 
<LI>Remote author submission module for News, Articles, FAQ\'s and Links 
<LI>Object hierarchy - as many sections, departments, divisions and pages as you want 
<LI>Image library - store all your PNG\'s, PDF\'s, DOC\'s, XLS\'s, GIF\'s and JPEG\'s online for easy use 
<LI>Automatic Path-Finder. Place a picture and let Mambo fix the link 
<LI>News feed manager. Choose from over 360 news feeds from around the world 
<LI>Archive manager. Put your old articles into cold storage rather than throw them out 
<LI>Email-a-friend and Print-format for every story and article 
<LI>In-line Text editor similar to Word Pad 
<LI>User editable look and feel 
<LI>Polls/Surveys - Now put a different one on each page 
<LI>Custom Page Modules.  Download custom page modules to spice up your site 
<LI>Theme Manager.  Download themes and implement them in seconds 
<LI>Layout preview. See how it looks before going live 
<LI>Banner manager. Make money out of your site</LI></UL>',0,1,0,0,'mambositeserver.gif',1,0,'00:00:00','','left',1,0,1,0);
INSERT INTO mos_stories VALUES (3,'Another news story','2003-02-18 09:25:56','Admin','And the content would go here','',0,6,0,0,'',1,0,'00:00:00','','left',1,0,1,0);
# --------------------------------------------------------

#
# Table structure for table `mos_system`
#
DROP TABLE IF EXISTS mos_system;
CREATE TABLE `mos_system` (
  `id` int(11) NOT NULL default '0',
  `sitename` varchar(50) NOT NULL default '',
  `cur_theme` varchar(50) NOT NULL default '',
  `col_main` char(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_system`
#

INSERT INTO mos_system VALUES (0,'Mambo 4.0.12','mambobizz','1');
# --------------------------------------------------------

#
# Table structure for table `mos_users`
#
DROP TABLE IF EXISTS mos_users;
CREATE TABLE `mos_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`)
) TYPE=MyISAM;

#
# Dumping data for table `mos_users`
#

INSERT INTO mos_users VALUES (62,'Administrator','admin','','21232f297a57a5a743894a0e4a801fc3','superadministrator',0,0,1);
