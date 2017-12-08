<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/customers.php");
?>
<html>
<head>
<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url){
if(confirm(message)) location.href = url;
}
// --->
</SCRIPT> 
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css">

</head>
<body>
<h3 align='center'> Manage Customers</h3>
<form action="managecustomers.php" method="post" name="Search">
	Search:<input type="text" name="SEARCH" size="24"><input type="submit" name="Search" value="Search">
	<p></p>
</form>[<a href="managecustomers.php">Show All Customers</a>]
<?
//Basic information to connect to the database.
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

//Gets the search String.
$SEARCH=$_POST['SEARCH'];


$result = mysql_query("SELECT * FROM customers ORDER BY LastN",$db);

//Checks to see if there was a search, if there was then it will perform the search.
if(isset($SEARCH))
{
	$result = mysql_query("SELECT * FROM customers WHERE FirstN like \"%$SEARCH%\" or LastN like \"%$SEARCH%\"or AccountNum like \"%$SEARCH%\" ORDER BY LastN",$db); 
	echo "<div align='center'>Search for: <b>$SEARCH</b></div>";
}

/*Outputs the info based on the mysql query.  
It also has links to the delete and update pages, which delete based on id.
*/

$k=0;
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	
	echo "<table cellspacing='1' align='center'>"; 
	echo "<tr><th>Last Name</th><th>First Name</th>
	<th>Account Number</th><th>Phone Number</th>
	<th>Comments</th><th>Delete Customer</th>
	<th>Update Customer</th></tr>\n"; 
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
	
		echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[LastN]</td>
		<td align='center'>$myrow[FirstN]</td>
		<td align='center'>$myrow[AccountNum]</td>
		<td align='center'>$myrow[PhoneNum]</td>
		<td align='center'>$myrow[Comments]</td>
		<td align='center'><A HREF=\"javascript:decision('Are you sure you want to delete this Customer?','delete.php?id=$myrow[ID]')\">Delete Customer</A> </td>
		<td align='center'><A href='update.php?id=$myrow[ID]'>Update Customer</A></td> </tr>"); 
	
	
	$k++;
                
                

}
while ($myrow = mysql_fetch_assoc($result)); 

	echo "</table>"; 




}
else
{
	echo "There are no records in the database."; 

}
?>
</body>
</html>
<? include ("../login/obend.php"); ?>


