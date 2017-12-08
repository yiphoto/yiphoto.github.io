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
*	File Name: module_installer.php
*
*	Date: 04-03-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

if ($install == "Install Modules"){
	mysql_connect($host, $user, $password) or die ("Could not connect to database.<BR>Please check your configuration and try again.");
	mysql_select_db($db) or die ("Could not select database.<br>Please check your configuration and try again.");
	for ($s = 0; $s < count($install_mod); $s++){
		$readfile = file("../modules/$install_mod[$s].php");
		if (!($readfile)) {
			return 0;
			die;
		}
		$mod_name = split("//",$readfile[1]);
		$mod_name[1] = trim($mod_name[1]);
		$query="SELECT id FROM ".$dbprefix."components WHERE module='$install_mod[$s]'";
		$result = mysql_query($query);
		$num_of_rows = mysql_num_rows($result);
		if ($num_of_rows==0) {
			$query2="INSERT INTO ".$dbprefix."components VALUES ('', '$mod_name[1]', 4, 'left', 0, '00:00:00', 1, NULL, '$install_mod[$s]', 0,0);";
			$result = mysql_query($query2);
		}
	}
}
$color = array("#FFFFFF", "#CCCCCC");
$ac=0;
?>
  
<table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#ffffff">
  <tr bgcolor="#999999">
    <td class="boxHeading">Custom Page Modules - Currently Installed</td>
    <td class="heading">Page Module File</td>
  </tr>
<?php
mysql_connect($host, $user, $password) or die ("Could not connect");
mysql_select_db($db) or die ("Could not select database");
$query = "SELECT title, module FROM ".$dbprefix."components WHERE module LIKE 'mod_%' ORDER BY module";
$result = mysql_query($query);
$num_of_rows = mysql_num_rows($result);
?>

<!--         
<tr> 
<td colspan="2">Installed modules:&nbsp; <?php print "<b>$num_of_rows</b>"; ?> 
</td>
</tr>
-->

<?php
$j=0;
if ($num_of_rows=="0") {
	print ("<TD><span class=small>No custom modules installed</span></TD>");
} else {
	while ($row = mysql_fetch_array($result)) {
		$list[$j]=$row[module];
?>
  <tr bgcolor="<?php echo $color[$ac]; ?>"> 
    <TD width="42%"><span class="small"><?php print ("$row[title]"); ?></span></TD>
    <TD width="58%"><span class="small"><?php print ("$row[module]"); ?></span></TD>
  </tr>
  
<?php
if ($ac==1){
	$ac=0;
} else {
	$ac++;
}
$j++;
	}
}
?>
  <tr> 
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
  </TR>
  
<?php
if ($handle=opendir("../modules/")) {
	$i=0;
	while ($file = readdir($handle)) {
		if (!strcasecmp(substr($file,-4),".php") && $file <> "." && $file <> "..") {
			$available[$i]=substr($file,0,-4);
			$i++;
		}
	}
}
?>
  <FORM action='index2.php?option=module_installer' method="POST">
    <tr> 
      <td bgcolor="#999999" class="boxHeading">Custom Page Modules - Available</td>
      <td bgcolor="#999999" class="heading">Page Module File</td>
    </tr>
<?php
$no_available = 1;
$k=0;
while ($available[$k]) {
	if (!in_array_key($available[$k],$list)) {
		$readfile = file("../modules/$available[$k].php");
		if (!($readfile)) {
			return 0;
			die;
		}
		$mod_name = split("//",$readfile[1]);
		$mod_name[1] = trim($mod_name[1]);
		print "<tr bgcolor='$color[$ab]'><td><INPUT TYPE='checkbox' NAME='install_mod[]' VALUE='$available[$k]'><span class='bold'>$mod_name[1]</td><td>$available[$k]</span></td></tr>";
		$no_available = 0;
	}
	
	$k++;
	
}
if ($no_available) print "<tr><td colspan='2'><span class='small'>No custom modules to install</span></td></tr>";
?>
    <td> </tr> 
    <tr> 
      <td align="left"> 
<?php
print "<INPUT class='button' TYPE='submit' NAME='install' VALUE='Install Modules'>";
?>
      </td>
      <td align="left">&nbsp;</td>
  </FORM>
<?php
function in_array_key($key, $array) {
	$i=0;
	while ($array[$i]) {
		if ($array[$i] == $key)
		return true;
		$i++;
	}
	return false;
}
?>
</table>
</BODY>
</HTML>