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
//a user can select a customer and then it will show all orders.
echo "<h3 align='center'>$company's Customer Report</h3>"; 
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
?>
<form action="customer.php" method="post" name="form">
<b>Customer Search:</b><input type="text" name="entry" size="15" onKeyUp=FilterList();>
	<table cellspacing="1">
		<tr>
			
			<td>Customer Name:</td>
			<td><?
$result = mysql_query("SELECT * FROM customers ORDER BY LastN",$db);

$YEAR=Date(Y);
echo"<select name=customer>";

while ($myrow = mysql_fetch_assoc($result))
{
	echo "<option value=\"$myrow[FirstN] $myrow[LastN] [$myrow[AccountNum]]\">$myrow[LastN], $myrow[FirstN] ($myrow[AccountNum])";
	 
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
				<p><input type="submit" name="Filter" value="Filter"></p>
</form>



<?
$DATEONE=$_POST["DATEONE"];
$DATETWO=$_POST["DATETWO"];
?>
<?
$Customer=$_POST['customer'];
$result = mysql_query("SELECT * FROM sales WHERE Customer=\"$Customer\" ORDER BY Date",$db);
if($DATEONE!="" AND $DATETWO!="")
{
	$result = mysql_query("SELECT * FROM sales WHERE Date between \"$DATEONE\" and \"$DATETWO\" and  Customer=\"$Customer\" ORDER by Date",$db);
	echo " <div align='center'><b>$DATEONE</b>----<b>$DATETWO</b></div><br>";
}

$k=0;
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	echo "<div align='center'>Orders for $Customer<P> </div>";
	echo "<table  align='center'>"; 
	echo "<tr>
	<th>Date</th>
	<th>Item Name</th>
	<th>Price</th><th>Quantity</th>
	<th>Total Cost</th></tr>\n"; 
do 
{
	if($k%2==0 )
	{
		$bgcolor='white';
	}
	else
	{
		$bgcolor=$rowcolor;
	}
		echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[Date]</td>
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
	echo "<P><div align='center'>Total Money Spent: <b>\$$MoneySpent</b></div>";
	echo "<P><div align='center'>Total Gross For Customer: <b>\$$GrossTotal</b></div>";



}
else
{
	echo "There are no orders for $Customer</b>."; 

}

?>
</body>
</html>
<SCRIPT LANGUAGE="JavaScript">

  selOptions=new Array(form.customer.options.length);
  selValues=new Array(form.customer.options.length);
  y=0;
  while (form.customer.options[y]!=null)
	{
		selOptions[y]=form.customer.options[y].text;
		selValues[y]=form.customer.options[y].value;
		y++;
	}
function FilterList() 
{
  a=0;
	while (form.customer.options[a]!=null)
	{
		a++;
	}
	while(a!=-1)
	{
		form.customer.options[a]=null;
		a--;
	}
	pos=0;
	for (k=0;k<selOptions.length;k++)
	{
	    r=0;
	    if(selOptions[k].length<form.entry.value.length )
      {
        newtemp=selOptions[k].length;
      }
      else
      {
        newtemp=form.entry.value.length;
      }
      for(j=0;j<newtemp;j++)
	    {
	       temp=selOptions[k];
         if (form.entry.value.charAt(j).toLowerCase()==temp.charAt(j).toLowerCase() )
	       {
	         r++;
	       }
	    }
	    if (r==form.entry.value.length )
	    {
	    	option1=new Option([selOptions[k]],[selValues[k]]);
	        form.customer.options[pos]=option1;
	        pos++;
	    }
	 }
}
//  End -->
</script>
<? include ("../login/obend.php"); ?>