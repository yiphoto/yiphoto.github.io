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
$YEAR=Date(Y); 
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

 ?>
<form action="tax.php" method="post" name="DateRange">
			<b>Select a date range to show tax: <font size='-2'> (To show Total Tax do not enter dates)</font>
				<table width="325" border="0" cellspacing="2" cellpadding="0">
					<tr>
						<td>From: </td>
						<td><input type="text" name="DATEONE" size="12" <? echo "value=$YEAR-" ?>>[YYYY-MM-DD]</td>
					</tr>
					<tr>
						<td>To:</td>
						<td><input type="text" name="DATETWO" size="12" <? echo "value=$YEAR-" ?>>[YYYY-MM-DD]</td>
					</tr>
					
			
<tr>
<td>Filter Tax</td>
<td>

<select name=TAXFILTER>
<option value="">None</option>
<?
$result = mysql_query("SELECT * FROM sales ORDER BY Date",$db);
while ($myrow = mysql_fetch_assoc($result))
{
	$j=$myrow[TaxType];
	if (!array_key_exists("$j",$taxlevel))
	{
		echo"<option value=$j>$j</option>";
		$taxlevel[$j]=0;
	}
}
?>
	</select>
	
	
	</tr>
	</table>
				<p><input type="submit" name="Filter" value="Filter"></p>
				</form>




<?
$DATEONE=$_POST["DATEONE"];
$DATETWO=$_POST["DATETWO"];
$TAXFILTER=$_POST["TAXFILTER"];



// Shows any tax totals and it also shows the totals for both taxes combined.

echo "<h3 align='center'>$company's Tax Report</h3>";
$result = mysql_query("SELECT * FROM sales ORDER by Date",$db);

if($TAXFILTER=="" AND $DATEONE!="" AND $DATETWO!="")
{
	$result = mysql_query("SELECT * FROM sales WHERE  Date between \"$DATEONE\" and \"$DATETWO\" ORDER by Date",$db);
	echo " <div align='center'><b>$DATEONE</b>----<b>$DATETWO</b></div><br>";
}

if($TAXFILTER!="" AND $DATEONE=="" AND $DATETWO=="")
{

	$result = mysql_query("SELECT * FROM sales WHERE TaxType=\"$TAXFILTER\" ORDER by Date",$db);


}

if($TAXFILTER!="" AND $DATEONE!="" AND $DATETWO!="")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and TaxType=\"$TAXFILTER\" ORDER by Date",$db);
	echo " <div align='center'><b>$DATEONE</b>----<b>$DATETWO</b></div><br>";

}


echo "<table cellspacing='1' align='center'>
<tr>
<th align='center'>Date Purchased</th>
<th align='center'>Item Purchased</th>
<th align='center'>Quantity</th>
<th align='center'>Cost (w/Tax)</th>
<th align='center'>Cost (w/o Tax)</th>
<th align='center'>Tax Type</th>
<th align='center'>Tax On Item</th>
</tr>";

$k=0;
while ($myrow = mysql_fetch_assoc($result))
{

$PriceNoTax=$myrow[TotalCost]-$myrow[Tax];
$PriceNoTax=number_format($PriceNoTax, 2, '.', '');
$TotalTax+=$myrow[Tax];
$TotalGross+=$myrow[TotalCost]-$myrow[Tax];
$TotalGross=number_format($TotalGross, 2, '.', '');
$TotalTax=number_format($TotalTax, 2, '.', '');

if($k%2==0)
{	
	$bgcolor='white';
}
else
{
	$bgcolor="$rowcolor";

}
	echo"
	<tr bgcolor='$bgcolor'> 
	<td align='center'>$myrow[Date]</td> 
	<td align='center'>$myrow[Items]</td>
	<td align='center'>$myrow[Quantity]</td>
	<td align='center'>\$$myrow[TotalCost]</td>
	<td align='center'>\$$PriceNoTax</td>
	<td align='center'>$myrow[TaxType]</td>
	<td align='center'>\$$myrow[Tax]</td>
	</tr>";

	$k++;
}

echo "</table>";
echo"<br><br>";

echo"<div align='center'><B>Total Tax $TAXFILTER: \$$TotalTax</b></div><BR>";
echo"<div align='center'><B>Total Gross Earnings $TAXFILTER: \$$TotalGross</b></div>"

?>
</body>
</html>
<? include ("../login/obend.php"); ?>