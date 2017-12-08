<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/items.php");
?>
<? 
//The form for adding an item
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
					
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<head>
		<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
		<style type=text/css>
		table,td,tr,th
		{
			border-width: 0;
			background-color: white;
		}
		</style>
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Create An Item</title>
	</head>

	<body bgcolor="#ffffff">
	<h3 align="center">New Item</h3><br>
		<form action="additem.php" method="post" name="NewItem">
			<table border="0" cellspacing="2" cellpadding="0">
				<tr height="18">
					<td width="120" height="18">Item Name:</td>
					<td height="18"><input type="text" name="ItemName" size="24"></td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Item ID:</td>
					<td height="18"><input type="text" name="ItemID" size="24"></td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Description:</td>
					<td height="18"><input type="text" name="Description" size="92"></td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Brand:</td>
					<td height="18"><select name="Brand" size="1">
					<?
					$result = mysql_query("SELECT * FROM brands ORDER BY Brand",$db);
					while ($myrow = mysql_fetch_assoc($result))
					{ 
							echo "<option value=\"$myrow[Brand]\">$myrow[Brand]</option>";
							
					}
					
					?>
					</select>
					</td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Category:</td>
					<td height="18"><select name="Category" size="1">
					<?
					
					$result = mysql_query("SELECT * FROM categories ORDER BY Category",$db);
					while ($myrow = mysql_fetch_assoc($result))
					{ 
							echo "<option value=\"$myrow[Category]\">$myrow[Category]</option>";
							
					}
					
					?>
					</select>
					</td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Price:</td>
					<td height="18"><input type="text" name="Price" size="24">(Without Tax)</td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Tax:</td>
					<td height="18"><input type=text size=2 name=Tax>%</td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Quantity:</td>
					<td height="18"><input type="text" name="Quantity" size="10"></td>
				</tr>
			</table>
			<p><input type="submit" name="Submit" value="Submit"><input type="reset"></p>
			<p></p>
			</form>
		<p></p>
	</body>

</html>
<? include ("../login/obend.php"); ?>