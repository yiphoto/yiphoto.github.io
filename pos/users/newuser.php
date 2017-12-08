<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/users.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<head>
		<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<title>Create a New User</title>
		<style type=text/css>
		table,td,tr,th
	{
		border-width: 0;
		background-color: white;
		
	}
		</style> 
	</head>

	<body bgcolor="#ffffff">
	<h3 align='center'> Add User</h3>
		<form action="adduser.php" method="Post" name="Adduser">
			<table width="712" border="0" cellspacing="2" cellpadding="0" height="116">
				<tr>
					<td width="131">Real Name:</td>
					<td><input type="text" name="RealName" size="26"></td>
				</tr>
				<tr>
					<td width="131">Username:</td>
					<td><input type="text" name="UserName" size="26"></td>
				</tr>
				<tr>
					<td width="131">Type:</td>
					<td><select name="Type" size="1">
					<option value="Admin">Admin</option>
					<option value="Sales Clerk">Sales Clerk</option>
					<option value="Report Viewer">Report Viewer</option>
					</td>
				</tr>
				<tr>
					<td width="131">Password:</td>
					<td><input type="password" name="Password" size="15" maxlength=15></td>
				</tr>
				<tr>
					<td width="131">Password Confirm:</td>
					<td><input type="password" name="ConfirmPassword" size="15" maxlength=15></td>
				</tr>
				<tr>
				
			<td>
			<input type="submit" name="AddUser" value="Add User">&nbsp;&nbsp;<input type="reset">
			</td>
			</table>			</form>
	</body>

</html>
<? include ("../login/obend.php"); ?>