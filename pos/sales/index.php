<? include ("../login/session.php");
include ("../settings.php");
include ("../authorization/sales.php"); ?>

<html>
<head>
<title>New Sale</title>
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 

</head>
<body>

<div align="center">
	<h3 align="center">New Sale</h3>
	<form action="index.php" method="post">
		<div align="center">
			Item Search: <input type="text" name="SEARCH" size="24"><input type="submit" name="Search" value="Search"></div>
	</form>
	
	<?
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
?>
	<form action=index.php method=post>
		<div align="center">
			<table cellspacing="1">
				<tr>
					<td>Filter Items by Category:</td>
					<td>
<? 
					
//The code that shows the popup box and a user can sort by Category for easier selecting of items.
$result = mysql_query("SELECT * FROM categories ORDER BY Category",$db);
echo"<select name=Category>";
while ($myrow = mysql_fetch_assoc($result))
{

	echo "<option value=\"$myrow[Category]\">$myrow[Category]</option>";

}
echo"</select></td><td>
<input type=submit value=Filter></td></tr></form>";
?>
				
				<form action=index.php method=post>
					<tr>
						<td>Filter Items by Brand:</td>
						<td><? 
//The code that shows the popup box and a user can sort by Brand for easier selecting of items.
$result = mysql_query("SELECT * FROM brands ORDER BY BRAND",$db);
echo"<select name=Brand>";
while ($myrow = mysql_fetch_assoc($result))
{

	echo "<option value=\"$myrow[Brand]\">$myrow[Brand]</option>";

}
echo"</select></td><td>
<input type=submit value=Filter></td></tr></table></form>";
?>
					
			
			<p>[<a href="index.php">Show All</a>]</p>
		</div>
	</form>
	<hr>
	
		<div align="center">
			<h3>Order Information</h3>
			
			<form action=addsale.php method=post name="form" onSubmit="javascript:window.location = document.menuform.itemlist.options[document.menuform.itemlist.selectedIndex].value;return false;" >
			<table cellspacing='1'>
			<font face="arial, helvetica" size="-1">Please enter the first few letters of the Customer you are looking for</font>
<br><br>
<input type="text" name="entry" size="30" onKeyUp="FilterList();">
<br>
			
			<tr>
					<td><b>Customer</b>:</td>
					<td colspan="2"><select name="customer">
	<?

//Shows all the customers in a popup box.
$result = mysql_query("SELECT * FROM customers ORDER BY LastN",$db);

while ($myrow = mysql_fetch_assoc($result))
{
	
	echo "<option value=\"$myrow[FirstN] $myrow[LastN] [$myrow[AccountNum]]\">$myrow[LastN], $myrow[FirstN] ($myrow[AccountNum])";
	 
}
?>
						</select></td>
					
					<br>
				</tr>
				<tr>
					<td align="center"><b>Items</b></td>
					<td align="center"><b>Price</b></td>
					<td align="center"><b>Quanity To Order</b></td>
<?


$Brand=$_POST['Brand'];
$Category=$_POST['Category'];
mysql_select_db("mydb",$db);
$result = mysql_query("SELECT * FROM items ORDER BY ItemName",$db);
$SEARCH=$_POST['SEARCH'];

//Checks to see what query to do do sorting takes place. (Search, Filter by category or brand)
if(isset($SEARCH))
{
	$result = mysql_query("SELECT * FROM items WHERE ItemName like \"%$SEARCH%\" ORDER BY ItemName",$db); 
	echo "<div align='center'>Search for: <b>$SEARCH</b></div>";

}


if(isset($Category))
{
	echo "Items Filtered by Category: <b> $Category </b><BR>";
	$result = mysql_query("SELECT * FROM items WHERE Category= \"$Category\" ORDER BY ItemName",$db);
}

if(isset($Brand))
{
	echo "Items Filtered by Brand: <b> $Brand </b><BR>";
	$result = mysql_query("SELECT * FROM items  WHERE Brand= \"$Brand\" ORDER BY ItemName",$db);
}
$counter=0;
while ($myrow = mysql_fetch_assoc($result))
{

echo "<tr bgcolor='white'><td>$myrow[ItemName]</td> 
<td><input type=text name=price$counter size='6' value=\"$myrow[Price]\"</td> 
<td><input type=text size=3 name=quantity$counter></td></tr> 
<input type=hidden name=ID$counter value=\"$myrow[ID]\" > 
<input type=hidden name=Quantity$counter value=\"$myrow[Quantity]\"> 
<input type=hidden name=Tax$counter value=\"$myrow[Tax]\" >
<input type=hidden name=ItemID$counter value=\"$myrow[ItemID]\" >
<input type=hidden name=item$counter value=\"$myrow[ItemName]\">
<input type=hidden name=Brand$counter value=\"$myrow[Brand]\">
<input type=hidden name=Category$counter value=\"$myrow[Category]\">";
$counter++; 
 }

echo "<input type=hidden name=counter value=$counter>"; 
 

?>
</tr>
				<tr>
					<td colspan="3" align="right"><input type="submit" value="Place Order"></td>
				</tr>
			</table>
		</div>
	</form>
</div>
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
		
