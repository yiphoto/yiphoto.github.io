<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/users.php");
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
<h3 align='center'> Manage Users</h3>
<form action="manageusers.php" method="post" name="Search">
	Search:<input type="text" name="SEARCH" size="24"><input type="submit" name="Search" value="Search">
	<p></p>
</form>[<a href="manageusers.php">Show All Users</a>]
<?
//Basic information to connect to the database.
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

//Gets the search String.
$SEARCH=$_POST['SEARCH'];


$result = mysql_query("SELECT * FROM users ORDER BY RealName",$db);

//Checks to see if there was a search, if there was then it will perform the search.
if(isset($SEARCH))
{
	$result = mysql_query("SELECT * FROM users WHERE RealName like \"%$SEARCH%\" or Username like \"%$SEARCH%\" ORDER BY RealName",$db); 
	echo "<div align='center'>Search for: <b>$SEARCH</b></div>";

}

/*Outputs the info based on the mysql query.  
It also has links to the delete and update pages, which delete based on id.
*/

$k=0;
if ($myrow = mysql_fetch_assoc($result)) 
{ 
	
	echo "<table  align='center'>"; 
	echo "<tr><th>Real Name</th>
	<th>Username</th>
	<th>Password</th>
	<th>Type</th>
	<th>Delete User</th>
	<th>Update User</th></tr>\n"; 
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
    	echo("<tr bgcolor='$bgcolor'><td align='center'>$myrow[RealName]</td>
		<td align='center'>$myrow[Username]</td>
		<td align='center'>$myrow[Password]</td>
		<td align='center'>$myrow[Type]</td>
		<td align='center'><A HREF=\"javascript:decision('Are you sure you want to delete this User?','delete.php?id=$myrow[ID]')\">Delete User</A> </td>
		<td align='center'><A href='update.php?id=$myrow[ID]'>Update User</A></td> </tr>"); 
    
    
    
    
    
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


