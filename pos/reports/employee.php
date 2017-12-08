<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/reports.php");
?>
<html>
<head>
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
</head>
<body>
<?
echo "<h3 align='center'>$company's Employee Report</h3>
<form action='employee.php' method='post' name='Search'>
	Search:<input type='text' name='SEARCH' size='24'>
	<input type='submit' name='Search' value='Search'>
</form>[<a href='employee.php'>Show All Orders</a>]";


//Shows all orders and gives the ability to delete and update orders!
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$SEARCH=$_POST['SEARCH'];

$result = mysql_query("SELECT * FROM sales ORDER BY Date",$db);
//Checks to see if the user is searching for an order.
if(isset($SEARCH) )
{
	$result = mysql_query("SELECT * FROM sales WHERE Customer like \"%$SEARCH%\" or Items like \"%$SEARCH%\"  or SoldBy like \"%$SEARCH%\" ORDER BY Date",$db); 
	echo "<div align='center'>Search for: <b>$SEARCH</b></div>";

}
if ($myrow = mysql_fetch_assoc($result)) 
{
	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr><th>Date Of Purchase</th>
	<th>Sold By</th>
	<th>Customer Name</th>
	<th>Item Name</th>
	<th>Price</th><th>Quantity</th>
	<th>Total Cost</th></tr>\n";
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
		echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[Date]</td>
		<td align='center'>$myrow[SoldBy]</td>
		<td align='center'>$myrow[Customer]</td>
		<td align='center'>$myrow[Items]</td>
		<td align='center'>\$$myrow[Price]</td>
		<td align='center'>$myrow[Quantity]</td>
		<td align='center'>\$$myrow[TotalCost]</td></tr>");
		$TotalMoney+=$myrow[TotalCost];
		$NetTotal+=$myrow[Price]*$myrow[Quantity]; 
	
	
		$k++;
}
while ($myrow = mysql_fetch_assoc($result));



		$TotalMoney=number_format($TotalMoney, 2, '.', ''); 
		$NetTotal=number_format($NetTotal, 2, '.', '');

		echo "</table>";
		echo "<P><div align='center'>Sub Total For All Orders: <b>\$$NetTotal</b></div>";
		echo "<P><div align='center'>Total Money For All Orders: <b>\$$TotalMoney</b></div>";
		  
}
else
{
	echo "There are no orders in the database.</b>."; 

}



?>
</body>
</html>
<? include ("../login/obend.php"); ?>
