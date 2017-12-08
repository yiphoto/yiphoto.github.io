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
*	File Name: component_installer.php
*
*	Date: 04-03-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

if ($install == "Install Components"){
	mysql_connect($host, $user, $password) or die ("Could not connect to database.<BR>Please check your configuration and try again.");
	mysql_select_db($db) or die ("Could not select database.<br>Please check your configuration and try again.");
	for ($s = 0; $s < count($install_mod); $s++){
		$readfile = file("../components/$install_mod[$s].php");
		if (!($readfile)) {
			return 0;
			die;
		}
		$com_name = split("//",$readfile[1]);
		$com_name[1] = trim($com_name[1]);
		$query="SELECT moduleid FROM ".$dbprefix."mambo_modules WHERE modulelink='index.php?option=$install_mod[$s]'";
		$result = mysql_query($query);
		$num_of_rows = mysql_num_rows($result);
		if ($num_of_rows==0) {
			$query2="INSERT INTO ".$dbprefix."mambo_modules VALUES ('', '$com_name[1]', 'index.php?option=$install_mod[$s]', '');";
			$result = mysql_query($query2);
		}
	}
}
$color = array("#FFFFFF", "#CCCCCC");
$ac=0;
?>

<table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#ffffff">
  <tr bgcolor="#999999">
    <td class="boxHeading">Custom Page Components - Currently Installed</td>
    <td class="heading">Component File</td>
  </tr>  
<?php
mysql_connect($host, $user, $password) or die ("Could not connect");
mysql_select_db($db) or die ("Could not select database");
$query = "SELECT modulename, modulelink FROM ".$dbprefix."mambo_modules WHERE modulelink LIKE '%com_%' ORDER BY modulename";
$result = mysql_query($query);
$num_of_rows = mysql_num_rows($result);
?>

<!--
<tr>
<td colspan=2>Installed components:&nbsp;<?php print "<b>$num_of_rows</b>"; ?>
</td>
</tr>
-->

<?php
$j=0;
if ($num_of_rows=="0") {
	print ("<TD><span class=small>No custom components installed</span></TD>");
} else {
	while ($row = mysql_fetch_array($result)) {
			$list[$j]=$row[modulelink]; ?>
			 <tr bgcolor="<?php echo $color[$ac]; ?>"> 
      			<TD><span class="small"><?php print ("$row[modulename]"); ?></span></TD>
          		<TD><span class="small"><?php print ("$row[modulelink]"); ?></span></TD>
        		</TR>
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

if ($handle=opendir("../components/")) {
	$i=0;
	while ($file = readdir($handle)) {
		if (!strcasecmp(substr($file,-4),".php") && $file <> "." && $file <> "..") {
			$available[$i]=substr($file,0,-4);
			$i++;
		}
	}
}
?>
        <FORM action='index2.php?option=component_installer' method="POST">
        <tr> 
      <td bgcolor="#999999" class="boxHeading">Custom Components - Available</td>
      <td bgcolor="#999999" class="heading">Component File</td>
    </tr>
<?php
$no_available = 1;
$k=0;
while ($available[$k]) {
	if (!in_array_key($available[$k],$list)) {
		$readfile = file("../components/$available[$k].php");
		if (!($readfile)) {
			return 0;
			die;
		}
		$com_name = split("//",$readfile[1]);
		$com_name[1] = trim($com_name[1]);
		print "<tr><td colspan=2><INPUT TYPE='checkbox' NAME='install_mod[]' VALUE='$available[$k]'><span class='bold'>$com_name[1] - $available[$k]</span></td></tr>";
		$no_available = 0;
	}
	$k++;
}
if ($no_available) print "<tr><td colspan='2'><span class='small'>No custom components to install</span></td></tr>";
?>
    <td> </tr> 
    <tr> 
      <td align="left"> 
<?php
print "<INPUT class='button' TYPE='submit' NAME='install' VALUE='Install Components'>";
?>
            </td>
        </FORM>
<?php
function in_array_key($key, $array) {
	$i=0;
	while ($array[$i]) {
		if (eregi($key,$array[$i]))
		return true;
		$i++;
	}
	return false;
}
?>
      </table>
    </td>
  </tr>
</table>
</BODY>
</HTML>