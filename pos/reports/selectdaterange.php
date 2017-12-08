<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/reports.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?
//The form to select the date range to show orders.  It also shows the current year (in form)
$YEAR=Date(Y);
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$result = mysql_query("SELECT * FROM sales ORDER BY Date",$db);
?>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Date Range</title>
	</head>

	<body bgcolor="#ffffff">
		<form action="daterange.php" method="post" name="DateRange">
			<b>Select a date range to show orders:
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
						<td>Small Report:</td><P> 
						<td><input type="radio" name="SmallReport" size="12" value="true" ></td>
					</tr>
					<tr>
						<td>Large Report:</td>
						<td><input type="radio" name="SmallReport" size="12" value="false"></td>
					</tr>
				</table>
				
			</b>
			<BR>
			
			<?
			
			echo "<table  border='0' cellspacing='2' cellpadding='0'>";
			echo "<b><font size='-2'>(Select either Brands or Categories  Only!)</font></p></b>";
			$result = mysql_query("SELECT * FROM Brands ORDER BY Brand",$db);
			echo "<tr><td> Brands: </td>";
			echo "<td><select name='Brands' size='1'>";
			echo "<option value=None>None</option>";
			while ($myrow = mysql_fetch_assoc($result))
			{
				
				echo "<option value=\"$myrow[Brand]\">$myrow[Brand]</option>";
				
			}
			
			
			echo "</select></td></tr>";
			
			$result = mysql_query("SELECT * FROM Categories ORDER BY Category",$db);
			echo "<tr><td> Categories: </td>";
			echo "<td><select name='Category' size='1'>";
			echo "<option value=None>None</option>";
			while ($myrow = mysql_fetch_assoc($result))
			{
				
				echo "<option value=\"$myrow[Category]\">$myrow[Category]</option>";
				
			}
			
			
			echo "</select></td></tr></table>";
			
			?>
			
			<p><input type="submit" name="Filter" value="Filter"></p>
		</form>
		<p></p>
	</body>

</html>
<? include ("../login/obend.php"); ?>
