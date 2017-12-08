<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/reports.php");
?>
<html>
<head>
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url){
if(confirm(message)) location.href = url;
}
// --->
</SCRIPT>
</head>
<body>
<?

echo "<h3 align='center'>$company's Cumulative Report</h3>
<form action='cumulative.php' method='post' name='Search'>
	Search:<input type='text' name='SEARCH' size='24'>
	<input type='submit' name='Search' value='Search'>
</form>[<a href='cumulative.php'>Show All Orders</a>]";


//Shows all orders and gives the ability to delete and update orders!
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$SEARCH=$_POST['SEARCH'];

$result = mysql_query("SELECT * FROM sales ORDER BY Date",$db);
//Checks to see if the user is searching for an order.
if(isset($SEARCH))
{
	$result = mysql_query("SELECT * FROM sales WHERE Customer like \"%$SEARCH%\" or Items like \"%$SEARCH%\" ORDER BY Date",$db); 
	echo "<div align='center'>Search for: <b>$SEARCH</b></div>";

}

$k=0;
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr><th>Date Of Purchase</th>
	<th>Customer Name</th>
	<th>Item Name</th>
	<th>Price</th><th>Quantity</th>
	<th>Total Cost</th>
	<th>Delete Sale</th>
	<th>Change Sale</th></tr>\n";
	 
	
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
		echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[Date]</td>
		<td align='center'>$myrow[Customer]</td>
		<td align='center'>$myrow[Items]</td>
		<td align='center'>\$$myrow[Price]</td>
		<td align='center'>$myrow[Quantity]</td>
		<td align='center'>\$$myrow[TotalCost]</td> 
		<td align='center'><A HREF=\"javascript:decision('Are you sure you want to delete this Sale?','delete.php?id=$myrow[ID]')\">Delete Sale</A> </td>
		<td align='center'><A href='update.php?id=$myrow[ID]'>Change Sale</A></td></tr>");
		$TotalMoney+=$myrow[TotalCost];
		$GrossTotal+=$myrow[Price]*$myrow[Quantity];
	
	$k++;
	
                

}
while ($myrow = mysql_fetch_assoc($result)); 

		$TotalMoney=number_format($TotalMoney, 2, '.', ''); 
		$GrossTotal=number_format($GrossTotal, 2, '.', '');

		echo "</table>";
		echo "<P><div align='center'>Total Money For All Orders: <b>\$$TotalMoney</b></div>";
		echo "<P><div align='center'>Total Gross For All Orders: <b>\$$GrossTotal</b></div>";  
	




}
else
{
	echo "There are no records in the database."; 

}




?>
</body>
</html>
<? include ("../login/obend.php"); ?>