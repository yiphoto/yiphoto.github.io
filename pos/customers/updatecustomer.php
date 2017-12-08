<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/customers.php");
?>
<?
//Updates the information in the database and checks for errors.
include ("../settings.php");
$ID=$_POST['id'];
$FirstN = $_POST['FirstN'];
$LastN = $_POST['LastN'];
$AccountNum = $_POST['AccountNum'];
$PhoneNum = $_POST['PhoneNum'];
$Comments = $_POST['Comments'];
$AddCustomer = $_POST['AddCustomer'];
$msg = "FirstN: $FirstN\nLastN: $LastN\nAccountNum: $AccountNum\nPhoneNum: $PhoneNum\nComments: $Comments\nAddCustomer: $AddCustomer\n";
$err = "../errors/error.php";
$ok = "../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "customers";
$sel = "UPDATE $dbTable SET FirstN=\"$FirstN\", LastN=\"$LastN\", AccountNum=\"$AccountNum\", PhoneNum=\"$PhoneNum\", Comments=\"$Comments\"WHERE ID=$ID"; 



if (!$FirstN || !$LastN || !$AccountNum || !$PhoneNum) {
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
echo"First Name: "."$FirstN"."<BR>";
echo"Last Name: "."$LastN"."<BR>";
echo"Account Number: "."$AccountNum"."<BR>";
echo"Phone Number: "."$PhoneNum"."<BR>";
echo"Comments: "."$Comments"."<BR>";
echo "<BR>";
echo"--------------------";
echo "<BR>";
echo " <a href=managecustomers.php><-- Go back to Customers</a>";
}
?>
<br>
<?

?>
<? include ("../login/obend.php"); ?>