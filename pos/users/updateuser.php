<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/users.php");
?>
<?
//Updates the information in the database and checks for errors.
$ID=$_POST['id'];
$RealName = $_POST['RealName'];
$UserName = $_POST['UserName'];
$Type = $_POST['Type'];
$Password = $_POST['Password'];
$ConfirmPassword=$_POST['ConfirmPassword'];

if($Password!=$ConfirmPassword)
{
	echo "Your passwords do not match, please hit back and try again";
	exit;
}
$msg = "RealName: $RealName\UserName: $UserName\Type: $Type\Password: $Password\n";
$err = "../errors/error.php";
$ok = "../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "users";
$sel = "UPDATE $dbTable SET RealName=\"$RealName\", UserName=\"$UserName\", Type=\"$Type\", Password=\"$Password\" WHERE ID=$ID"; 



if (!$RealName || !$UserName || !$Password) {
include("$err");
exit;
} else {
$conn = @mysql_connect($dbHost, $dbUser, $dbPass);
$dbDB = @mysql_select_db($dbName, $conn);
$result = @mysql_query($sel, $conn);
include("$ok");
echo "<BR>";
echo"--------------------";
echo "<BR>";
echo"Real Name: "."$RealName"."<BR>";
echo"User Name: "."$UserName"."<BR>";
echo"Password: "."$Password"."<BR>";
echo"Type: "."$Type"."<BR>";
echo"--------------------";
echo "<BR>";
echo " <a href=manageusers.php><-- Go back to Users</a>";
}
?>
<br>
<?

?>
<? include ("../login/obend.php"); ?>