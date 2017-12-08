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
echo "<h3 align='center'>$company's Date Range Report</h3>";
$SmallReport=$_POST["SmallReport"];

 //Shows all orders based on a specific Date Range provided by the user! Very handy.
$DATEONE=$_POST["DATEONE"];
$DATETWO=$_POST["DATETWO"];
$Brands=$_POST["Brands"];
$Category=$_POST["Category"];

echo " <div align='center'><b>$DATEONE</b>----<b>$DATETWO</b></div><br>";
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);


if($SmallReport=="true")
{
$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" ORDER by Date",$db);
if($Category!="None" and $Brands!="None")
{
	echo "You can not select Brands  and Categories for a report.";
	exit;
} 

if($Brands!="None")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and Brand=\"$Brands\" ORDER by Date",$db);
	echo "<div align='center'>These items are brand <B>$Brands</b> only</div>";

} 

if($Category!="None")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and Category=\"$Category\" ORDER by Date",$db);
	echo "<div align='center'>These items are category <B>$Category</b> only</div>";

}


$k=0;
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr><th>Date Of Purchase</th>
	<th>Customer Name</th>
	<th>TotalCost</th>
	</tr>\n"; 
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
		<td align='center'>\$$myrow[TotalCost]</td> 
		</tr>"); 
		$MoneyRange+=$myrow[TotalCost];
    
    
    
       $k++;  

}
while ($myrow = mysql_fetch_assoc($result)); 

	
	$MoneyRange=number_format($MoneyRange, 2, '.', ''); 
	echo "</table>"; 
	echo "<P><div align='center'>Date Range Total: <b>\$$MoneyRange</b></div>";





}
else
{
	echo "There are no records in the database."; 

}
}
else
{
$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" ORDER by Date",$db);

if($Category!="None" and $Brands!="None")
{
	echo "You can not select Brands  and Categories for a report.";
	exit;
} 

if($Brands!="None")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and Brand=\"$Brands\" ORDER by Date",$db);
	echo "<div align='center'>These items are brand <B>$Brands</b> only</div>";

}  
if($Category!="None")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and Category=\"$Category\" ORDER by Date",$db);
	echo "<div align='center'>These items are category <B>$Category</b> only</div>";

}

$k=0;
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr><th>Date Of Purchase</th>
	<th>Customer Name</th><th>Item</th>
	<th>Price</th><th>Quantity</th>
	<th>Total Cost</th>
	</tr>\n"; 
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
		</tr>"); 
		$MoneyRange+=$myrow[TotalCost];
		$GrossTotal+=$myrow[Price]*$myrow[Quantity];
   
   
   $k++;            

}
while ($myrow = mysql_fetch_assoc($result)); 

	
	$MoneyRange=number_format($MoneyRange, 2, '.', '');
	$GrossTotal=number_format($GrossTotal, 2, '.', '');  
	echo "</table>"; 
	echo "<P><div align='center'>Date Range Total: <b>\$$MoneyRange</b></div>";
	echo "<P><div align='center'>Date Range Gross Total: <b>\$$GrossTotal</b></div>";
	




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