<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	27-11-2002
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: databaseAdmin.php
*	Developer: James C. Logan (nagolcj@hotmail.com)
*	Date: 12-02-2003
* 	Version #: 2.0.3
*	Comments:
**/

class databaseAdmin {
	function dbStatus($database) {
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th colspan=\"2\" class=\"articlehead\">Database Tables Status</th></tr>\n";
		echo "	<tr><td colspan=\"2\">&nbsp;<br>Looking for some information on the state of your tables or when you last checked them? This procedure provides key information on all tables defined to your database.<br>&nbsp;</td></tr>\n";
		$result = $database->openConnectionWithReturn("SHOW TABLE STATUS");
		while ($result2 = mysql_fetch_array($result, MYSQL_ASSOC)) {
			while (list($key, $value) = each ($result2)) {
				if ($key=="Name") {
					echo "	<tr><td colspan=\"2\" class=\"heading\" align=\"center\">$value</td></tr>\n";
				} else {
					echo "	<tr><td align=\"right\" width=\"50%\">$key</td><td width=\"50%\"> : $value</td></tr>\n";
				}
			}
			echo "	<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
		}
		echo "</table>\n";
		mysql_free_result($result);
	}
	
	function dbOptimize($database) {
		echo "<form action=\"index2.php?option=databaseAdmin&task=doOptimize\" method=\"post\">\n";
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th class=\"articlehead\">Database Tables Optimization</th></tr>\n";
		echo "	<tr><td><br>During the course of normal use, records can and will be deleted. Deleted records are maintained in a linked list and subsequent INSERT operations reuse old record positions. Running the Optimize Tables routine reclaims the unused space. It is recommended you run this procedure regularily to ensure the best possible performance.<br><br>While the Optimize Tables routine is executing, the original table is readable by other clients. Updates and writes to the table are stalled until the new table is ready. This is done in such a way that all updates are automatically redirected to the new table without any failed updates.<br><br>The Message Type returned should be one of status (normal), error, info, or warning. If a Message Type other than \"status\" and a Message of \"OK\" is returned, you may have to run a repair on the table. Read the Message carefully to determine if this is required.<br>&nbsp;</td></tr>\n";
		echo "	<tr>\n		<td align=\"center\">\n";
		echo "			<select name=\"tables[]\" size=\"10\" MULTIPLE>\n";
		echo "			<option value=\"all\" selected>All Mambo Tables\n";
		$result = $database->openConnectionWithReturn("SHOW TABLES");
		while ($result2 = mysql_fetch_row($result)) {
			echo "			<option value=\"$result2[0]\">$result2[0]\n";
		}
		mysql_free_result($result);
		echo "			</select>\n		</td>\n	</tr>\n	<tr>\n";
		echo "		<td align=\"center\">&nbsp;<br><input type=submit value=\"Optimize the Selected Tables\" class=\"button\"></td>\n";
		echo "	</tr>\n</table>\n</form>\n";
	}
	
	function doOptimize($database, $tables) {
		if (!$tables[0]) {
			dbOptimize($database);
			return;
		}
		if ($tables[0] == "all") {
			$tables = array();
			$result = $database->openConnectionWithReturn("SHOW TABLES");
			while ($result2 = mysql_fetch_row($result)) {
				list(,$tables[])=each($result2);
			}
			mysql_free_result($result);
		}
		$toOptimize = implode(",",$tables);
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th colspan=\"2\" class=\"articlehead\">Database Tables Optimization Results</th></tr>";
		echo "	<tr><td colspan=\"2\"><br>During the course of normal use, records can and will be deleted. Deleted records are maintained in a linked list and subsequent INSERT operations reuse old record positions. Running the Optimize Tables routine reclaims the unused space. It is recommended you run this procedure regularily to ensure the best possible performance.<br><br>While the Optimize Tables routine is executing, the original table is readable by other clients. Updates and writes to the table are stalled until the new table is ready. This is done in such a way that all updates are automatically redirected to the new table without any failed updates.<br><br>The Message Type returned should be one of status (normal), error, info, or warning. If a Message Type other than \"status\" and a Message of \"OK\" is returned, you may have to run a repair on the table. Read the Message carefully to determine if this is required.<br>&nbsp;</td></tr>\n";
		$result = $database->openConnectionWithReturn("OPTIMIZE TABLE " . $toOptimize);
		while ($result2 = mysql_fetch_array($result, MYSQL_ASSOC)) {
			while (list($key, $value) = each ($result2)) {
				if ($key=="Table") {
					echo "	<tr><td colspan=\"2\" class=\"heading\" align=\"center\">$value</td></tr>\n";
				} else {
					echo "	<tr><td align=\"right\" width=\"50%\">$key</td><td width=\"50%\" nowrap> : $value</td></tr>\n";
				}
			}
			echo "	<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
		}
		mysql_free_result($result);
		echo "</table>\n";
	}
	
	function dbAnalyze($database) {
		echo "<form action=\"index2.php?option=databaseAdmin&task=doAnalyze\" method=\"post\">\n";
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th class=\"articlehead\">Database Tables Analysis</th></tr>\n";
		echo "	<tr><td><br>Analyze and store the key distribution for the table. MySQL uses the stored key distribution to decide in which order tables should be joined when one does a join on something else than a constant. During the analysis the table is locked with a read lock.<br><br>If a Message Type other than \"status\" and a Message of \"OK\" is returned, you may have to run a repair on the table. Read the Message carefully to determine if this is required.<br>&nbsp;</td></tr>\n";
		echo "	<tr>\n		<td align=\"center\">\n";
		echo "			<select name=\"tables[]\" size=\"10\" MULTIPLE>\n";
		echo "			<option value=\"all\" selected>All Mambo Tables\n";
		$result = $database->openConnectionWithReturn("SHOW TABLES");
		while ($result2 = mysql_fetch_row($result)) {
			echo "			<option value=\"$result2[0]\">$result2[0]\n";
		}
		mysql_free_result($result);
		echo "			</select>\n		</td>\n	</tr>\n	<tr>\n";
		echo "		<td align=\"center\">&nbsp;<br><input type=submit value=\"Analyze the Selected Tables\" class=\"button\"></td>\n";
		echo "	</tr>\n</table>\n</form>\n";
	}
	
	function doAnalyze($database, $tables) {
		if (!$tables[0]) {
			$this->dbAnalyze($database);
			return;
		}
		if ($tables[0] == "all") {
			$result = $database->openConnectionWithReturn("SHOW TABLES");
			while ($result2 = mysql_fetch_row($result)) {
				$toAnalyze .= $result2[0] . ",";
			}
			mysql_free_result($result);
		} else {
			while (list(, $value) = each ($tables)) {
				$toAnalyze .= $value . ",";
			}

		}
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th colspan=\"2\" class=\"articlehead\">Database Tables Analysis Results</th></tr>";
		echo "	<tr><td colspan=\"2\"><br>Analyze and store the key distribution for the table. MySQL uses the stored key distribution to decide in which order tables should be joined when one does a join on something else than a constant. During the analysis the table is locked with a read lock.<br><br>If a Message Type other than \"status\" and a Message of \"OK\" is returned, you may have to run a repair on the table. Read the Message carefully to determine if this is required.<br>&nbsp;</td></tr>\n";
		$toAnalyze = rtrim($toAnalyze,",");
		$result = $database->openConnectionWithReturn("ANALYZE TABLE " . $toAnalyze);
		while ($result2 = mysql_fetch_array($result, MYSQL_ASSOC)) {
			while (list($key, $value) = each ($result2)) {
				if ($key=="Table") {
					echo "	<tr><td colspan=\"2\" class=\"heading\" align=\"center\">$value</td></tr>\n";
				} else {
					echo "	<tr><td align=\"right\" width=\"50%\">$key</td><td width=\"50%\" nowrap> : $value</td></tr>\n";
				}
			}
			echo "	<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
		}
		mysql_free_result($result);
		echo "</table>\n";
	}
	
	function dbCheck($database) {
		echo "<form action=\"index2.php?option=databaseAdmin&task=doCheck\" method=\"post\">\n";
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th class=\"articlehead\">Database Tables Check</th></tr>\n";
		echo "	<tr><td><br>This routine checks the selected table(s) for errors.<br><br>The Message Type returned should be one of status (normal), error, info, or warning. If a Message Type other than \"status\" and a Message of \"OK\" is returned, you may have to run a repair on the table. Read the Message carefully to determine if this is required.<br>&nbsp;</td></tr>\n";
		echo "	<tr>\n		<td align=\"center\">\n";
		echo "			<select name=\"tables[]\" size=\"10\" MULTIPLE>\n";
		echo "			<option value=\"all\" selected>All Mambo Tables\n";
		$result = $database->openConnectionWithReturn("SHOW TABLES");
		while ($result2 = mysql_fetch_row($result)) {
			echo "			<option value=\"$result2[0]\">$result2[0]\n";
		}
		mysql_free_result($result);
		echo "			</select>\n		</td>\n	</tr>\n	<tr>\n";
		echo "		<td align=\"center\">&nbsp;<br><input type=submit value=\"Check the Selected Tables\" class=\"button\"></td>\n";
		echo "	</tr>\n</table>\n</form>\n";
	}
	
	function doCheck($database, $tables) {
		if (!$tables[0]) {
			dbCheck($database);
			return;
		}
		if ($tables[0] == "all") {
			$result = $database->openConnectionWithReturn("SHOW TABLES");
			while ($result2 = mysql_fetch_row($result)) {
				$toCheck .= $result2[0] . ",";
			}
			mysql_free_result($result);
		} else {
			while (list(, $value) = each ($tables)) {
				$toCheck .= $value . ",";
			}
		}
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th colspan=\"2\" class=\"articlehead\">Database Tables Check Results</th></tr>";
		echo "	<tr><td colspan=\"2\"><br>This routine checks the selected table(s) for errors.<br><br>The Message Type returned should be one of status (normal), error, info, or warning. If a Message Type other than \"status\" and a Message of \"OK\" is returned, you may have to run a repair on the table. Read the Message carefully to determine if this is required.<br>&nbsp;</td></tr>\n";
		$toCheck = rtrim($toCheck,",");
		$result = $database->openConnectionWithReturn("CHECK TABLE " . $toCheck);
		while ($result2 = mysql_fetch_array($result, MYSQL_ASSOC)) {
			while (list($key, $value) = each ($result2)) {
				if ($key=="Table") {
					echo "	<tr><td colspan=\"2\" class=\"heading\" align=\"center\">$value</td></tr>\n";
				} else {
					echo "	<tr><td align=\"right\" width=\"50%\">$key</td><td width=\"50%\" nowrap> : $value</td></tr>\n";
				}
			}
			echo "	<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
		}
		mysql_free_result($result);
		echo "</table>\n";
	}
	
	function dbRepair($database) {
		echo "<form action=\"index2.php?option=databaseAdmin&task=doRepair\" method=\"post\">\n";
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th class=\"articlehead\">Database Tables Repair</th></tr>\n";
		echo "	<tr><td><br>If any of the regular diagnostic routines (Check, Analyze, or Optimize Tables) returns a Message other than \"OK\", this procedure can be used to attempt to correct the corrupted table.<br><br>The Message Type returned should be one of status (normal), error, info, or warning. If a Message Type other than \"status\" and a Message of \"OK\" is returned, you should try repairing the table with myisamchk -o, as Repair Tables does not yet implement all the options of myisamchk. Please refer to the documentation provided with your MySQL installation for further instructions.<br>&nbsp;</td></tr>\n";
		echo "	<tr>\n		<td align=\"center\">\n";
		echo "			<select name=\"tables[]\" size=\"10\" MULTIPLE>\n";
		echo "			<option value=\"all\" selected>All Mambo Tables\n";
		$result = $database->openConnectionWithReturn("SHOW TABLES");
		while ($result2 = mysql_fetch_row($result)) {
			echo "			<option value=\"$result2[0]\">$result2[0]\n";
		}
		mysql_free_result($result);
		echo "			</select>\n		</td>\n	</tr>\n	<tr>\n";
		echo "		<td align=\"center\">&nbsp;<br><input type=submit value=\"Repair the Selected Tables\" class=\"button\"></td>\n";
		echo "	</tr>\n</table>\n</form>\n";
	}
	
	function doRepair($database, $tables) {
		if (!$tables[0]) {
			dbRepair($database);
			return;
		}
		if ($tables[0] == "all") {
			$result = $database->openConnectionWithReturn("SHOW TABLES");
			while ($result2 = mysql_fetch_row($result)) {
				$toRepair .= $result2[0] . ",";
			}
			mysql_free_result($result);
		} else {
			while (list(, $value) = each ($tables)) {
				$toRepair .= $value . ",";
			}
		}
		echo "<table border=\"0\" align=\"center\" width=\"90%\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th colspan=\"2\" class=\"articlehead\">Database Tables Repair Results</th></tr>";
		echo "	<tr><td colspan=\"2\"><br>If any of the regular diagnostic routines (Check, Analyze, or Optimize Tables) returns a Message other than \"OK\", this procedure can be used to attempt to correct the corrupted table.<br><br>The Message Type returned should be one of status (normal), error, info, or warning. If a Message Type other than \"status\" and a Message of \"OK\" is returned, you should try repairing the table with myisamchk -o, as Repair Tables does not yet implement all the options of myisamchk. Please refer to the documentation provided with your MySQL installation for further instructions.<br>&nbsp;</td></tr>\n";
		$toRepair = rtrim($toRepair,",");
		$result = $database->openConnectionWithReturn("REPAIR TABLE " . $toRepair);
		while ($result2 = mysql_fetch_array($result, MYSQL_ASSOC)) {
			while (list($key, $value) = each ($result2)) {
				if ($key=="Table") {
					echo "	<tr><td colspan=\"2\" class=\"heading\" align=\"center\">$value</td></tr>\n";
				} else {
					echo "	<tr><td align=\"right\" width=\"50%\">$key</td><td width=\"50%\" nowrap> : $value</td></tr>\n";
				}
			}
			echo "	<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
		}
		mysql_free_result($result);
		echo "</table>\n";
	}
	
	function dbBackup($database) {
		echo "<form action=\"index2.php?option=databaseAdmin&task=doBackup\" method=\"post\">\n";
		echo "<table border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "	<tr><th class=\"articlehead\">Database Tables Backup</th></tr>\n";
		echo "	<tr>\n		<td>\n";
		echo "			<p>&nbsp;<br>Where would you like to back up your Database Tables to?<br><br>\n";
		echo "			<input type='radio' name=\"OutDest\" value=\"screen\"> Display Results on the Screen<br>\n";
		echo "			<input type='radio' name=\"OutDest\" value=\"remote\" checked> Download to a file on my local computer<br>\n";
		echo "			<input type='radio' name=\"OutDest\" value=\"local\"> Store the file in the backup directory on the server<br>&nbsp;\n";
		echo "			</p>\n 	</td>\n	</tr>\n";
		echo "	<tr>\n		<td>\n";
		echo "			<p>What format would you like to save them as?<br><br>\n";
		if (function_exists('gzcompress')) echo "			<input type='radio' name=\"OutType\" value=\"zip\"> As a Zip file<br>\n";
		if (function_exists('bzcompress')) echo "			<input type='radio' name=\"OutType\" value=\"bzip\"> As a BZip file<br>\n";
		if (function_exists('gzencode')) echo "			<input type='radio' name=\"OutType\" value=\"gzip\"> As a GZip file<br>\n";
		echo "			<input type='radio' name=\"OutType\" value=\"sql\" checked> As a SQL (plain text) file<br>&nbsp;\n";
		echo "			</p>\n 	</td>\n	</tr>\n";
		echo "	<tr>\n		<td>\n";
		echo "			<p>What do you want to back up?<br><br>\n";
		echo "			<input type='radio' name=\"toBackUp\" value=\"data\"> Data Only&nbsp; &nbsp;\n";
		echo "			<input type='radio' name=\"toBackUp\" value=\"structure\"> Structure Only&nbsp; &nbsp;\n";
		echo "			<input type='radio' name=\"toBackUp\" value=\"both\" checked> Data and Structure<br>&nbsp;\n";
		echo "			</p>\n 	</td>\n	</tr>\n";
		echo "	<tr>\n		<td align=\"center\">\n";
		echo "			<p align=\"left\">Which Database Tables would you like to back up?<br>Please note, it is highly recommended you select ALL your tables.</p>\n";
		echo "			<select name=\"tables[]\" size=\"5\" MULTIPLE>\n";
		echo "			<option value=\"all\" selected>All Mambo Tables&nbsp; &nbsp;\n";
		$result = $database->openConnectionWithReturn("SHOW TABLES");
		while ($result2 = mysql_fetch_row($result)) {
			echo "			<option value=\"$result2[0]\">$result2[0]\n";
		}
		mysql_free_result($result);
		echo "			</select>\n		</td>\n	</tr>\n	<tr>\n";
		echo "		<td align=\"center\">&nbsp;<br><input type=submit value=\"Backup the Selected Tables\" class=\"button\"></td>\n";
		echo "	</tr>\n</table>\n</form>\n";
	}
	
	function doBackup($database, $tables, $OutType, $OutDest, $toBackUp, $UserAgent, $local_backup_path) {
		if (!$tables[0]) {
			echo "<p class=\"componentHeading\">Error! No database table(s) specified. Please select at least one table and re-try.</p>\n";
			$this->dbBackup($database);
			return;
		}
		
		/* Need to know what browser the user has to accomodate nonstandard headers */
		
		if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $UserAgent)) {
			$UserBrowser = "Opera";
		} elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $UserAgent)) {
			$UserBrowser = "IE";
		} else {
			$UserBrowser = '';
		}
		
		/* Determine the mime type and file extension for the output file */
		
		if ($OutType == "bzip") :
			$filename = $db . "_" . date("jmYHis") . ".bz2";
			$mime_type = 'application/x-bzip';
		elseif ($OutType == "gzip") :
			$filename = $db . "_" . date("jmYHis") . ".gz";
			$mime_type = 'application/x-gzip';
		elseif ($OutType == "zip") :
			$filename = $db . "_" . date("jmYHis") . ".zip";
			$mime_type = 'application/x-zip';
		else :
			$filename = $db . "_" . date("jmYHis") . ".sql";
			$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
		endif;
		
		/* Store all the tables we want to back-up in variable $tables[] */
		
		if ($tables[0] == "all") {
			array_pop($tables);
			$query1 = $database->openConnectionWithReturn("SHOW TABLES");
			while ($result1 = mysql_fetch_row($query1)) {
				list(,$tables[]) = each($result1);
			}
			mysql_free_result($query1);
		}
		
		/* Store the "Create Tables" SQL in variable $CreateTable[$tblval] */

		if ($toBackUp!="data") {
			foreach ($tables as $tblval) {
				$query2 = $database->openConnectionWithReturn("SHOW CREATE TABLE $tblval");
				while ($result2 = mysql_fetch_array($query2)) {
					$CreateTable[$tblval] = $result2;
				}
			}
			mysql_free_result($query2);
		}
		
		/* Store all the FIELD TYPES being backed-up (text fields need to be delimited) in variable $FieldType*/

		if ($toBackUp!="structure") {
			foreach ($tables as $tblval) {
				$query3 = $database->openConnectionWithReturn("SHOW FIELDS FROM $tblval");
				while ($result3 = mysql_fetch_row($query3)) {
					$FieldType[$tblval][$result3[0]] = preg_replace("/[(0-9)]/",'', $result3[1]);
				}
			}
			mysql_free_result($query3);
		}

		/* Build the fancy header on the dump file */

		$OutBuffer = "#\n";
		$OutBuffer .= "# Mambo Open Source v4.0.12 MySQL-Dump\n";
		$OutBuffer .= "# version 2.0.2\n";
		$OutBuffer .= "# http://www.mamboserver.com\n";
		$OutBuffer .= "#\n";
		$OutBuffer .= "# Host: $host\n";
		$OutBuffer .= "# Generation Time: " . date("M j, Y \a\\t H:i") . "\n";
		$OutBuffer .= "# Server version: " . mysql_get_server_info() . "\n";
		$OutBuffer .= "# PHP Version: " . phpversion() . "\n";
		$OutBuffer .= "# Database : `" . $db . "`\n# --------------------------------------------------------\n";
		
		/* Okay, here's the meat & potatoes */
		
		foreach ($tables as $tblval) {
			if ($toBackUp != "data") {
				$OutBuffer .= "#\n# Table structure for table `$tblval`\n#\nDROP TABLE IF EXISTS $tblval;\n" . $CreateTable[$tblval][1] . ";\n";
			}
			if ($toBackUp != "structure") {
				$OutBuffer .= "#\n# Dumping data for table `$tblval`\n#\n";
				$query4 = $database->openConnectionWithReturn("SELECT * FROM $tblval");
				while ($result4 = mysql_fetch_array($query4, MYSQL_ASSOC)) {
					$InsertDump = "INSERT INTO $tblval VALUES (";
					while (list($key, $value) = each ($result4)) {
						if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET")) {
							$InsertDump .= "'" . addslashes($value) . "',";
						} else {
							$InsertDump .= "$value,";
						}
					}
					$OutBuffer .= rtrim($InsertDump,',') . ");\n";
				}
				mysql_free_result($query4);
			}
		}
		
		/* Send the HTML headers */
		if ($OutDest == "remote") {
			header('Content-Type: ' . $mime_type);
			header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			if ($UserBrowser == 'IE') {
				header('Content-Disposition: inline; filename="' . $filename . '"');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			} else {
				header('Content-Disposition: attachment; filename="' . $filename . '"');
				header('Pragma: no-cache');
			}
		}
		
		if ($OutDest == "screen") :
			$OutBuffer = str_replace("<","&lt;",$OutBuffer);
			$OutBuffer = str_replace(">","&gt;",$OutBuffer);
			echo "<table width=\"100%\"><tr><td align=\"left\"><pre>" . $OutBuffer . "</pre>\n</td></tr></table>";
		elseif ($OutType == "sql") :
			if ($OutDest == "local") :
				$fp = fopen("$local_backup_path/$filename", "w");
				if (!$fp) :
					echo "<p align=\"center\"  class=\"error\">Database backup FAILURE!!<br>File $local_backup_path/$filename not writable<br>Please contact your admin/webmaster!</p>";
				else :
					fwrite($fp, $OutBuffer);
					fclose($fp);
					echo "<p align=\"center\"  class=\"heading\">Database backup successful! Your file was saved on the server in directory :<br>$local_backup_path/$filename</p>";
				endif;
				$this->dbBackup($database);
			else :
				echo $OutBuffer;
			endif;
		elseif ($OutType == "bzip") :
			if (function_exists('bzcompress')) :
				if ($OutDest == "local") :
					$fp = fopen("$local_backup_path/$filename", "wb");
					if (!$fp) :
						echo "<p align=\"center\"  class=\"error\">Database backup FAILURE!!<br>File $local_backup_path/$filename not writable<br>Please contact your admin/webmaster!</p>";
					else :
						fwrite($fp, bzcompress($OutBuffer));
						fclose($fp);
						echo "<p align=\"center\"  class=\"heading\">Database backup successful! Your file was saved on the server in directory :<br>$local_backup_path/$filename</p>";
					endif;
					$this->dbBackup($database);
				else :
					echo bzcompress($OutBuffer);
				endif;
			else :
				echo $OutBuffer;
			endif;
		elseif ($OutType == "gzip") :
			if (function_exists('gzencode')) :
				if ($OutDest == "local") :
					$fp = fopen("$local_backup_path/$filename", "wb");
					if (!$fp) :
						echo "<p align=\"center\"  class=\"error\">Database backup FAILURE!!<br>File $local_backup_path/$filename not writable<br>Please contact your admin/webmaster!</p>";
					else :
						fwrite($fp, gzencode($OutBuffer));
						fclose($fp);
						echo "<p align=\"center\"  class=\"heading\">Database backup successful! Your file was saved on the server in directory :<br>$local_backup_path/$filename</p>";
					endif;
					$this->dbBackup($database);
				else :
					echo gzencode($OutBuffer);
				endif;
			else :
				echo $OutBuffer;
			endif;
		elseif ($OutType == "zip") :
			if (function_exists('gzcompress')) :
				include "classes/zip.lib.php";
				$zipfile = new zipfile();
				$zipfile -> addFile($OutBuffer, $filename . ".sql");
				if ($OutDest == "local") :
					$fp = fopen("$local_backup_path/$filename", "wb");
					if (!$fp) :
						echo "<p align=\"center\"  class=\"error\">Database backup FAILURE!!<br>File $local_backup_path/$filename not writable<br>Please contact your admin/webmaster!</p>";
					else :
						fwrite($fp, $zipfile->file());
						fclose($fp);
						echo "<p align=\"center\"  class=\"heading\">Database backup successful! Your file was saved on the server in directory :<br>$local_backup_path/$filename</p>";
					endif;
					$this->dbBackup($database);
				else :
					echo $zipfile->file();
				endif;
			else :
				echo $OutBuffer;
			endif;
		endif;
	}
	
	function dbRestore($database, $local_backup_path) {
		$uploads_okay = (function_exists('ini_get')) ? ((strtolower(ini_get('file_uploads')) == 'on' || ini_get('file_uploads') == 1) && intval(ini_get('upload_max_filesize'))) : (intval(@get_cfg_var('upload_max_filesize')));
		echo "<form action=\"index2.php?option=databaseAdmin&task=doRestore\" method=\"post\"";
		if ($uploads_okay) echo " enctype=\"multipart/form-data\"";
		echo ">\n";
		echo "\t<table border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\">\n";
		echo "\t\t<tr><th class=\"articlehead\" colspan=\"3\">Database Tables Restore</th></tr>\n";
		if (isset($local_backup_path)) {
			if ($handle = @opendir($local_backup_path)) {
				echo "\t\t<tr><td colspan=3><br>The following backups exist on the web server :<br>&nbsp;</td></tr>\n";
				echo "\t\t<tr><td class=\"heading\">&nbsp;</td><td class=\"heading\">Backup File Name</td><td class=\"heading\">Created Date/Time</td></tr>\n";
				while ($file = @readdir($handle)) {
					if (is_file($local_backup_path . "/" . $file)) {
						if (eregi(".\.sql$",$file) || eregi(".\.bz2$",$file) || eregi(".\.gz$",$file)) {
							echo "\t\t<tr><td align=\"center\"><input type=\"radio\" name=\"file\" value=\"$file\"></td><td>$file</td><td>" . date("m/d/y H:i:sa", filemtime($local_backup_path . "/" . $file)) . "</td></tr>\n";
						}
					}
				}
			} else {
				echo "\t\t<tr><td colspan=\"3\" class=\"error\">Error!<br>Invalid or non-existant backup path in your configuration file : <br>" . $local_backup_path . "/" . $file . "</td></tr>\n";
			}
			@closedir($handle);
		} else {
			echo "\t\t<tr><td colspan=\"3\" class=\"error\">Error!<br>Backup path in your configuration file has not been configured.</td></tr>\n";
		}
		if ($uploads_okay) {
			echo "\t\t<tr><td colspan=\"3\"><br>Or alternatively, if you've downloaded a backup to your computer,<br>you can restore from a local file :</td></tr>\n";
			echo "\t\t<tr><td>&nbsp;</td><td><br><input type=\"file\" name=\"upfile\" class=\"button\"></td><td>&nbsp;</td></tr>\n";
		}
		echo "\t\t<tr><td>&nbsp;</td><td>&nbsp;<br><input type=\"submit\" class=\"button\" value=\"Perform the Restore\">&nbsp;&nbsp;<input type=\"reset\" class=\"button\" value=\"Reset\"></td><td>&nbsp;</td></tr>\n";
		echo "\t</table>\n\t</form>\n";
	}
	
	function doRestore($database, $file, $uploadedFile, $local_backup_path) {
		if (($file) && ($uploadedFile['name'])) {
			echo "<p class=\"error\">Error! Both a local file and one from the server cannot be specified at the same time.</p>\n";
			$this->dbRestore($database, $local_backup_path);
			return;
		}
		if ((!$file) && (!$uploadedFile['name'])) {
			echo "<p class=\"error\">Error! No restore file specified.</p>\n";
			$this->dbRestore($database, $local_backup_path);
			return;
		}
		if ($file) :
			if (isset($local_backup_path)) :
				$infile = $local_backup_path . "/" . $file;
				$upfileFull = $file;
			else :
				echo "<p class=\"error\">Error! Backup path in your configuration file has not been configured.</p>\n";
				$this->dbRestore($database, $local_backup_path);
				return;
			endif;
		else :
			$upfileFull = $uploadedFile['name'];
			$infile = $uploadedFile['tmp_name'];
		endif;
		if (!eregi(".\.sql$",$upfileFull) && !eregi(".\.bz2$",$upfileFull) && !eregi(".\.gz$",$upfileFull)) :
			echo "<p class=\"error\">Error! Invalid file extension in input file ($upfileFull).<br>Only *.sql, *.bz2, or *.gz files may be uploaded.</p>\n";
			$this->dbRestore($database, $local_backup_path);
			return;
		endif;
		if (substr($upfileFull,-3)==".gz") :
			if (function_exists('gzinflate')) :
				$fp=fopen("$infile","rb");
				if ((!$fp) || filesize("$infile")==0) :
					echo "<p class=\"error\">Error! Unable to open input file ($infile) for reading or file contains no records.</p>";
					$this->dbRestore($database, $local_backup_path);
					return;
				else :
					$content=fread($fp,filesize("$infile"));
					fclose($fp);
					$content=gzinflate(substr($content,10));
				endif;
			else :
				echo "<p class=\"error\">Error! Unable to process gzip file as gzinflate function is unavailable.</p>\n";
				$this->dbRestore($database, $local_backup_path);
				return;
			endif;
		elseif (substr($upfileFull,-4)==".bz2") :
			if (function_exists('bzdecompress')) :
				$fp=fopen("$infile","rb");
				if ((!$fp) || filesize("$infile")==0) :
					echo "<p class=\"error\">Error! Unable to open input file ($infile) for reading or file contains no records.</p>";
					$this->dbRestore($database, $local_backup_path);
					return;
				else :
					$content=fread($fp,filesize("$infile"));
					fclose($fp);
					$content=bzdecompress($content);
				endif;
			else :
				echo "<p class=\"error\">Error! Unable to process bzip file as bzdecompress function is unavailable.</p>\n";
				$this->dbRestore($database, $local_backup_path);
				return;
			endif;
		elseif (substr($upfileFull,-4)==".sql") :
			$fp=fopen("$infile","r");
			if ((!$fp) || filesize("$infile")==0) :
				echo "<p class=\"error\">Error! Unable to open input file ($infile) for reading or file contains no records.</p>";
				$this->dbRestore($database, $local_backup_path);
				return;
			else :
				$content=fread($fp,filesize("$infile"));
				fclose($fp);
				endif;
		elseif (substr($upfileFull,-4)==".zip") :
			echo "<p class=\"heading\">Sorry, zip files cannot be processed \"on-the-fly\" at this time. Please manually unzip the .sql file before attempting to restore the backup.</p>\n";
			$this->dbRestore($database, $local_backup_path);
			return;
		else :
			echo "<p class=\"error\">Error! Unrecognized input file type. ($infile : $upfileFull)</p>\n";
			$this->dbRestore($database, $local_backup_path);
			return;
		endif;
		$decodedIn=explode(chr(10),$content);
		$decodedOut="";
		$queries=0;
		foreach ($decodedIn as $rawdata) {
			$rawdata=trim($rawdata);
			if (($rawdata!="") && ($rawdata{0}!="#")) {
				$decodedOut .= $rawdata;
				if (substr($rawdata,-1)==";") {
					if  ((substr($rawdata,-2)==");") || (strtoupper(substr($decodedOut,0,6))!="INSERT")) {
						if (eregi('^(DROP|CREATE)[[:space:]]+(IF EXISTS[[:space:]]+)?(DATABASE)[[:space:]]+(.+)', $decodedOut)) {
							echo "<p class=\"error\">Error! Your input file contains a DROP or CREATE DATABASE statement. Please delete these statements before trying to restore the file.</p>\n";
							$this->dbRestore($database, $local_backup_path);
							return;
						}
						$query = $database->openConnectionWithReturn($decodedOut);
						$decodedOut="";

						$queries++;
					}
				}
			}
		}
		echo "<p class=\"heading\">Success! Database has been restored to the backup you requested ($queries SQL queries processed).</p>\n";
		$this->dbRestore($database, $local_backup_path);
		return;
	}
}

?>
