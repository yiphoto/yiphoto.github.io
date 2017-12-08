<?php
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	20-01-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: databaseAdmin.php
*
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");
require_once("classes/databaseAdmin.php");
$databaseAdmin = new databaseAdmin();

switch ($_GET['task']) {
	case "dbOptimize":
	$databaseAdmin->dbOptimize($database);
	break;

	case "doOptimize":
	$databaseAdmin->doOptimize($database,$_POST['tables']);
	break;

	case "dbAnalyze":
	$databaseAdmin->dbAnalyze($database);
	break;

	case "doAnalyze":
	$databaseAdmin->doAnalyze($database,$_POST['tables']);
	break;

	case "dbCheck":
	$databaseAdmin->dbCheck($database);
	break;

	case "doCheck":
	$databaseAdmin->doCheck($database,$_POST['tables']);
	break;

	case "dbRepair":
	$databaseAdmin->dbRepair($database);
	break;

	case "doRepair":
	$databaseAdmin->doRepair($database,$_POST['tables']);
	break;

	case "dbBackup":
	$databaseAdmin->dbBackup($database);
	break;

	case "doBackup":
	$databaseAdmin->doBackup($database,$_POST['tables'],$_POST['OutType'],$_POST['OutDest'],$_POST['toBackUp'],$_SERVER['HTTP_USER_AGENT'], $local_backup_path);
	break;

	case "dbRestore":
	$databaseAdmin->dbRestore($database, $local_backup_path);
	break;

	case "doRestore":
	$databaseAdmin->doRestore($database,$_POST['file'],$_FILES['upfile'],$local_backup_path);
	break;

	default:
	$databaseAdmin->dbStatus($database);
}
?>
