<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/items.php");
?>
<html>
<head>
<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url){
if(confirm(message)) location.href = url;
}
// --->
</SCRIPT> 
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
</head>

<body>
<h3 align="center">Manage Items</h3><br>
<form action="manageitems.php" method="post" name="Search">
	Search:<input type="text" name="SEARCH" size="24">
	<input type="submit" name="Search" value="Search">
</form>[<a href="manageitems.php">Show All Items</a>]
<?
//Connects to database 
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$SEARCH=$_POST['SEARCH'];
//Calculates the TotalCost of an item with Tax.
$myrow[TotalCost]=$myrow[Price]+$myrow[Tax];

//Checks for a search and prepares to do a query to the database.
$result = mysql_query("SELECT * FROM items ORDER BY ItemName",$db);

//Checks to see if the user is searching for an item.
if(isset($SEARCH))
{
	$result = mysql_query("SELECT * FROM items WHERE ItemName like \"%$SEARCH%\" or ItemID like \"%$SEARCH%\" or Description like \"%$SEARCH%\" ORDER BY ItemName",$db); 
	echo "<div align='center'>Search for: <b>$SEARCH</b></div>";

}


//Displays the info based on the variable $result.
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr><th>Item Name</th>
	<th>Item ID</th><th>Description</th>
	<th>Brand</th><th>Category</th>
	<th>Price</th>
	<th>Tax</th>
	<th>Total Cost</th>
	<th>Quantity</th>
	<th>Delete Item</th>
	<th>Update Item</th></tr>"; 
$k=0;	
do 
{
	
	
	if($k%2==0)
	{	
		$bgcolor='white';
	
	}
	else
	{
		$bgcolor="$rowcolor";
	
	}
	
	if($myrow[Quantity]<=0 )
	{
	
		$fontcolor='red';
	
	}
	else
	{
		
		$fontcolor='black';
	
	}
	
		echo("<tr bgcolor='$bgcolor'>
		<td align='center'>$myrow[ItemName]</td>
		<td align='center'>$myrow[ItemID]</td>
		<td align='center'>$myrow[Description]</td>
		<td align='center'>$myrow[Brand]</td>
		<td align='center'>$myrow[Category]</td>
		<td align='center'>\$$myrow[Price]</td>
		<td align='center'>$myrow[Tax]%</td>
		<td align='center'>\$$myrow[TotalCost]</td>
		<td align='center'><font color=$fontcolor>$myrow[Quantity]</font></td>
		<td align='center'><A HREF=\"javascript:decision('Are you sure you want to delete this Item?','delete.php?id=$myrow[ID]')\">Delete Item</A> </td>
		<td align='center'><A href='update.php?id=$myrow[ID]'>Update Item</A></td></tr>"); 
	
	$k++;
	
}
while ($myrow = mysql_fetch_assoc($result)); 

	echo "</table>"; 





}
else
{
	echo "There are no records in the database."; 

}


?>
</body>
</html>
<? include ("../login/obend.php"); ?>
