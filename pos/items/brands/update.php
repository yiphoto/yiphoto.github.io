<? include ("../../login/session.php"); 
include ("../../settings.php");
include ("../../authorization/items.php");
?>
<?
//The form used for updating an item.  Makes sure the items have the value they had before.
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$ID=$_GET['id'];
$result = mysql_query("SELECT * FROM brands WHERE ID=$ID",$db);
$myrow = mysql_fetch_assoc($result);
$OldBrandName="\"$myrow[Brand]\"";
?>


<html>

	<head>
		
		
		<title>Create An Item</title>
	</head>

	<body>
		<form action="updatebrand.php" method="post" name="Updatebrand">
			<table border="0" cellspacing="2" cellpadding="0">
				<tr height="18">
					<td width="120" height="18">Brand Name:</td>
					<td height="18"><input type="text" name="Brand" size="24" value=<? echo "\"$myrow[Brand]\"" ?> ></td>
				</tr>
			</table>
			<p><input type="submit" name="Update Brand" value="Update Brand"><input type="reset" value="Reset To Previous"></p>
			<p></p>
			<INPUT TYPE="HIDDEN" NAME="id" VALUE=<?echo $ID;?> > 
			<INPUT TYPE="HIDDEN" NAME="OldBrandName" VALUE=<?echo $OldBrandName; ?> >
			</form>
		<p></p>
	</body>

</html>
<? include ("../../login/obend.php"); ?>