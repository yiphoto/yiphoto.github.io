# --------------------------------------------------------
#
# Upgrade SQL for Mambo 3.0.7 -> Mambo 4.0.11 Stable
#
# --------------------------------------------------------
INSERT INTO counter VALUES (7, 'OS', 'Linux', 0);
INSERT INTO counter VALUES (8, 'OS', 'FreeBSD', 0);
INSERT INTO counter VALUES (9, 'browser', 'Lynx', 0);

# --------------------------------------------------------
#
# Table structure for table `system`
#
# -------------------------------------------------------- 
DROP TABLE IF EXISTS system;
CREATE TABLE system (
   id int(11) NOT NULL default '0',
   sitename varchar(50) NOT NULL default '',
   cur_theme varchar(50) NOT NULL default '',
   col_main char(1) NOT NULL default '1',
   PRIMARY KEY  (id)
 ) TYPE=MyISAM;
 
#
# Dumping data for table `system`
#
 
INSERT INTO system VALUES (0, 'Mambo 4.0.11 - Stable (December 2002)', 'mambodefault', '1');

ALTER TABLE `components` CHANGE `id` `id` INT( 11 ) DEFAULT '1' NOT NULL; 
ALTER TABLE `stories` ADD `author` VARCHAR( 50 ) AFTER `time` ;
ALTER TABLE `mos_banner` ADD `type` VARCHAR( 10 ) AFTER `cid` ;
ALTER TABLE `mos_bannerfinish` ADD `type` VARCHAR( 10 ) NOT NULL AFTER `cid` ;
