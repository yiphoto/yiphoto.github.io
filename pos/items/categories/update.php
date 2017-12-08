<? include ("../../login/session.php"); 
include ("../../settings.php");
include ("../../authorization/items.php");
?>
<?
//The form used for updating an item.  Makes sure the items have the value they had before.
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$ID=$_GET['id'];
$result = mysql_query("SELECT * FROM categories WHERE ID=$ID",$db);
$myrow = mysql_fetch_assoc($result);
$OldCategoryName="\"$myrow[Category]\"";
?>


<html>

	<head>
		
		
		<title>Create An Item</title>
	</head>

	<body>
		<form action="updatecategory.php" method="post" name="Updatecategory">
			<table border="0" cellspacing="2" cellpadding="0">
				<tr height="18">
					<td width="120" height="18">Category Name:</td>
					<td height="18"><input type="text" name="Category" size="24" value=<? echo "\"$myrow[Category]\"" ?> ></td>
				</tr>
			</table>
			<p><input type="submit" name="Update Category" value="Update Category"><input type="reset" value="Reset To Previous"></p>
			<p></p>
			<INPUT TYPE="HIDDEN" NAME="id" VALUE=<?echo $ID;?> > 
			<INPUT TYPE="HIDDEN" NAME="OldCategoryName" VALUE=<?echo $OldCategoryName; ?> >
			</form>
		<p></p>
	</body>

</html>
<? include ("../../login/obend.php"); ?>