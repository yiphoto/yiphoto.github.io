# --------------------------------------------------------
#
# Upgrade SQL for Mambo 4.0.12 BETA 3 -> Mambo 4.0.12 RC4
#
# --------------------------------------------------------
ALTER TABLE `mos_links` ADD `description` VARCHAR( 200 ) NOT NULL AFTER `url` ;
ALTER TABLE `mos_banner` ADD `type` VARCHAR( 10 ) AFTER `cid` ;
ALTER TABLE `mos_bannerfinish` ADD `type` VARCHAR( 10 ) NOT NULL AFTER `cid` ;

INSERT INTO mos_components VALUES (9,'Main Menu - with categories',1,'left',0,'00:00:00',0,'','main_menu2',0,0);

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
