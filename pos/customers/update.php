<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/customers.php");
?>
<?
/*the form that is used for updating, makes sure the values that were used before
stay constant.
*/
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$ID=$_GET['id'];
$result = mysql_query("SELECT * FROM customers WHERE ID=$ID",$db);
$myrow = mysql_fetch_assoc($result);
?>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Create a New Customer</title>
	</head>

	<body bgcolor="#ffffff">
		<form action="updatecustomer.php" method="Post" name="updateCustomer">
			<table width="581" border="0" cellspacing="2" cellpadding="0" height="116">
				<tr>
					<td width="131">First Name:</td>
					<td><input type="text" name="FirstN" size="26"  value=<? echo "\"$myrow[FirstN]\"" ?> ></td>
				</tr>
				<tr>
					<td width="131">Last Name:</td>
					<td><input type="text" name="LastN" size="26" value=<? echo "\"$myrow[LastN]\"" ?>></td>
				</tr>
				<tr>
					<td width="131">Account Number:</td>
					<td><input type="text" name="AccountNum" size="8" value=<? echo "\"$myrow[AccountNum]\"" ?>  maxlength="8"</td>
				</tr>
				<tr>
					<td width="131">Phone Number:</td>
					<td><input type="text" name="PhoneNum" maxlength=15 size="15" value=<? echo "\"$myrow[PhoneNum]\"" ?>> </td>
				</tr>
			<tr>
			<td valign=top width="131">
			Comments: <td><textarea name="Comments"  rows="6" cols="48"><? echo "$myrow[Comments]" ?></textarea>
			</table><table><tr><td width=400 align=center>
			<input type="submit" name="UpdateCustomer" value="Update Customer">&nbsp;&nbsp;<input type="reset" value="Reset To Previous">
			</table>		
			<INPUT TYPE="HIDDEN" NAME="id" VALUE=<?echo $ID; ?> > 
			</form>
	</body>

</html>
<? include ("../login/obend.php"); ?>