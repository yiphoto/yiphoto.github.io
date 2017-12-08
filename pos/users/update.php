<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/users.php");
?>
<?
/*the form that is used for updating, makes sure the values that were used before
stay constant.
*/
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$ID=$_GET['id'];
$result = mysql_query("SELECT * FROM users WHERE ID=$ID",$db);
$myrow = mysql_fetch_assoc($result);
?>
<html>

	<head>
		<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Update User</title>
		
		<style type=text/css>
		table,td,tr,th
	{
		border-width: 0;
		background-color: white;
		
	}
		</style> 
	</head>


	<body bgcolor="#ffffff">
	<h3 align='center'> Update User</h3>
		<form action="updateuser.php" method="Post" name="updateuser">
			<table width="581" border="0" cellspacing="2" cellpadding="0" height="116">
				<tr>
					<td width="131">Real Name:</td>
					<td><input type="text" name="RealName" size="26" value=<? echo "\"$myrow[RealName]\"" ?>></td>
				</tr>
				<tr>
					<td width="131">Username:</td>
					<td><input type="text" name="UserName" size="26" value=<? echo "\"$myrow[Username]\"" ?>></td>
				</tr>
				<tr>
					<td width="131">Type:</td>
					<td><select name="Type" size="1">
					<? echo "<option selected value=\"$myrow[Type]\">$myrow[Type]</option>"; ?>
					<option value="Admin">Admin</option>
					<option value="Sales Clerk">Sales Clerk</option>
					<option value="Report Viewer">Report Viewer</option>
					</td>
				</tr>
				<tr>
					<td width="131">Password:</td>
					<td><input type="password" name="Password" size="15" maxlength=15 value=<? echo "\"$myrow[Password]\"" ?>></td>
				</tr>
				
				<tr>
					<td width="131">Password Confirm:</td>
					<td><input type="password" name="ConfirmPassword" size="15" maxlength=15 value=<? echo "\"$myrow[Password]\"" ?>></td>
				</tr>
				<tr>
				
			<td>
			<input type="submit" name="updateUser" value="Update User">&nbsp;&nbsp;<input type="reset">
			</td>
			</table>
			<INPUT TYPE="HIDDEN" NAME="id" VALUE=<?echo $ID; ?> > 			
			</form>
	</body>
</html>
<? include ("../login/obend.php"); ?>