<?php
/**
*  Mambo Open Source Version 4.0.12
*  Dynamic portal server and Content managment engine
*  20-01-2003
*
*  Copyright (C) 2000 - 2003 Miro International Pty Ltd
*  Distributed under the terms of the GNU General Public License
*  This software may be used without warranty provided these statements are left
*  intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*  This code is available at http://sourceforge.net/projects/mambo
*
*  Site Name: Mambo Open Source Version 4.0.12
*  File Name: administrator/index.php
*  Original Original Developers: Danny Younes - danny@miro.com.au
*                       Nicole Anderson - nicole@miro.com.au
*  Date: 27/02/2003
*  Version #: 4.0.12
*  Comments:
**/

require ("../configuration.php");

require("classes/database.php");
$database = new database();

if (isset($_POST['submit'])){
	$query  = "SELECT id, password, name, usertype FROM ".$dbprefix."users WHERE username='".$_POST['usrname']."' AND (usertype='administrator' OR usertype='superadministrator')";
	$result = $database->openConnectionWithReturn($query);
	if (mysql_num_rows($result)!= 0){
		list($user_id, $dbpass, $fullname, $type) = mysql_fetch_array($result);
		$current_time = time();
		$session_id = md5($user_id.$fullname.$type.$current_time);
		$query2 = "INSERT INTO ".$dbprefix."session SET time='$current_time', session_id='$session_id', userid='$user_id', usertype='$type'";
		$database->openConnectionNoReturn($query2);
		if (trim($_POST['pass'])!=""){
			$pass = md5($_POST['pass']);
		} else {
			print "<SCRIPT>alert('Please enter a password'); document.location.href='index.php';</SCRIPT>\n";
		}
		
		if (strcmp($dbpass,$pass)) {
			print "<SCRIPT>alert('Incorrect Username and Password, please try again'); document.location.href='index.php';</SCRIPT>\n";
		} else {
			session_start();
			$_SESSION["userid"]=$user_id;
			$_SESSION["myname"]=$fullname;
			$_SESSION["usertype"]=$type;
			$_SESSION["logintime"]=$current_time;
			$_SESSION["admin_session_id"]=$session_id;
			header("Location: index2.php" );
		}
	} else {
		print "<SCRIPT>alert('Incorrect Username and Password, please try again'); document.location.href='index.php';</SCRIPT>\n";
	}
} else {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Mambo Open Source Administration Login</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK rel="SHORTCUT ICON" HREF="<?php echo$live_site ?>/images/favicon.ico">
<LINK rel="stylesheet" href="../css/admin.css" type="text/css">
</HEAD>
<BODY>
<FORM NAME="form" ACTION="index.php" METHOD="POST">
  <TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
    <TR> 
      <TD HEIGHT="50" BGCOLOR="#666666"> <div align="right"> <img src="../images/admin/mambo.jpg" WIDTH="147" HEIGHT="31" HSPACE="10" ALIGN="middle" ALT="Mambo"> 
        </div></TD>
    </TR>
    <TR> 
      <TD HEIGHT="1" BGCOLOR="#000000"></TD>
    </TR>
  </table>
  <table WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
    <TR> 
      <TD BGCOLOR="#d5d5d5"><span class="smalldark">&nbsp;::<?php echo $sitename; ?>::</span></TD>
    </TR>
    <TR> 
      <TD HEIGHT="1" BGCOLOR="#000000"></TD>
    </TR>
  </table>
  <br>
  <br>
  <table WIDTH="100%" BORDER="0" align="center" CELLPADDING="2" CELLSPACING="0">
    <TR> 
      <TD>&nbsp;</TD>
      <TD WIDTH="777" align="left"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Welcome 
        to Shansoft Website Administration</strong></font></TD>
    </TR>
    <TR> 
      <TD WIDTH="234">&nbsp;</TD>
      <TD COLSPAN=2 align="left"><strong>Login:</strong><br> <input name="usrname" type="text" class="inputbox" size="20"> 
      </TD>
    </TR>
    <TR> 
      <TD>&nbsp;</TD>
      <TD COLSPAN=2 align="left"><strong>Password:</strong><br> <input name="pass" type="password" class="inputbox" size="20"> 
      </TD>
    </TR>
    <TR valign="top"> 
      <TD>&nbsp;</TD>
      <TD COLSPAN=2> <input name="submit" type="submit" class="button" value="Login"> 
      </TD>
    </TR>
    <TR valign="top"> 
      <TD>&nbsp;</TD>
      <TD>&nbsp;</TD>
    </TR>
  </table>
</FORM>
<SCRIPT language="JavaScript" TYPE="text/javascript">
<!--
document.form.usrname.select();
document.form.usrname.focus();
//-->
</SCRIPT>
</BODY>
</HTML>
<?php } ?>
