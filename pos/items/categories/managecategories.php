<?
ob_start();
session_start();
if($_SESSION['Name']=='' )
{
	header("Location: ../../login.php");
	exit;
}
include ("../../settings.php");
include ("../../authorization/items.php");
?>
<html>
<head>
<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url){
if(confirm(message) ) location.href = url;
}
// --->
</SCRIPT>
<LINK REL=stylesheet HREF="../../stylesheets/stylesheet.php" TYPE="text/css"> 

</head>
<body>
<BR>
<h3 align="center"> Manage Categories</h3>

<?

//Shows the Categories and gives an option to delete a category.

$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);


$result = mysql_query("SELECT * FROM categories ORDER BY Category",$db);


	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr><th>Category</th><th>Delete</th><th>Update</th></tr>"; 
	
$k=0;	
while ($myrow = mysql_fetch_assoc($result)) 
{
	if($k%2==0)
	{	
		$bgcolor='white';
	
	}
	else
	{
		$bgcolor="$rowcolor";
	
	}
			echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[Category]</td>
	
		<td align='center'><A HREF=\"javascript:decision('Are you sure you want to delete this Category?','delete.php?id=$myrow[ID]')\">Delete Category</A> </td>
		<td align='center'><A href='update.php?id=$myrow[ID]'>Update Category</A></td></tr>");
	
	
	
	$k++;
}


	echo "</table>"; 






?>
<?php 
ob_end_flush(); 
?> 
