<?
//Gets the info that was typed in on the form.
$company=$_POST["company"];
$address=$_POST["address"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$server=$_POST["server"];
$database=$_POST["database"];
$username=$_POST["username"];
$password=$_POST["password"];
$backgroundcolor=$_POST["backgroundcolor"];
$borderwidth=$_POST["borderwidth"];
$borderstyle=$_POST["borderstyle"];
$textcolor=$_POST["textcolor"];
$alink=$_POST["alink"];
$vlink=$_POST["vlink"];
$pcolor=$_POST["pcolor"];
$hcolor=$_POST["hcolor"];
$ContextualMenu=$_POST["ContextualMenu"];
$rowcolor=$_POST['rowcolor'];

if($ContextualMenu=="set")
{
	$menu="set";

}
else
{

	$menu="notset";

}

//Checks to make sure the required fields were filled out.
if($server=='' or $database=='' or $username=='' or $password=='' or $company=='' or $phone=='' or $backgroundcolor=='' or $borderwidth=='' or $borderstyle=='' or $textcolor=='' or $alink=='' or $vlink=='' or $pcolor=='' or $hcolor=='' or $rowcolor=='')
{
	echo "You did not provide all the required fields";
	exit; 

}
else
{
/*Writes the info to a settings file which the program needs for all database connections
and displaying info about the company.
*/
$info="<?
error_reporting  (E_ERROR | E_WARNING | E_PARSE);
\$company=\"$company\";
\$address=\"$address\";
\$phone=\"$phone\";
\$email=\"$email\";
\$server=\"$server\";
\$database=\"$database\";
\$username=\"$username\";
\$password=\"$password\";

\$backgroundcolor=\"$backgroundcolor\";
\$borderwidth=\"$borderwidth\";
\$borderstyle=\"$borderstyle\";
\$textcolor=\"$textcolor\";
\$rowcolor=\"$rowcolor\";
\$alink=\"$alink\";
\$vlink=\"$vlink\";
\$pcolor=\"$pcolor\";
\$hcolor=\"$hcolor\";
\$menu=\"$menu\";
?>";
$open = fopen( "../settings.php", "w+" ) or die ( "Operation Failed!" );
fputs( $open, "$info" );
fclose( $open );

//Creates the Database the user wants
include ("../settings.php");
$db = mysql_connect("$server", "$username", "$password"); 
mysql_query ("CREATE DATABASE $database") ; 
mysql_select_db("$database",$db);



//Puts the correct table structure in the database, so the user can begin to use the program!
$MAKETABLES="


#
# Table structure for table `brands`
#

DROP TABLE IF EXISTS brands;
CREATE TABLE brands (
  Brand varchar(30) NOT NULL default '10',
  ID int(8) NOT NULL auto_increment,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table `brands`
#

# --------------------------------------------------------

#
# Table structure for table `categories`
#

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  Category varchar(30) NOT NULL default '10',
  ID int(8) NOT NULL auto_increment,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table `categories`
#

# --------------------------------------------------------

#
# Table structure for table `customers`
#

DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
  FirstN varchar(25) NOT NULL default '',
  LastN varchar(25) NOT NULL default '',
  AccountNum varchar(10) NOT NULL default '',
  PhoneNum varchar(25) NOT NULL default '',
  Comments varchar(255) NOT NULL default '',
  ID int(6) NOT NULL auto_increment,
  PRIMARY KEY  (ID)
) TYPE=MyISAM COMMENT='Customer Info.';

#
# Dumping data for table `customers`
#

# --------------------------------------------------------

#
# Table structure for table `items`
#

DROP TABLE IF EXISTS items;
CREATE TABLE items (
  ItemName varchar(30) NOT NULL default '',
  ItemID varchar(15) NOT NULL default '',
  Description varchar(255) NOT NULL default '',
  Brand varchar(150) NOT NULL default '',
  Category varchar(60) NOT NULL default '',
  Price varchar(30) NOT NULL default '',
  Tax varchar(30) NOT NULL default '',
  TotalCost varchar(100) NOT NULL default '',
  Quantity int(6) NOT NULL default '0',
  ID int(6) NOT NULL auto_increment,
  PRIMARY KEY  (ID)
) TYPE=MyISAM COMMENT='Item Info';

#
# Dumping data for table `items`
#

# --------------------------------------------------------

#
# Table structure for table `sales`
#

DROP TABLE IF EXISTS sales;
CREATE TABLE sales (
  Date date NOT NULL default '0000-00-00',
  Customer varchar(60) NOT NULL default '',
  Brand varchar(50) NOT NULL default '',
  Category varchar(50) NOT NULL default '',
  Items varchar(30) NOT NULL default '',
  Price varchar(12) NOT NULL default '',
  TotalCost varchar(30) NOT NULL default '',
  Quantity varchar(4) NOT NULL default '',
  Tax varchar(10) NOT NULL default '',
  TaxType varchar(6) NOT NULL default '',
  SoldBy varchar(25) NOT NULL default '',
  ID int(6) NOT NULL auto_increment,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table `sales`
#

# --------------------------------------------------------

#
# Table structure for table `users`
#

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  RealName varchar(50) NOT NULL default '',
  Username varchar(20) NOT NULL default '',
  Password varchar(20) NOT NULL default '',
  Type varchar(30) NOT NULL default '',
  ID int(10) NOT NULL auto_increment,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table `users`
#

INSERT INTO users (RealName, Username, Password, Type, ID) VALUES ('admin', 'admin', 'pointofsale', 'Admin', 1);
";

//Does the query to put it in the database.
$array =explode (';' ,$MAKETABLES ); 
foreach( $array as $single_query )
{
$result =mysql_query ($single_query ,$db ); 
}

echo "The Install process was sucessful and PHP Point Of Sale is now ready to use.  <br> 
To start using the program <a href=../index.php> Go Here</a>";

}

?>
