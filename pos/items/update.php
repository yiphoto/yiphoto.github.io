<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/items.php");
?>
<?
//The form used for updating an item.  Makes sure the items have the value they had before.
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$ID=$_GET['id'];
$result = mysql_query("SELECT * FROM items  WHERE ID=$ID",$db);
$myrow = mysql_fetch_assoc($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Create An Item</title>
	</head>

	<body bgcolor="#ffffff">
		<form action="updateitem.php" method="post" name="UpdateItem">
			<table border="0" cellspacing="2" cellpadding="0">
				<tr height="18">
					<td width="120" height="18">Item Name:</td>
					<td height="18"><input type="text" name="ItemName" size="24" value=<? echo "\"$myrow[ItemName]\"" ?> ></td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Item ID:</td>
					<td height="18"><input type="text" name="ItemID" size="24" value=<? echo "\"$myrow[ItemID]\"" ?>></td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Description</td>
					<td height="18"><input type="text" name="Description" size="92" value= <? echo "\"$myrow[Description]\"" ?>></td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Brand:</td>
					<td height="18"><select name="Brand" size="1">
							<? echo "<option selected value=$myrow[Brand]>$myrow[Brand]</option>" ?>
							
					<?
					$result = mysql_query("SELECT * FROM brands ORDER BY Brand",$db);
					while ($myrow = mysql_fetch_assoc($result))
					{ 
							echo "<option value=\"$myrow[Brand]\">$myrow[Brand]</option>";
					}
					
					?>
							
				</select></tr>
				<tr height="18">
					<td width="120" height="18">Category:</td>
					<td height="18"><select name="Category" size="1">
					<?
					$result = mysql_query("SELECT * FROM items  WHERE ID=$ID",$db);
					$myrow = mysql_fetch_assoc($result);
					
					?>
					
					<? echo "<option selected value=$myrow[Category]>$myrow[Category]</option>"; ?>
					
					
					<?
					$result = mysql_query("SELECT * FROM categories ORDER BY Category",$db);
					while ($myrow = mysql_fetch_assoc($result))
					{ 
							echo "<option value=\"$myrow[Category]\">$myrow[Category]</option>";
							
					}
					
					?>
						
						</select></td>
				</tr>
				<tr height="18">
				<?
					$result = mysql_query("SELECT * FROM items  WHERE ID=$ID",$db);
					$myrow = mysql_fetch_assoc($result);
					?>
					<td width="120" height="18">Price:</td>
					<td height="18"><input type="text" name="Price" size="24" value=<? echo "\"$myrow[Price]\"" ?>>(Without Tax)</td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Tax:</td>
					<?
					$result = mysql_query("SELECT * FROM items  WHERE ID=$ID",$db);
					$myrow = mysql_fetch_assoc($result);
					?>
					<td height="18">
						<input type=text size=2 name=Tax value=<?echo"$myrow[Tax]";?>>%
						</td>
				</tr>
				<tr height="18">
					<td width="120" height="18">Quantity:</td>
					<td height="18"><input type="text" name="Quantity" size="10" value="<? echo "$myrow[Quantity]" ?>"></td>
				</tr>
			</table>
			<p><input type="submit" name="Update Item" value="Update Item"><input type="reset" value="Reset To Previous"></p>
			<p></p>
			<INPUT TYPE="HIDDEN" NAME="id" VALUE=<?echo $ID;?> > 
			</form>
		<p></p>
	</body>

</html>

					<?
					$result = mysql_query("SELECT * FROM brands ORDER BY Brand",$db);
					while ($myrow = mysql_fetch_assoc($result));
					{ 
							echo "<option value=\"$myrow[Brand]\">$myrow[Brand]</option>";
							
					}
					
					?>
					<? include ("../login/obend.php"); ?>