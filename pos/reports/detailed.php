<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/reports.php");
?>
<html>
<head>
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
</head>
<body>
<? $YEAR=Date(Y); ?>
<?
echo "<h3 align='center'>$company's Detailed Report</h3>";
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
?>
<a href="detailed.php?Report=large">Large Report</a>
<br>
<a href="detailed.php?Report=small">Small Report</a>
<p>
<form action="detailed.php" method="post" name="detailed">
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
					<tr><td colspan="3">Large Report<input type=radio name=filterReport value="large"></td>
					</tr>
					<tr><td colspan="3">Small Report<input type=radio name=filterReport value="small"></td>
				</table>
				<p><input type="submit" name="Filter" value="Filter"></p>
				</form>




<?
$filterReport=$_POST["filterReport"];
$DATEONE=$_POST["DATEONE"];
$DATETWO=$_POST["DATETWO"];
$Report=$_GET['Report'];
if($DATEONE!="" && $DATETWO!="" )
{
	echo " <div align='center'><b>$DATEONE</b>----<b>$DATETWO</b></div><br>";
}

if(isset($filterReport) )
{
	if($filterReport=="large" )
	{
		$Report="large";

	}
}

if($Report=="large" )
{
echo "<h2 align='center'>Categories</h2><BR>";
$result = mysql_query("SELECT * FROM categories ORDER BY Category",$db);
while ($myrow = mysql_fetch_assoc($result))
{
	$Category=array();
	$Items=array();
	$j=$myrow[Category];
	$CategoryTotal=0;
	if (!array_key_exists("$j",$Category) )
	{		echo "<h4 align='center'>$j</h4>";
			echo "<table cellspacing='1' align='center'>"; 
			echo "<tr><th>Item</th>
			<th>Items Sales</th>
			<th>Sales w/ Tax</th>
			<th># Sold</th>
			</tr>\n";
			
		$newresult = mysql_query("SELECT * FROM sales WHERE Category=\"$j\" ORDER BY Items",$db);
		
		$k=0;
		while ($myrow = mysql_fetch_assoc($newresult))
		{	
		
			
			
			$a=$myrow[Items];
			if (!array_key_exists("$a",$Items) )
			{
				
				
				$MoneySpent=0;
				$TotalMoneySpent=0;
				$Num=0;
				$CostResult = mysql_query("SELECT * FROM sales WHERE Items=\"$a\"",$db);
				if($DATEONE!="" AND $DATETWO!="" )
				{
					$CostResult = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and Items=\"$a\" ORDER by Date",$db);
	
				}

				while($myrow = mysql_fetch_assoc($CostResult))
				{
					$CategoryTotal+=$myrow[TotalCost]-$myrow[Tax];
					$Num+=$myrow[Quantity];
					$MoneySpent+=$myrow[TotalCost]-$myrow[Tax];
					$TotalMoneySpent+=$myrow[TotalCost];
				}
				
			$CategoryTotal=number_format($CategoryTotal, 2, '.', ''); 
			$MoneySpent=number_format($MoneySpent, 2, '.', ''); 
			$TotalMoneySpent=number_format($TotalMoneySpent, 2, '.', ''); 
			
		if($k%2==0)
		{	
			$bgcolor='white';
		}
		else
		{
			$bgcolor="$rowcolor";

		}
				echo("<tr bgcolor='$bgcolor'><td align='center'>$a</td>
				<td align='center'>\$$MoneySpent</td>
				<td align='center'>\$$TotalMoneySpent</td>
				<td align='center'>$Num</td>
				</tr>");
			
			
			$k++;
			$Items[$a]=0;
			}
		}
		$Category[$j]=0;
		
		
	}
	echo"</table>";
	echo "<table align='center'>
	<tr><td align='center'>Total Category Sales: \$$CategoryTotal</td></tr>
	</table>";
}

echo "<HR>";



echo "<BR><BR><h2 align='center'>Brands</h2><BR>";

$result = mysql_query("SELECT * FROM brands ORDER BY Brand",$db);

while ($myrow = mysql_fetch_assoc($result))
{
	$Brand=array();
	$Items=array();
	$BrandTotal=0;
	$j=$myrow[Brand];
	if (!array_key_exists("$j",$Brand) )
	{		echo "<h4 align='center'>$j</h4>";
			echo "<table cellspacing='1' align='center'>"; 
			echo "<tr><th>Item</th>
			<th>Items Sales</th>
			<th>Sales w/ Tax</th>
			<th># Sold</th>
			</tr>\n";
			
		$newresult = mysql_query("SELECT * FROM sales WHERE Brand=\"$j\" ORDER BY Items",$db);
		
		$k=0;
		while ($myrow = mysql_fetch_assoc($newresult))
		{	
		
			
			
			$a=$myrow[Items];
			if (!array_key_exists("$a",$Items) )
			{
				
				
				$MoneySpent=0;
				$TotalMoneySpent=0;
				$Num=0;
				
				$CostResult = mysql_query("SELECT * FROM sales WHERE Items=\"$a\"",$db);
				if($DATEONE!="" AND $DATETWO!="" )
				{
					$CostResult = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and Items=\"$a\" ORDER by Date",$db);
	
				}
				while($myrow = mysql_fetch_assoc($CostResult))
				{
					$BrandTotal+=$myrow[TotalCost]-$myrow[Tax];
					$Num+=$myrow[Quantity];
					$MoneySpent+=$myrow[TotalCost]-$myrow[Tax];
					$TotalMoneySpent+=$myrow[TotalCost];
					
				}
				
			$FinalMoneySpent+=$MoneySpent;
			$FinalTotalMoneySpent+=$TotalMoneySpent;
			$BrandTotal=number_format($BrandTotal, 2, '.', '');
			$MoneySpent=number_format($MoneySpent, 2, '.', ''); 
			$TotalMoneySpent=number_format($TotalMoneySpent, 2, '.', ''); 
			if($k%2==0 )
			{
				echo("<tr><td align='center'>$a</td>
				<td align='center'>\$$MoneySpent</td>
				<td align='center'>\$$TotalMoneySpent</td>
				<td align='center'>$Num</td>
				</tr>");
			}
			else
			{
				echo("<tr bgcolor='$rowcolor'><td align='center'>$a</td>
				<td align='center'>\$$MoneySpent</td>
				<td align='center'>\$$TotalMoneySpent</td>
				<td align='center'>$Num</td>
				</tr>");
			
			}
			$k++;
			$Items[$a]=0;
			}
		}
		$Brand[$j]=0;
		
		
		
	}
	echo"</table>";
	echo "<table align='center'>
	<tr><td align='center'>Total Brand Sales: \$$BrandTotal</td></tr>
	</table>";
}
}
else
{
echo "<h2 align='center'>Categories</h2><BR>";

echo "<table align='center'>
<th align='center'>Category</th>
<th align='center'>Category Sales</th>
<th align='center'>Category Sales w/Tax</th>";
$result = mysql_query("SELECT * FROM categories ORDER BY Category",$db);

$k=0;
while ($myrow = mysql_fetch_assoc($result))
{
	$Category=array();
	$Items=array();
	$j=$myrow[Category];
	$CategoryTotal=0;
	$CategoryTotalTax=0;
	$MoneySpent=0;
	$TotalMoneySpent=0;
	$Num=0;	
			
		$newresult = mysql_query("SELECT * FROM sales WHERE Category=\"$j\" ORDER BY Items",$db);
		if($DATEONE!="" AND $DATETWO!="" )
		{
			$newresult = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and Category=\"$j\" ORDER by Date",$db);
	
		}
		while ($myrow = mysql_fetch_assoc($newresult))
		{	
		
			$a=$myrow[Items];
			$CategoryTotal+=$myrow[TotalCost]-$myrow[Tax];
			$CategoryTotalTax+=$myrow[TotalCost];
			$Num+=$myrow[Quantity];
			$MoneySpent+=$myrow[TotalCost]-$myrow[Tax];
			$TotalMoneySpent+=$myrow[TotalCost];
				
				
			
			
		}
			$CategoryTotal=number_format($CategoryTotal, 2, '.', '');
			$CategoryTotalTax=number_format($CategoryTotalTax, 2, '.', '');  
			$MoneySpent=number_format($MoneySpent, 2, '.', ''); 
			$TotalMoneySpent=number_format($TotalMoneySpent, 2, '.', ''); 
	if($k%2==0 )
	{		
		echo "<tr><td align='center'>$j</td>
		<td align='center'>\$$CategoryTotal</td>
		<td align='center'>\$$CategoryTotalTax</td>
		</tr>";
	}
	else
	{
		echo "<tr bgcolor='$rowcolor'><td align='center'>$j</td>
		<td align='center'>\$$CategoryTotal</td>
		<td align='center'>\$$CategoryTotalTax</td>
		</tr>";
	
	
	}
	$k++;
}
echo"</table>";
echo"<hr>";


echo "<h2 align='center'>Brands</h2><BR>";
echo "<table align='center'>
<th align='center'>Brand</th>
<th align='center'>Brand Sales</th>
<th align='center'>Brand Sales w/Tax</th>";
$result = mysql_query("SELECT * FROM brands ORDER BY Brand",$db);

$k=0;
while ($myrow = mysql_fetch_assoc($result))
{
	$Brand=array();
	$Items=array();
	$BrandTotal=0;
	$BrandTotalTax=0;
	$MoneySpent=0;
	$TotalMoneySpent=0;
	$Num=0;
	$j=$myrow[Brand];
		
	$newresult = mysql_query("SELECT * FROM sales WHERE Brand=\"$j\" ORDER BY Items",$db);
	if($DATEONE!="" AND $DATETWO!="" )
	{
		$newresult = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and Brand=\"$j\" ORDER by Date",$db);
	
	}
	
	while ($myrow = mysql_fetch_assoc($newresult))
	{	
			$BrandTotal+=$myrow[TotalCost]-$myrow[Tax];
			$BrandTotalTax+=$myrow[TotalCost];
			$Num+=$myrow[Quantity];
			$MoneySpent+=$myrow[TotalCost]-$myrow[Tax];
			$TotalMoneySpent+=$myrow[TotalCost];
			
			
	}
			$FinalMoneySpent+=$MoneySpent;
			$FinalTotalMoneySpent+=$TotalMoneySpent;
			$BrandTotal=number_format($BrandTotal, 2, '.', '');
			$BrandTotalTax=number_format($BrandTotalTax, 2, '.', '');  
			$MoneySpent=number_format($MoneySpent, 2, '.', ''); 
			$TotalMoneySpent=number_format($TotalMoneySpent, 2, '.', ''); 
			
		if($k%2==0)
		{	
			$bgcolor='white';
		}
		else
		{
			$bgcolor="$rowcolor";

		}
			echo "<tr bgcolor='$bgcolor'><td align='center'>$j</td>
			<td align='center'>\$$BrandTotal</td>
			<td align='center'>\$$BrandTotalTax</td>
			</tr>";

	$k++;	
}
echo"</table>";







}
$FinalMoneySpent=number_format($FinalMoneySpent, 2, '.', ''); 
$FinalTotalMoneySpent=number_format($FinalTotalMoneySpent, 2, '.', ''); 
echo"<div align='center'><BR><BR>Sub Total: <B>\$$FinalMoneySpent</B><BR>Total: <B>\$$FinalTotalMoneySpent<B></div>";
?>

</body>
</html>
<?include ("../login/obend.php"); ?>