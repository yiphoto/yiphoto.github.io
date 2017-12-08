<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/reports.php");
?>
<html>
<head>
<? $YEAR=Date(Y); ?>
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
</head>
<body>
<form action="totals.php" method="Post">
<b>Select a date range to show Totals:<font size='-2'> (To show Total Totals do not enter dates)</font>
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
//Shows the Totals for both taxes, all money without taxes and with.
echo "<h3 align='center'>$company's Totals Report</h3>";
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$YEAR=Date(Y);
$result = mysql_query("SELECT * FROM sales",$db);
if($DATEONE!="" AND $DATETWO!="")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\"",$db);
	echo " <div align='center'><b>$DATEONE</b>----<b>$DATETWO</b></div><br>";
}



echo "<table cellspacing='1' align='center'>
<tr>
<th align='center'>Total Money (w/tax)</th>
<th align='center'>Total Money (w/o tax)</th>
</tr>";
$myrow['TotalCost']=number_format($myrow['TotalCost'], 2, '.', '');

while ($myrow = mysql_fetch_assoc($result))
{ 

	$TotalMoney+=$myrow['TotalCost'];
	$TotalMoneyNoTax+=$myrow['TotalCost']-$myrow['Tax'];
	

}

$TotalMoney="$".number_format($TotalMoney, 2, '.', '');
$TotalMoneyNoTax="$".number_format($TotalMoneyNoTax, 2, '.', '');       
echo "
<tr bgcolor='white'>
<td align='center'>$TotalMoney</td>
<td align='center'>$TotalMoneyNoTax</td>
</tr> </table>";

?>
</body>
</html>
<? include ("../login/obend.php"); ?>