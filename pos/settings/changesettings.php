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
$rowcolor=$_POST["rowcolor"];
$alink=$_POST["alink"];
$vlink=$_POST["vlink"];
$pcolor=$_POST["pcolor"];
$hcolor=$_POST["hcolor"];
$ContextualMenu=$_POST["ContextualMenu"];

if($ContextualMenu=="set")
{
	$menu="set";

}
else
{

	$menu="notset";

}
//Checks to make sure the required fields were filled out.
if($server=='' or $database=='' or $username=='' or $password=='' or $company=='' or $phone=='' or $backgroundcolor=='' or $borderwidth=='' or $borderstyle=='' or $textcolor=='' or $alink=='' or $vlink=='' or $pcolor=='' or $hcolor=='' or $rowcolor=='' )
{
	echo "You did not provide all the required fields"; 

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

echo"Your settings have been updated sucessfully";
}
?>