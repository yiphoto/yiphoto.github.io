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
//a user can select an item and then it will show all orders.
echo "<h3 align='center'>$company's Brand Report</h3>";
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$YEAR=Date(Y);
?>
<form action="brand.php" method="post" name="Brand">
	<table cellspacing='1' cellpadding="0">
		<tr>
			<td>Brand Name:</td>
			<td><?
$result = mysql_query("SELECT * FROM brands ORDER BY Brand",$db);
echo"<select name=Brand>";

while ($myrow = mysql_fetch_assoc($result))
{
	echo "<option value=\"$myrow[Brand]\">$myrow[Brand]";
	 
}
?></td>
			
		</tr>
	</table>
	<b>Select a date range to show orders:<font size='-2'> (To show all orders do not enter dates)
				<table width="325" border="0" cellspacing="2" cellpadding="0">
					<tr>
						<td>From: </td>
						<td><input type="text" name="DATEONE" size="12" <? echo "value=$YEAR-" ?>>[YYYY-MM-DD]</td>
					</tr>
					<tr>
						<td>To:</td>
						<td><input type="text" name="DATETWO" size="12" <? echo "value=$YEAR-" ?>>[YYYY-MM-DD]</td>
					</tr>
				</table>
				<input type="submit" name="Show Orders!" value="Show Orders!">
</form>
<?
$DATEONE=$_POST["DATEONE"];
$DATETWO=$_POST["DATETWO"];
$Brand=$_POST['Brand'];
$result = mysql_query("SELECT * FROM sales WHERE Brand=\"$Brand\" ORDER BY Date",$db);
if($DATEONE!="" AND $DATETWO!="")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and  Brand=\"$Brand\" ORDER by Date",$db);
	echo " <div align='center'><b>$DATEONE</b>----<b>$DATETWO</b></div><br>";
}

$k=0;
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	echo" <div align='center'>Orders for $Brand<P> </div>";
	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr>
	<th>Date</th>
	<th>Customer</th>
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
		echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[Date]</td>
		<td align='center'>$myrow[Customer]</td>
		<td align='center'>$myrow[Items]</td>
		<td align='center'>\$$myrow[Price]</td>
		<td align='center'>$myrow[Quantity]</td>
		<td align='center'>\$$myrow[TotalCost]</td></tr>"); 
		$MoneySpent+=$myrow[TotalCost];
		$GrossTotal+=$myrow[Price]*$myrow[Quantity];
	
	
	$k++;
	
                

}
while ($myrow = mysql_fetch_assoc($result)); 
	
	$MoneySpent=number_format($MoneySpent, 2, '.', '');
	$GrossTotal=number_format($GrossTotal, 2, '.', ''); 
	echo "</table>"; 
	echo "<P><div align='center'>Total Money for Item: <b>\$$MoneySpent</b></div>";
	echo "<P><div align='center'>Total Gross for Item: <b>\$$GrossTotal</b></div><BR>";




}
else
{
	echo "There are no orders for $Brand</b>."; 

}

?>
</body>
</html>
<? include ("../login/obend.php"); ?>