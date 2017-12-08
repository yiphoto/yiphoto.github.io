<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/customers.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<head>
		<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<title>Create a New Customer</title>
		<style type=text/css>
		table,td,tr,th
	{
		border-width: 0;
		background-color: white;
	}
		</style> 
	</head>

	<body bgcolor="#ffffff">
	<h3 align='center'> New Customer</h3>
		<form action="addcustomer.php" method="Post" name="AddCustomer">
			<table width="581" border="0" cellspacing="2" cellpadding="0" height="116">
				<tr>
					<td width="131">First Name:</td>
					<td><input type="text" name="FirstN" size="26"></td>
				</tr>
				<tr>
					<td width="131">Last Name:</td>
					<td><input type="text" name="LastN" size="26"></td>
				</tr>
				<tr>
					<td width="131">Account Number:</td>
					<td><input type="text" name="AccountNum" size="8" maxlength=8></td>
				</tr>
				<tr>
					<td width="131">Phone Number:</td>
					<td><input type="text" name="PhoneNum" maxlength=15 size="15"> </td>
				</tr>
			<tr>
<td valign=top width="131">
			Comments: <td><textarea name="Comments" rows="6" cols="48"></textarea>
			</table><table><tr><td width=400 align=center>
			<input type="submit" name="AddCustomer" value="Add Customer">&nbsp;&nbsp;<input type="reset">
			</table>			</form>
	</body>

</html>
<? include ("../login/obend.php"); ?>