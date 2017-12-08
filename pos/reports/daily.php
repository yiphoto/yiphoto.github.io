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
echo "<a href=daily.php?SmallReport=true>Small Report</a><br>
<a href=daily.php>Large Report</a>
<h3 align='center'>$company's Daily Report</h3>";

$SmallReport=$_GET["SmallReport"];
//Shows all the orders for the day it is now!
$Date=date("Ymd");
$ShowDate=date("F j,Y");
echo "<div align=center> $ShowDate</div><br>";

$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);




if($SmallReport=="true")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date=$Date",$db);

	$k=0;
	if ($myrow = mysql_fetch_assoc($result)) 
	{ 
		echo "<table cellspacing='1' align='center'>"; 
		echo "<tr><th>Customer Name</th>
		<th>Order Cost</th></tr>\n"; 
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
        	echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[Customer]</td>
			<td align='center'>\$$myrow[TotalCost]</td></tr>");
			$TotalMoney+=$myrow[TotalCost];
        
        
        $k++;   

	}
		while ($myrow = mysql_fetch_assoc($result)); 
		echo "</table>";
		$TotalMoney=number_format($TotalMoney, 2, '.', ''); 
		echo "</table>";
		echo "<P><div align='center'>Daily Total: <b>\$$TotalMoney</b></div>";
		}
	else
	{
		echo "There are no records in the database."; 

	}

}
else
{

$result = mysql_query("SELECT * FROM sales WHERE Date=$Date",$db);
$k=0;
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr><th>Customer Name</th>
	<th>Item Name</th>
	<th>Price</th><th>Quantity</th>
	<th>Total Cost</th></tr>\n"; 
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
		echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[Customer]</td>
		<td align='center'>$myrow[Items]</td>
		<td align='center'>\$$myrow[Price]</td>
		<td align='center'>$myrow[Quantity]</td>
		<td align='center'>\$$myrow[TotalCost]</td></tr>");
		$TotalMoney+=$myrow[TotalCost]; 
		$GrossTotal+=$myrow[Price]*$myrow[Quantity];
	
	
	
	
	$k++;
                

}
while ($myrow = mysql_fetch_assoc($result)); 

	$TotalMoney=number_format($TotalMoney, 2, '.', '');
	$GrossTotal=number_format($GrossTotal, 2, '.', ''); 
 
	echo "</table>";
	echo "<P><div align='center'>Daily Total: <b>\$$TotalMoney</b></div>";
	echo "<P><div align='center'>Daily Gross Total: <b>\$$GrossTotal</b></div>";  




}
else
{
	echo "There are no records in the database."; 

}

}
?>
</body>
</html>
<? include ("../login/obend.php"); ?>
