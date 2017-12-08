<?php
include ("settings.php");
ob_start();
session_start();

// User is logged in, take in to the menu
if($_SESSION ['Name'] !="")
{
	header("Location: index.php");
	exit;
}

$L_USERNAME=$_POST['L_USERNAME'];
$L_PASSWORD=$_POST['L_PASSWORD'];

$error_msg = "";

if(!($L_USERNAME=="" OR L_PASSWORD==""))
{

  $db = mysql_connect("$server", "$username", "$password");
  mysql_select_db("$database",$db);

  // Formulate the query
  $sql = "SELECT * FROM users WHERE Username='$L_USERNAME' and Password='$L_PASSWORD'";

  // Execute the query and put results in $result
  $result = @mysql_query($sql);

  // Get number of rows in $result. 0 if invalid, 1 if valid.
  $num = @mysql_numrows($result);
  $myrow = mysql_fetch_assoc($result);
  $Name=$myrow[RealName];

  if ($num != "0")
  {
    $_SESSION ['Name'] = "$Name";
    //Redirect will prevent the POST "RETRY" on button refresh
	  header("Location: index.php");
    exit;
  } else {
    $error_msg = "Unable to login with the <b>Username</b> and <b>Password</b> provided.";
  }

}

?> 
<HTML>
<HEAD>
  <title>PHP Point of Sale - Login</title>
</HEAD>
<BODY>
  <div align="center">
  <?php echo $error_msg; ?>
  <p><b>Please Log in:</b></p>
  <form action="login.php" method="Post" name="Login">
  <table width="348" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="85">Username:</td>
    <td><input type="text" name="L_USERNAME" size="24"></td>
  </tr>
  <tr>
    <td width="85">Password:</td>
    <td><input type="password" name="L_PASSWORD" size="24"></td>
    </tr>
  </table>
  <input type="submit" name="Submit" value="Log In">
  </form>
  </div>
</BODY>
</HTML>
