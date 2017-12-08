<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/reports.php");
?>
<?
//Updates an order if there was a mistake.
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$ID=$_GET['id'];
$result = mysql_query("SELECT * FROM sales WHERE ID=$ID",$db);
$myrow = mysql_fetch_assoc($result);
$Tax=($myrow[TaxType]/100)+1;
?>
<html>

	<head>
		<SCRIPT language=javascript type="text/javascript"> 
		function calculate() 
{ 
document.updatereports.elements.TotalCost.value = 
(document.updatereports.elements.Price.value *document.updatereports.elements.Quantity.value*document.updatereports.elements.Tax.value);


var wd="w";
var tempnum = (document.updatereports.elements.Price.value *document.updatereports.elements.Quantity.value
*document.updatereports.elements.Tax.value);
tempnum = tempnum+'';
for (i=0;i<tempnum.length;i++)
{
   if (tempnum.charAt(i)==".")
   {
      wd="d";
      break;
   }
}
if (wd=="w")
{
   document.updatereports.elements.TotalCost.value=tempnum+'.00';
}
else
{
   tempnum=Math.round(tempnum*100)/100;
   tempnum = tempnum+'';
   var periodpos=tempnum.indexOf('.');
   if((tempnum.length-periodpos) == 2)
   {
      tempnum = tempnum+'0';
   }
   document.updatereports.elements.TotalCost.value = tempnum;
}

}
</script> 




		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Change Sale</title>
	</head>

	<body onload="calculate();" >
		<form action="updatereports.php" method="Post" name="updatereports">
			<table width="581" border="0" cellspacing="2" cellpadding="0" height="116">
				<tr>
					<td width="131">Date:</td>
					<td><input type="text" name="Date" size="26"  value=<? echo "\"$myrow[Date]\"" ?> ></td>
				</tr>
				<tr>
					<td width="131">Customer:</td>
					<td><input type="text" name="Customer" size="26" value=<? echo "\"$myrow[Customer]\"" ?>></td>
				</tr>
				<tr>
					<td width="131">Item:</td>
					<td><input type="text" name="Items" size="26" value=<? echo "\"$myrow[Items]\"" ?></td>
				</tr>
				<tr>
					<td width="131">Price:</td>
					<td><input type="text" name="Price" size="35" maxlength="10" class="blackCopy"  value=<? echo "\"$myrow[Price]\"" ?>
					onblur="calculate();" onKeyUp="calculate();this.focus();" onChange="calculate();"> 

 				</td>
				</tr>
			<tr>
			<tr>
					<td width="131">Quantity:</td>
					<td><input type="text" name="Quantity" size="35" maxlength="10" class="blackCopy" value=<? echo "\"$myrow[Quantity]\"" ?>
					onblur="calculate();" onKeyUp="calculate();this.focus();" onChange="calculate();"> </td>
				</tr>
				<tr>
					<td width="131">Total Cost:</td>
					<td><input type="text"  value=<? echo "\"$myrow[TotalCost]\"" ?> name="TotalCost" size="15" maxlength="15"> </td>
				</tr>
				</table>
			<input type="submit" name="Change Order" value="Change Order">&nbsp;&nbsp;<input type="reset" value="Reset To Previous">
			</table>
			<input type="HIDDEN" name="Tax" class="blackCopy" value=<? echo "\"$Tax\"" ?> >		
			<INPUT TYPE="HIDDEN" NAME="id" VALUE=<?echo $ID; ?> > 
			</form>
	</body>


</html>
<? include ("../login/obend.php"); ?>